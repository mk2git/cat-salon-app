<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Models\ReserveCreate;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reserves = ReserveCreate::all();
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
    public function create()
    {
        
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
