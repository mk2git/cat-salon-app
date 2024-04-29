<?php

namespace App\Http\Controllers;

use App\Models\ReserveCreate;
use Illuminate\Http\Request;

class ReserveCreateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reserve-create.index');
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
    public function show(ReserveCreate $reserveCreate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReserveCreate $reserveCreate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReserveCreate $reserveCreate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReserveCreate $reserveCreate)
    {
        //
    }
}
