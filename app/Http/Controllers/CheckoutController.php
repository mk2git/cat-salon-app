<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\ReserveCreate;
use App\Models\ReserveOption;
use App\Models\ReserveOptionList;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            $message = '本日のサロン内容が更新されました。';
            return view('checkout.checkout-form')->with(['message' => $message, 'type' => 'green']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Checkout Update', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'サロン内容の更新に失敗しました');
        }
        return view('checkout.checkout-form');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
