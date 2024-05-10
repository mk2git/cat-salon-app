<?php

namespace App\Http\Controllers;

use App\Models\ReserveCreate;
use App\Models\Course;
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
        $reserves = ReserveCreate::all();
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
    public function show(ReserveCreate $reserveCreate)
    {
        //
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
