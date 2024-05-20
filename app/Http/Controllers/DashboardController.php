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
        // roleがadminの場合に使用するデータ
        $todayReserves = [];
        $todayReserveCreates = ReserveCreate::where('date', today())->orderBy('time', 'Asc')->get();
        foreach($todayReserveCreates as $todayReserveCreate){
            $reserves = Reserve::where('reserve_create_id', $todayReserveCreate->id)->get();
            $todayReserves = array_merge($todayReserves, $reserves->toArray());
        }

        $todayReserveLists = [];
        foreach($todayReserves as $todayReserve){
            $reserve_create = ReserveCreate::find($todayReserve['reserve_create_id']);
            $time = Carbon::createFromFormat('H:i:s', $reserve_create->time)->format('H:i');
            $user_name = User::find($todayReserve['user_id'])->name;
            $reserve_id = Reserve::where('reserve_create_id', $todayReserve['reserve_create_id'])->where('user_id', $todayReserve['user_id'])->value('id');
            $options = ReserveOptionList::where('reserve_id', $todayReserve['id'])->get();
            $option_names = $options->pluck('reserve_option.name')->implode(', ');
            $status = Reserve::where('reserve_create_id', $todayReserve['reserve_create_id'])->where('user_id', $todayReserve['user_id'])->value('status');
            $checkout_status = Reserve::where('reserve_create_id', $todayReserve['reserve_create_id'])->where('user_id', $todayReserve['user_id'])->value('checkout_status');

            $todayReserveLists[] = [
                'id' => $reserve_id,
                'time' => $time,
                'user_name' => $user_name,
                'course_name' => $reserve_create->course->course_name,
                'option_names' => $option_names,
                'status' => $status,
                'checkout_status' => $checkout_status
            ];
        }
  
        // roleがgeneralで使用するデータ
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

         // 会計カウント
         $todayReserveCreateIds = ReserveCreate::where('date', today())->select('id')->get();
         $checkout_count = 0;
         foreach($todayReserveCreateIds as $todayReserveCreateId){
            $checkout_count += Reserve::where('reserve_create_id', $todayReserveCreateId->id)->where('status', config('reserve.done'))->where('checkout_status', config('reserve.not yet'))->count();
         }
          
        return view('dashboard', compact('unique_reserve_lists', 'todayReserveLists', 'checkout_count'));
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
