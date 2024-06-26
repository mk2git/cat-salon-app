<?php

namespace App\Http\Controllers;

use App\Models\ReserveCreate;
use App\Models\ReserveOptionList;
use App\Models\Reserve;
use App\Models\User;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReserveCreateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses  = Course::all();
        $reserves = ReserveCreate::orderBy('time', 'asc')->get();
        $events   = [];

        foreach ($reserves as $reserve) {
            $reserve->unix_timestamp = strtotime($reserve->date);
            if (isset($events[$reserve->unix_timestamp])) {
                $events[$reserve->unix_timestamp][] = [
                    'id'          => $reserve->id,
                    'date'        => $reserve->date,
                    'time'        => $reserve->time,
                    'course_id' => $reserve->course_id,
                    'course_name' => $reserve->course->course_name,
                    'color' => $reserve->course->color
                ];
            } else {
                $events[$reserve->unix_timestamp] = [];
                $events[$reserve->unix_timestamp][] = [
                    'id'          => $reserve->id,
                    'date'        => $reserve->date,
                    'time'        => $reserve->time,
                    'course_id' => $reserve->course_id,
                    'course_name' => $reserve->course->course_name,
                    'color' => $reserve->course->color
                ];
            }
        }
        $events = json_encode($events);


        return view('reserve-create.index', compact('courses', 'events'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'date' => 'required',
            'time' => 'required',
            'course_id' => 'required'
        ];

        $messages = [
            'date.required' => '日付選択は必須です',
            'time.required' => '時間設定は必須です',
            'course_id.required' => 'コースの選択は必須です'
        ];

        // バリデータの作成
        $validator = Validator::make($request->all(), $rules, $messages);

        // バリデーションエラー時の処理
        if ($validator->fails()) {
            return redirect('reserve/create')
                ->withErrors($validator)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $reserve_create = new ReserveCreate();
            $reserve_create->date = $request->input('date');
            $reserve_create->time = $request->input('time');
            $reserve_create->course_id = $request->input('course_id');
            $reserve_create->save();
            $time = substr($reserve_create->time, 0, 5); 
            $message = $reserve_create->date. ' ' .$time. ' ' . $reserve_create->course->course_name;
            DB::commit();
            return redirect()->route('reserveCreate.index')->with(['message' => '「'.$message.'」が登録されました。', 'type' => 'orange']);
        } catch (\Throwable $th) {
            DB::rollBack();
            logger('Error ReserveCreate Store', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', '予約設定の追加に失敗しました');
        }
    }

    /**
     * Display the specified resource.
     */
    public function showStatus(ReserveCreate $reserveCreate)
    {
        $reserve_creates = ReserveCreate::where('status', config('reserve_create.not reserved yet'))->orwhere('status', config('reserve_create.reserved'))->orderBy('time', 'asc')->get();
        $events   = [];

        foreach ($reserve_creates as $reserve_create) {
                    $reserve_create->unix_timestamp = strtotime($reserve_create->date);
                    if (isset($events[$reserve_create->unix_timestamp])) {
                        $events[$reserve_create->unix_timestamp][] = [
                            'id'          => $reserve_create->id,
                            'date'        => $reserve_create->date,
                            'time'        => $reserve_create->time,
                            'course_id' => $reserve_create->course_id,
                            'course_name' => $reserve_create->course->course_name,
                            'color' => $reserve_create->course->color,
                            'status' => $reserve_create->status
                        ];
                    } else {
                        $events[$reserve_create->unix_timestamp] = [];
                        $events[$reserve_create->unix_timestamp][] = [
                            'id'          => $reserve_create->id,
                            'date'        => $reserve_create->date,
                            'time'        => $reserve_create->time,
                            'course_id' => $reserve_create->course_id,
                            'course_name' => $reserve_create->course->course_name,
                            'color' => $reserve_create->course->color,
                            'status' => $reserve_create->status
                        ];
                    }            
        }
        $events = json_encode($events);
        $courses = Course::all();

        return view('reserve-create.reserve-status', compact('events', 'courses'));
    }

    public function showStatusDetail(ReserveCreate $id)
    {
        $reserve_create = $id;
        $date = $reserve_create->date;
        $time = Carbon::createFromFormat('H:i:s', $reserve_create->time)->format('H:i');
        $user_id = Reserve::where('reserve_create_id', $reserve_create->id)->value('user_id');
        $user_name = User::find($user_id)->name;
        $course_name = $reserve_create->course->course_name;
        $reserve_id = Reserve::where('reserve_create_id', $reserve_create->id)->value('id');
        $options = ReserveOptionList::where('reserve_id', $reserve_id)->get();
        $option_names = $options->pluck('reserve_option.name')->implode(', ');
        $option_prices = $options->pluck('reserve_option.fee')->toArray();
        $option_price = array_sum($option_prices);
        $price = number_format($reserve_create->course->fee + $option_price);

        $reserve = [
            'id' => $reserve_id,
            'date' => $date,
            'time' => $time,
            'user_name' => $user_name,
            'course_name' => $course_name,
            'option' => $option_names,
            'price' => $price
        ];

        return view('reserve-create.reserve-status-detail', compact('reserve'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReserveCreate $id)
    {
        $reserve = $id;
        $courses  = Course::all();
        return view('reserve-create.edit', compact('reserve', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReserveCreate $id)
    {
        $reserve_create = $id;
        try{
            DB::beginTransaction();
            $reserve_create->date = $request->input('date');
            $reserve_create->time = $request->input('time');
            $reserve_create->course_id = $request->input('course_id');
            $reserve_create->save();
            DB::commit();
            return redirect()->route('reserveCreate.index')->with(['message' => '予約可能日の修正ができました。', 'type' => 'orange']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error ReserveCreate Update', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', '予約可能日の編集に失敗しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReserveCreate $id)
    {
        $reserve_create = $id;
        try{
            DB::beginTransaction();
            $time = substr($reserve_create->time, 0, 5); // 時刻部分のみを取得
            $message = $reserve_create->date.' '.$time.' '.$reserve_create->course->course_name;
            $reserve_create->delete();
            DB::commit();
            return redirect()->route('reserveCreate.index')->with(['message' => '「'.$message.'」を削除しました。', 'type' => 'red']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error ReserveCreate Destroy', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', '予約可能日の削除に失敗しました');
        }

    }
}
