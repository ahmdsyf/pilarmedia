<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Dropdown;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backends.dropdowns.index');
    }

    public function getRegencies()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dropdown  $dropdown
     * @return \Illuminate\Http\Response
     */
    public function show(Dropdown $dropdown)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dropdown  $dropdown
     * @return \Illuminate\Http\Response
     */
    public function edit(Dropdown $dropdown)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dropdown  $dropdown
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dropdown $dropdown)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dropdown  $dropdown
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dropdown $dropdown)
    {
        //
    }
}
