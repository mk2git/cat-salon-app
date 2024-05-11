<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Models\ReserveCreate;
use App\Models\ReserveOption;
use App\Models\ReserveOptionList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reserves = ReserveCreate::where('status', config('reserve_create.not reserved yet'))->get();
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

        return view('reserve.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $reserve = ReserveCreate::find($id);
        $reserve_options = ReserveOption::all();

        return view('reserve.create', compact('reserve', 'reserve_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            if($data['reserve_option']){
                foreach($data['reserve_option'] as $reserve_option){
                    $reserve_option_list = new ReserveOptionList();
                    $reserve_option_list->user_id = $data['user_id'];
                    $reserve_option_list->reserve_option_id = $reserve_option;
                    $reserve_option_list->save();
                }
            }
            
            $reserve = new Reserve();
            $reserve->user_id = $data['user_id'];
            $reserve->reserve_create_id = $data['reserve_create_id'];
            $reserve->save();

            $reserve_create = ReserveCreate::find($data['reserve_create_id']);
            $reserve_create->status = config('reserve_create.reserved');
            $reserve_create->save();
            $message = 'ok'; 
            // $message = $reserve->reserve_create->date. ' ' .$reserve->reserve_create->time. ' ' .$reserve->reserve_create->course->course_name;

            DB::commit();
            return redirect()->route('dashboard')->with(['message' => '「'.$message.'」の予約が確定されました。', 'type' => 'green']);
        } catch (\Throwable $th) {
            DB::rollBack();
            logger('Error Reserve Store', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', '予約確定に失敗しました');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserve $reserve)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserve $reserve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserve $reserve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserve $reserve)
    {
        //
    }
}
