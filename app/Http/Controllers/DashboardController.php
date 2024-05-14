<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Reserve;
use App\Models\User;
use App\Models\ReserveCreate;
use App\Models\ReserveOption;
use App\Models\ReserveOptionList;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todayReserves = null;
        $todayReserves = ReserveCreate::where('date', today())->where('status', config('reserve_create.reserved'))->get();
        $todayReserveLists = [];
        foreach($todayReserves as $todayReserve){
            $time = Carbon::createFromFormat('H:i:s', $todayReserve->time)->format('H:i');
            $user_id = Reserve::where('reserve_create_id', $todayReserve->id)->value('user_id');
            $user_name = User::find($user_id)->name;
            $reserve_id = Reserve::where('reserve_create_id', $todayReserve->id)->value('id');
            $options = ReserveOptionList::where('reserve_id', $reserve_id)->get();
            $option_names = $options->pluck('reserve_option.name')->implode(', ');
            $status = Reserve::where('reserve_create_id', $todayReserve->id)->value('status');

            $todayReserveLists[] = [
                'id' => $reserve_id,
                'time' => $time,
                'user_name' => $user_name,
                'course_name' => $todayReserve->course->course_name,
                'option_names' => $option_names,
                'status' => $status
            ];
        }

        $reserves = Reserve::where('status', config('reserve.not yet'))->get();
        $options = ReserveOptionList::where('status', config('reserve_option_list.not yet'))->get();
        $reserve_lists = [];
    
        foreach ($reserves as $reserve) {
            $reserve_options = $options->where('reserve_id', $reserve->id);
            $timeFormatted = Carbon::createFromFormat('H:i:s', $reserve->reserve_create->time)->format('H:i');
            $course_name = $reserve->reserve_create->course->course_name;
    
            $option_names = $reserve_options->pluck('reserve_option.name')->implode(', ');
    
            $reserve_lists[] = [
                'id' => $reserve->id,
                'user_id' => $reserve->user_id,
                'date' => $reserve->reserve_create->date,
                'time' => $timeFormatted,
                'course_name' => $course_name,
                'option_names' => $option_names,
            ];
        }
    
        // 重複を削除して結果をまとめる
        $unique_reserve_lists = collect($reserve_lists)->unique(function ($item) {
            return $item['date'].$item['time'].$item['course_name'].$item['option_names'];
        })->sortBy('date')->values()->all();
    
        return view('dashboard', compact('unique_reserve_lists', 'todayReserveLists'));
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
