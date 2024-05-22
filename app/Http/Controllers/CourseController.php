<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        $selected_colors = [];
        foreach($courses as $course){
            $selected_colors[] = [
                'color' => $course->color
            ];
        }

        return view('course.index', compact('courses', 'selected_colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'course_name' => 'required|unique:courses',
            'fee' => 'required',
            'description' => 'required',
            'color' => 'required'
        ];

        $messages = [
            'course_name.required' => 'コース名は必須です',
            'course_name.unique' => 'そのコース名はすでに登録されています',
            'fee.required' => '料金設定は必須です',
            'description.required' => 'コース内容の説明は必須です',
            'color.required' => '色の設定は必須です'
        ];

        // バリデータの作成
        $validator = Validator::make($request->all(), $rules, $messages);

        // バリデーションエラー時の処理
        if ($validator->fails()) {
            return redirect('course')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            DB::beginTransaction();
            $course = new Course();
            $course->course_name = $request->input('course_name');
            $course->fee = $request->input('fee');
            $course->description = $request->input('description');
            $course->color = $request->input('color');
            $course->save();
            DB::commit();
            return redirect()->route('course.index')->with(['message' => '「'.$course->course_name.'」の登録ができました。', 'type' => 'orange']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Course Store', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'コースの追加に失敗しました');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = Course::findOrFail($id); // 指定されたIDに基づいてコースを取得します。存在しない場合は404エラーを返します。

    return view('courses.show', compact('course')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $id)
    {
        $course = $id;   
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Course $id, Request $request)
    {
        // dd($id);
        $rules = [
            'course_name' => 'required',
            'fee' => 'required',
            'description' => 'required',
            'color' => 'required'
        ];

        $messages = [
            'course_name.required' => 'コース名は必須です',
            'fee' => '料金設定は必須です',
            'description.required' => 'コース内容の説明は必須です',
            'color' => '色の設定は必須です',
        ];

        // バリデータの作成
        $validator = Validator::make($request->all(), $rules, $messages);

        // バリデーションエラー時の処理
        if ($validator->fails()) {
            return redirect('course')
                        ->withErrors($validator)
                        ->withInput();
        }
        try{
            DB::beginTransaction();
            $course = $id;
            $course->course_name = $request->input('course_name');
            $course->fee = $request->input('fee');
            $course->description = $request->input('description');
            $course->color = $request->input('color');
            $course->save();
            DB::commit();
            return redirect()->route('course.index')->with(['message' => '「'.$course->course_name.'」の変更ができました。', 'type' => 'green']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Course Update', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'コースの内容の更新に失敗しました');
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $id)
    {
        $course = $id;
        try{
            DB::beginTransaction();
            $message = '「'.$course->course_name.'」を削除しました。';
            $course->delete();
            DB::commit();
            return redirect()->route('course.index')->with(['message' => $message, 'type' => 'red']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Course Destroy', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'コースの内容の削除に失敗しました');
        }
    }
}
