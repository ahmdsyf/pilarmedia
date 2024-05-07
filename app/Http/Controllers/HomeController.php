<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getSalesReportSummaries(Request $request)
    {
        // $sales = Sales::select('sales.*', 'products.ProductName as ProductName', 'sales_persons.SalesPersonName as SalesPersonName')
        //     ->leftJoin('products', 'products.ProductId', '=', 'sales.ProductId')
        //     ->leftJoin('sales_persons', 'sales_persons.SalesPersonId', '=', 'sales.SalesPersonId')
        //     ->get();

        $salesPersonId = $request->sales_person;

        $data = [
            'sales' => $salesPersonId,
        ];

        return response()->json($data);
    }
}
