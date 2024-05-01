<?php

namespace App\Http\Controllers;

use App\Models\ReserveOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReserveOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = ReserveOption::all();

        return view('reserve-option.index', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:reserve_options',
            'fee' => 'required',
            'description' => 'required'
        ];

        $messages = [
            'name.required' => 'オプション名は必須です',
            'name.unique' => 'そのオプション名はすでに登録されています',
            'fee.required' => '料金設定は必須です',
            'description.required' => 'オプション内容の説明は必須です'
        ];

        // バリデータの作成
        $validator = Validator::make($request->all(), $rules, $messages);

        // バリデーションエラー時の処理
        if ($validator->fails()) {
            return redirect('option')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            DB::beginTransaction();
            $option = new ReserveOption();
            $option->name = $request->input('name');
            $option->fee = $request->input('fee');
            $option->description = $request->input('description');
            $option->save();
            DB::commit();
            return redirect()->route('reserve-option.index')->with(['message' => '「'.$option->name.'」の登録ができました。']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Option Store', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'オプションの追加に失敗しました');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ReserveOption $reserveOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReserveOption $reserveOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReserveOption $id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'fee' => 'required',
            'description' => 'required'
        ];

        $messages = [
            'name.required' => 'オプション名は必須です',
            'fee.required' => '料金設定は必須です',
            'description.required' => 'オプション内容の説明は必須です'
        ];

        // バリデータの作成
        $validator = Validator::make($request->all(), $rules, $messages);

        // バリデーションエラー時の処理
        if ($validator->fails()) {
            return redirect('option')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            DB::beginTransaction();
            $option = $id;
            $option->name = $request->input('name');
            $option->fee = $request->input('fee');
            $option->description = $request->input('description');
            $option->save();
            DB::commit();
            return redirect()->route('reserve-option.index')->with(['message' => '「'.$option->name.'」の更新をしました']);

        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error ReserveOption Update', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'オプションの更新に失敗しました');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReserveOption $id)
    {
        try{
            DB::beginTransaction();
            $id->delete();
            DB::commit();
            return redirect()->route('reserve-option.index')->with(['message' => '「'.$option->name.'」を削除しました。']);
        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error ReserveOption Destroy', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', 'オプションの削除に失敗しました');
        }
        
    }
}
