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
        $user_id = $id;
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

        $done_reserves = Reserve::where('user_id', $id)->where('checkout_status', config('reserve.done'))->orderBy('created_at', 'asc')->select('id', 'reserve_create_id')->take(5)->get();
        $done_reserve_records = [];
        foreach($done_reserves as $done_reserve){
            $reserve_create = ReserveCreate::find($done_reserve->reserve_create_id);
            $options = ReserveOptionList::where('reserve_id' , $done_reserve->id)->get();
            $option_names = $options->pluck('reserve_option.name')->implode(', ');
            $done_reserve_records[] = [
                'reserve_id' => $done_reserve->id,
                'date' => $reserve_create->date,
                'course_name' => $reserve_create->course->course_name,
                'options' => $option_names
            ];
        }

        $stamp_done_reserves = Reserve::where('user_id', $id)->where('checkout_status', config('reserve.done'))->orderBy('updated_at', 'asc')->paginate(20);
        $dates = [];
        foreach($stamp_done_reserves as $stamp_done_reserve){
            $get_date = ReserveCreate::where('id', $stamp_done_reserve->reserve_create_id)->value('date');
            $date = \Carbon\Carbon::parse($get_date)->format('Y/m/d');
            $dates[] = [
                'date' => $date
            ];
        }

        return view('user.show', compact('user_id', 'user_name', 'cats', 'reserves', 'done_reserve_records', 'done_reserves', 'dates', 'stamp_done_reserves'));
    }

    public function showRecord($reserve_id)
    {
        $reserve = Reserve::find($reserve_id);
        $record = Record::where('reserve_id', $reserve->id)->first();
        $body_check_id = Record::where('reserve_id', $reserve->id)->value('body_check_id');
        $body_check = BodyCheck::find($body_check_id);
        $course_fee = number_format($reserve->reserve_create->course->fee);
        $options = ReserveOptionList::where('reserve_id', $reserve->id)->get();
        $option_prices = $options->pluck('reserve_option.fee')->toArray();
        $option_price = array_sum($option_prices);
        $totalFee = $reserve->reserve_create->course->fee + $option_price;

        $subTotal = number_format($totalFee);
        $tax = 0.1;

        $onlyTax = number_format($totalFee * $tax);
        $total = number_format($totalFee + ($totalFee * $tax));
        $content = [
            'user_id' => $reserve->user_id,
            'reserve_id' => $reserve->id,
            'date' => $reserve->reserve_create->date,
            'cat_name' => $record->cat_name,
            'cat_species' => $record->cat_species,
            'weight' => $record->weight,
            'ear' => $body_check->ear,
            'eye' => $body_check->eye,
            'hair_loss' => $body_check->hair_loss,
            'hair_ball' => $body_check->hair_ball,
            'others' => $body_check->others,
            'message' => $record->message,
            'course_name' => $reserve->reserve_create->course->course_name,
            'course_fee' => $course_fee,
            'options' => $options,
            'subTotal' => $subTotal,
            'onlyTax' => $onlyTax,
            'total' => $total
        ];
        // dd($content);
        return view('user.show-record', compact('content'));
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
