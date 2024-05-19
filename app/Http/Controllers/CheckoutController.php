<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\ReserveCreate;
use App\Models\ReserveOption;
use App\Models\ReserveOptionList;
use App\Models\Course;
use App\Models\Record;
use App\Models\BodyCheck;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todayReserves = ReserveCreate::where('date', today())->get();
        $checkouts = [];
        foreach($todayReserves as $todayReserve){
            $todayReserveLists = Reserve::where('reserve_create_id', $todayReserve->id)
                                ->where('status', config('reserve.done'))
                                ->where('checkout_status', config('reserve.not yet'))->get();
            if($todayReserveLists->isNotEmpty()){
                $time = Carbon::createFromFormat('H:i:s', $todayReserve->time)->format('H:i');
                $checkouts[] = [
                    'reserve_id' => $todayReserve->reserve->id,
                    'user_name' => $todayReserve->reserve->user->name,
                    'date' => $todayReserve->date,
                    'time' => $time,
                    'course_name' =>$todayReserve->course->course_name,
                ];
            }
        }

        return view('checkout.index', compact('checkouts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserve $reserve_id)
    {
        // dd($reserve_id);
        $options = ReserveOption::all();
        $courses = Course::all();
        $reserve_create = ReserveCreate::find($reserve_id->reserve_create_id);
        $reserve_options = ReserveOptionList::where('reserve_id', $reserve_id->id)->get();
        $reserve_content = [
            'reserve_id' => $reserve_id->id,
            'user_id' => $reserve_create->reserve->user_id,
            'user_name' => $reserve_create->reserve->user->name,
            'course_id' => $reserve_create->course_id,
            'options' => $reserve_options
        ];
        
        return view('checkout.edit', compact('options', 'courses' , 'reserve_content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $reserve_create_id = Reserve::where('id', $request->reserve_id)->value('reserve_create_id');
            $reserve_create = ReserveCreate::find($reserve_create_id);
            $reserve_create->course_id = $request->input('course_id');
            $reserve_create->save();

            $existing_reserve_options = ReserveOptionList::where('reserve_id', $request->reserve_id)->get();
            // 既存のオプションを削除または更新
            $new_options = collect($request->reserve_option);
            // dd($new_options);
            foreach ($existing_reserve_options as $option) {
                if (!$new_options->contains($option->reserve_option_id)) {
                    $option->delete();
                }
            }

            // 新しいオプションを追加
            foreach ($new_options as $option_id) {
                if (!$existing_reserve_options->contains('reserve_option_id', $option_id)) {
                    ReserveOptionList::create([
                        'user_id' => $request->input('user_id'),
                        'reserve_option_id' => $option_id,
                        'reserve_id' => $request->input('reserve_id')
                    ]);
                }
            }
            DB::commit();
            $reserve_id = $request->reserve_id;
            $user_id = $request->user_id;
            $message = '本日のサロン内容が更新されました。';
            return redirect()->route('checkout.showCheckout', ['reserve_id' => $reserve_id, 'user_id' => $user_id])->with(['message' => $message, 'type' => 'green']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Checkout Update', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'サロン内容の更新に失敗しました');
        }
    }

    public function showCheckout(Reserve $reserve_id, $user_id)
    {
        $reserve = $reserve_id;
        $record = Record::where('reserve_id', $reserve->id)->first();
        $body_check_id = Record::where('reserve_id', $reserve->id)->value('body_check_id');
        $body_check = BodyCheck::find($body_check_id);
        $course_fee = number_format($reserve->reserve_create->course->fee);
        $options = ReserveOptionList::where('reserve_id', $reserve->id)->get();
        $option_prices = $options->pluck('reserve_option.fee')->toArray();
        $option_price = array_sum($option_prices);
        $totalFee = $reserve->reserve_create->course->fee + $option_price;

        $subTotal = number_format($totalFee);
        $tax = 0.1;

        $onlyTax = number_format($totalFee * $tax);
        $total = number_format($totalFee + ($totalFee * $tax));
        $content = [
            'user_id' => $reserve->user_id,
            'reserve_id' => $reserve->id,
            'date' => $reserve->reserve_create->date,
            'cat_name' => $record->cat_name,
            'cat_species' => $record->cat_species,
            'weight' => $record->weight,
            'ear' => $body_check->ear,
            'eye' => $body_check->eye,
            'hair_loss' => $body_check->hair_loss,
            'hair_ball' => $body_check->hair_ball,
            'others' => $body_check->others,
            'message' => $record->message,
            'course_name' => $reserve->reserve_create->course->course_name,
            'course_fee' => $course_fee,
            'options' => $options,
            'subTotal' => $subTotal,
            'onlyTax' => $onlyTax,
            'total' => $total
        ];

        return view('checkout.checkout-form', compact('content'));
    }

    public function updateCheckout(Request $request)
    {
        $rule = [
            'payment' => 'required'
        ];
        $message = [
            'payment.required' => '支払い方法の選択は必須です'
        ];
        // バリデータの作成
        $validator = Validator::make($request->all(), $rule, $message);

        // バリデーションエラー時の処理
        if ($validator->fails()) {
            return redirect('checkout/' . $request->reserve_id . '/' .$request->user_id)
                        ->withErrors($validator)
                        ->withInput();
        }
        try{
            DB::beginTransaction();
            $reserve = Reserve::find($request->reserve_id);

            $reserve->checkout_status = config('reserve.done');
            $reserve->payment = $request->input('payment');
            $reserve->save();

            $reserve_option_lists = ReserveOptionList::where('reserve_id', $request->reserve_id)->get();
            foreach($reserve_option_lists as $reserve_option_list){
                $reserve_option_list->status = config('reserve_option_list.done');
                $reserve_option_list->save();
            }
            
            DB::commit();
            return redirect()->route('dashboard')->with(['message' => $reserve->user->name.' 様のお会計ができました。', 'type' => 'orange']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Checkout updateCheckout', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', '支払い方法の更新に失敗しました');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
