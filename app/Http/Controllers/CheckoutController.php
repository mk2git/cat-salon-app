<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\ReserveCreate;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todayReserves = ReserveCreate::where('date', today())->get();
        $checkouts = [];
        foreach($todayReserves as $todayReserve){
            $todayReserveLists = Reserve::where('reserve_create_id', $todayReserve->id)
                                ->where('status', config('reserve.done'))
                                ->where('checkout_status', config('reserve.not yet'))->get();
            if($todayReserveLists->isNotEmpty()){
                $time = Carbon::createFromFormat('H:i:s', $todayReserve->time)->format('H:i');
                $checkouts[] = [
                    'reserve_id' => $todayReserve->reserve->id,
                    'user_name' => $todayReserve->reserve->user->name,
                    'date' => $todayReserve->date,
                    'time' => $time,
                    'course_name' =>$todayReserve->course->course_name,
                ];
            }
        }

        return view('checkout.index', compact('checkouts'));
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
     * Show the form for editing the specified resource.
     */
    public function edit(Reserve $reserve_id)
    {
        dd($reserve_id);
        
        return view('checkout.edit');
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
