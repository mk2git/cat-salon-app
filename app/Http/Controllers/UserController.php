<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Record;
use App\Models\Reserve;
use App\Models\BodyCheck;
use App\Models\ReserveOptionList;
use App\Models\ReserveCreate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'general')->get();
        $count = User::where('role', 'general')->count();

        return view('user.index', compact('users', 'count'));
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
    public function show($id)
    {
        $user_name = User::where('id',$id)->value('name');
        $cats = Record::where('user_id', $id)->select('cat_name', 'cat_species')->distinct()->get();

        $reserves = [];
        $reserveAndReserveCreateIds = Reserve::where('user_id', $id)->where('status', config('reserve.not yet'))->select('id', 'reserve_create_id')->get();

        $options = ReserveOptionList::where('user_id', $id)->where('status', config('reserve_option_list.not yet'))->get();
        foreach($reserveAndReserveCreateIds as $reserveAndReserveCreateId){
            $time = Carbon::createFromFormat('H:i:s', $reserveAndReserveCreateId->reserve_create->time)->format('H:i');
            $reserve_options = $options->where('reserve_id', $reserveAndReserveCreateId->id);
            $option_names = $reserve_options->pluck('reserve_option.name')->implode(', ');
             $reserves[] = [
            'reserve_create_id' => $reserveAndReserveCreateId->reserve_create_id,
            'date' => $reserveAndReserveCreateId->reserve_create->date,
            'time' => $time,
            'course_name' => $reserveAndReserveCreateId->reserve_create->course->course_name,
            'option_names' => $option_names
        ];
        }

        $done_reserves = Reserve::where('user_id', $id)->where('checkout_status', config('reserve.done'))->select('id', 'reserve_create_id')->get();
        $done_reserve_records = [];
        foreach($done_reserves as $done_reserve){
            $reserve_create = ReserveCreate::find($done_reserve->reserve_create_id);
            $done_reserve_records[] = [
                'reserve_id' => $done_reserve->id,
                'date' => $reserve_create->date,
                'course_name' => $reserve_create->course->course_name
            ];
        }

        return view('user.show', compact('user_name', 'cats', 'reserves', 'done_reserve_records'));
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
