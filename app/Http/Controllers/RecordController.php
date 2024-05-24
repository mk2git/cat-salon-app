<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Reserve;
use App\Models\User;
use App\Models\ReserveCreate;
use App\Models\ReserveOptionList;
use App\Models\BodyCheck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Reserve $reserve_id)
    {
        $reserve_create = ReserveCreate::find($reserve_id->reserve_create_id);
        $user_id = $reserve_id->user_id;
        $user_name = User::find($user_id)->name;
        $time = Carbon::createFromFormat('H:i:s', $reserve_create->time)->format('H:i');
        $options = ReserveOptionList::where('reserve_id' , $reserve_id->id)->get();
        $option_names = $options->pluck('reserve_option.name')->implode(', ');
        $option_prices = $options->pluck('reserve_option.fee')->toArray();
        $option_price = array_sum($option_prices);

        $price = number_format($reserve_create->course->fee + $option_price);

        $reserve = [
            'id' => $reserve_id->id,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'date' => $reserve_create->date,
            'time' => $time,
            'course_name' => $reserve_create->course->course_name,
            'option' => $option_names,
            'price' => $price
        ];

        // カルテが登録されている場合
        $record_list = null;
        $record = Record::where('reserve_id', $reserve_id->id)->first();
        if($record){
            // $record = Record::where('reserve_id', $reserve_id->id)->first();
            $body_check = BodyCheck::find($record->body_check_id);
            $record_list = [
                'cat_name' => $record->cat_name,
                'cat_species' => $record->cat_species,
                'weight' => $record->weight,
                'ear' => $body_check->ear,
                'eye' => $body_check->eye,
                'hair_loss' => $body_check->hair_loss,
                'hair_ball' => $body_check->hair_ball,
                'others' => $body_check->others,
                'message' => $record->message
            ];
        }
        

        return view('record.create', compact('reserve', 'record_list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'cat_name' => 'required',
            'cat_species' => 'required',
            'weight' => 'required',
            'message' => 'required',
        ];

        $messages = [
            'cat_name.required' => '猫の名前は必須です',
            'cat_species.required' => '猫種は必須です',
            'weight.required' => '体重の入力は必須です',
            'message.required' => 'メッセージは必須です'
        ];

        // バリデータの作成
        $validator = Validator::make($request->all(), $rules, $messages);

        // バリデーションエラー時の処理
        if ($validator->fails()) {
            return redirect('record/' .$request->reserve_id)
                        ->withErrors($validator)
                        ->withInput();
        }
        try{
            DB::beginTransaction();
            $body_check = new BodyCheck();
            $body_check->user_id = $request->input('user_id');
            $body_check->cat_name = $request->input('cat_name');
            $body_check->ear = $request->input('ear');
            $body_check->eye = $request->input('eye');
            $body_check->hair_loss = $request->input('hair_loss');
            $body_check->hair_ball =$request->input('hair_ball');
            $body_check->others =  $request->input('others');
            $body_check->save();

            $record = new Record();
            $record->user_id = $request->input('user_id');
            $record->body_check_id = $body_check->id;
            $record->reserve_id = $request->input('reserve_id');
            $record->cat_name = $request->input('cat_name');
            $record->cat_species = $request->input('cat_species');
            $record->weight = $request->input('weight');
            $record->message = $request->input('message');
            $record->save();

            $reserve_id = $request->input('reserve_id');
            $reserve = Reserve::find($reserve_id);
            $reserve->status = config('reserve.done');
            $reserve->save();

            DB::commit();
            $user_name = User::where('id', $request->user_id)->value('name');
            $message = $request->cat_name;
            return redirect()->route('dashboard')->with(['message' => $user_name.'様の「'.$message.'ちゃん」のカルテが登録されました。', 'type' => 'orange']);
            
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Record Store', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'カルテの登録に失敗しました');
        }

    }

    public function userRecords($user_id)
    {
        $reserves = Reserve::where('user_id', $user_id)->where('checkout_status', config('reserve.done'))->orderBy('created_at', 'desc')->paginate(5);
        $contents = [];

        foreach($reserves as $reserve){
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

            $contents[] = [
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
        }
        
        return view('record.user-records', compact('contents', 'reserves'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->user_id);
        $rules = [
            'cat_name' => 'required',
            'cat_species' => 'required',
            'weight' => 'required',
            'message' => 'required',
        ];

        $messages = [
            'cat_name.required' => '猫の名前は必須です',
            'cat_species.required' => '猫種は必須です',
            'weight.required' => '体重の入力は必須です',
            'message.required' => 'メッセージは必須です'
        ];

        // バリデータの作成
        $validator = Validator::make($request->all(), $rules, $messages);

        // バリデーションエラー時の処理
        if ($validator->fails()) {
            return redirect('record/' .$request->reserve_id)
                        ->withErrors($validator)
                        ->withInput();
        }
        try{
            DB::beginTransaction();
            $record = Record::where('reserve_id', $request->reserve_id)->first();
            $record->cat_name = $request->input('cat_name');
            $record->cat_species = $request->input('cat_species');
            $record->weight = $request->input('weight');
            $record->message = $request->input('message');
            $record->save();

            $body_check = BodyCheck::find($record->body_check_id);
            $body_check->cat_name = $request->input('cat_name');
            $body_check->ear = $request->input('ear');
            $body_check->eye = $request->input('eye');
            $body_check->hair_loss = $request->input('hair_loss');
            $body_check->hair_ball =$request->input('hair_ball');
            $body_check->others =  $request->input('others');
            $body_check->save();

            DB::commit();
            $user_name = User::where('id', $request->user_id)->value('name');
            $message = $request->cat_name;
            return redirect()->route('dashboard')->with(['message' =>  $user_name.'様の「'.$message.'ちゃん」のカルテが更新されました。', 'type' => 'orange']);
            
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Record Update', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'カルテの更新に失敗しました');
        }
    }

}
