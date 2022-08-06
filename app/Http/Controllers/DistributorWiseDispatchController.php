<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Fpdf;

class DistributorWiseDispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $distributor = DB::table('topland.client_master')
            ->select('client_id','client_name','topland.city_master.city_name')
            ->leftJoin('topland.city_master','topland.city_master.city_id','=','topland.client_master.city_id')
            ->where('c_type','=','DISTRIBUTOR')->get();
        $client = DB::table('topland.client_master')
            ->select('client_id','client_name','topland.city_master.city_name')
            ->leftJoin('topland.city_master','topland.city_master.city_id','=','topland.client_master.city_id')
            ->get();
        return view('distributor_wise.create')->with('action', 'INSERT')->with(compact('client','distributor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $selected_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->post('selected_date'))));
        $client_id = $request->post('client_id');
        $distributor_id = $request->post('distributor_id');
        $type = $request->post('type');

        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 13);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Ln();
        Fpdf::Cell(204, 5, 'Distributor Dispatch Wise Report ', 0, 0, 'C');
        Fpdf::Ln(8);
        Fpdf::SetWidths(array(10, 55, 15, 50, 10, 24, 35));

        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Row(array('SR.', "Party Name & City", 'Inv. No', 'Model Description', 'Qty', 'Amount(Rs.)', 'Transport '), array('C', 'L', 'C', 'L', 'C', 'L', 'L'), '', array(), true);
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(204, 5, $selected_date, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::SetWidths(array(10, 55, 20, 15, 10, 24, 35));
        Fpdf::Output();
        exit();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
