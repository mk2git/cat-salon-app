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
        $courses = Course::all();
        $reserves = ReserveCreate::select('date', 'time', 'course_id')->get();
        $events = [];

        foreach($reserves as $reserve){
            $events[] = [
                'title' => $reserve->course->course_name. '：' .$reserve->course->description,
                'start' => $reserve->date . 'T' . $reserve->time,
            ];
        }

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
        try{
            DB::beginTransaction();
            $reserve_create = new ReserveCreate();
            $reserve_create->date = $request->input('date');
            $reserve_create->time = $request->input('time');
            $reserve_create->course_id = $request->input('course_id');
            $reserve_create->save();
            DB::commit();
            return redirect()->route('reserveCreate.index')->with(['message' => '予約可能日の登録ができました。']);
        }catch(\Throwable $th){
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
    public function edit(ReserveCreate $reserveCreate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReserveCreate $reserveCreate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReserveCreate $reserveCreate)
    {
        //
    }
}
