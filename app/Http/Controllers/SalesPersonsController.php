<?php

namespace App\Http\Controllers;

use App\Models\SalesPersons;
use Illuminate\Http\Request;

class SalesPersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesPersons = SalesPersons::orderBy('SalesPersonId', 'DESC');
        
        if(request()->ajax()){
            return Datatables()->of($salesPersons)
                // ->addColumn('action', function($data){
                //     $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-outline-warning btn-sm edit-post"><i class="far fa-edit"></i> Edit</a>';
                //     $button .= '&nbsp;&nbsp;';
                //     $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</button>';
                //     return $button;
                // })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backends.sales_persons.index');
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
     * @param  \App\Models\SalesPersons  $salesPersons
     * @return \Illuminate\Http\Response
     */
    public function show(SalesPersons $salesPersons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesPersons  $salesPersons
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesPersons $salesPersons)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesPersons  $salesPersons
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesPersons $salesPersons)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesPersons  $salesPersons
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesPersons $salesPersons)
    {
        //
    }
}
