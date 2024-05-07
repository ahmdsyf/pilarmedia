<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sales::select('sales.*', 'products.ProductName as ProductName', 'sales_persons.SalesPersonName as SalesPersonName')
            ->leftJoin('products', 'products.ProductId', '=', 'sales.ProductId')
            ->leftJoin('sales_persons', 'sales_persons.SalesPersonId', '=', 'sales.SalesPersonId');

        if(request()->ajax()){
            return Datatables()->of($sales)
                // ->addColumn('action', function($data){
                //     $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-outline-warning btn-sm edit-post"><i class="far fa-edit"></i> Edit</a>';
                //     $button .= '&nbsp;&nbsp;';
                //     $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</button>';
                //     return $button;
                // })
                ->addColumn('ProductName', function($data) {
                    return $data->ProductName;
                })
                ->filterColumn('ProductName', function($query, $keyword) {
                    $query->whereRaw("products.ProductName like ?", ["%$keyword%"]);
                })
                ->addColumn('SalesPersonName', function($data) {
                    return $data->SalesPersonName;
                })
                ->filterColumn('SalesPersonName', function($query, $keyword) {
                    $query->whereRaw("sales_persons.SalesPersonName like ?", ["%$keyword%"]);
                })
                ->editColumn('SalesDate', function($data) {
                    return $data->SalesDate->format('d-m-Y');
                })
                ->filterColumn('SalesDate', function($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(SalesDate,'%d-%m-%Y') like ?", ["%$keyword%"]);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backends.sales.index');
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
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
