<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Models\ReserveCreate;
use App\Models\ReserveOption;
use App\Models\ReserveOptionList;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

            if($request->has('reserve_option')){
                $data = $request->all();
                $reserve = new Reserve();
                $reserve->user_id = $data['user_id'];
                $reserve->reserve_create_id = $data['reserve_create_id'];
                $reserve->save();
                $reserve_id = $reserve->id;

                foreach($data['reserve_option'] as $reserve_option){
                    $reserve_option_list = new ReserveOptionList();
                    $reserve_option_list->user_id = $data['user_id'];
                    $reserve_option_list->reserve_id = $reserve_id;
                    $reserve_option_list->reserve_option_id = $reserve_option;
                    $reserve_option_list->save();
                }
            }else{
                $data = $request->all();
                $reserve = new Reserve();
                $reserve->user_id = $data['user_id'];
                $reserve->reserve_create_id = $data['reserve_create_id'];
                $reserve->save();
            }

            $reserve_create = ReserveCreate::find($data['reserve_create_id']);
            $reserve_create->status = config('reserve_create.reserved');
            $reserve_create->save();
            DB::commit();

            $time = Carbon::createFromFormat('H:i:s', $reserve->reserve_create->time)->format('H:i');
            $message = $reserve->reserve_create->date. '   ' .$time. '   ' .$reserve->reserve_create->course->course_name;
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
    public function edit(Reserve $reserve_id)
    {   
        $reserve_create = ReserveCreate::find($reserve_id->reserve_create_id);
        $time = Carbon::createFromFormat('H:i:s', $reserve_create->time)->format('H:i');
        $options = ReserveOptionList::where('reserve_id' , $reserve_id->id)->get();
        $option_names = $options->pluck('reserve_option.name')->implode(', ');
        $option_prices = $options->pluck('reserve_option.fee')->toArray();
        $option_price = array_sum($option_prices);

        $price = number_format($reserve_create->course->fee + $option_price);

        $reserve = [
            'id' => $reserve_id->id,
            'date' => $reserve_create->date,
            'time' => $time,
            'course_name' => $reserve_create->course->course_name,
            'option' => $option_names,
            'price' => $price
        ];

        return view('reserve.edit', compact('reserve'));
    }

    public function cancel(Reserve $reserve_id)
    {
        try{
            DB::beginTransaction();
            $reserve = $reserve_id;
            $reserve->status = config('reserve.cancel');
            $reserve->save();

            $reserve_create = ReserveCreate::find($reserve->reserve_create_id);
            $reserve_create->status = config('reserve_create.not reserved yet');
            $reserve_create->save();

            $reserve_option_lists = ReserveOptionList::where('reserve_id', $reserve_id->id)->get();
            foreach($reserve_option_lists as $reserve_option_list){
                $reserve_option_list->status = config('reserve_option_list.cancel');
                $reserve_option_list->save();
            }
            DB::commit();

            $message = $reserve->reserve_create->date;
            return redirect()->route('dashboard')->with(['message' => '「' .$message. '」の予約をキャンセルしました。', 'type' => 'red']);

        }catch(\Throwable $th){
            DB::rollBack();
            logger('Error Reserve Cancel', ['message' => $th->getMessage()]);
            return redirect()->back()->with('error', '予約のキャンセルに失敗しました');
        }
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
