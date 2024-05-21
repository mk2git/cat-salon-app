<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;

class StampController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $done_reserves = Reserve::where('user_id', $id)->where('checkout_status', config('reserve.done'))->get();
        $dates = [];
        foreach($done_reserves as $done_reserve){
            $dates[] = [
                'date' => $done_reserve->reserve_create->date
            ];
        }

        return view('stamp.show', compact('dates'));
    }

}
