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
        return view('course.index');
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
            'course_name' => 'required|unique:courses',
            'description' => 'required'
        ];

        $messages = [
            'course_name.required' => 'コース名は必須です',
            'course_name.unique' => 'そのコース名はすでに登録されています',
            'description.required' => 'コース内容の説明は必須です'
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
            $course->description = $request->input('description');
            $course->save();
            DB::commit();
            return redirect()->route('course.index')->with(['message' => '「'.$course->course_name.'」の登録ができました。']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Course Store', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'コースの追加に失敗しました');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
