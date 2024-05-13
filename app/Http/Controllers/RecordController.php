<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Reserve;
use App\Models\User;
use App\Models\ReserveCreate;
use App\Models\ReserveOptionList;
use App\Models\BodyCheck;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Reserve $reserve_id)
    {
        $reserve_create = ReserveCreate::find($reserve_id->reserve_create_id);
        $user_id = Reserve::where('reserve_create_id', $reserve_create->id)->value('user_id');
        $user_name = User::find($user_id)->name;
        $time = Carbon::createFromFormat('H:i:s', $reserve_create->time)->format('H:i');
        $options = ReserveOptionList::where('reserve_id' , $reserve_id->id)->get();
        $option_names = $options->pluck('reserve_option.name')->implode(', ');
        $option_prices = $options->pluck('reserve_option.fee')->toArray();
        $option_price = array_sum($option_prices);

        $price = number_format($reserve_create->course->fee + $option_price);

        $reserve = [
            'id' => $reserve_id->id,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'date' => $reserve_create->date,
            'time' => $time,
            'course_name' => $reserve_create->course->course_name,
            'option' => $option_names,
            'price' => $price
        ];

        return view('record.create', compact('reserve'));
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
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        //
    }
}
