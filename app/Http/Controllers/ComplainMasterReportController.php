<?php

namespace App\Http\Controllers;

use App\Complain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;

class ComplainMasterReportController extends Controller
{
    private $pageType;

    public function __construct()
    {

    }

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
        $clientDetail = DB::table('topland.client_master')->leftJoin('topland.city_master','topland.city_master.city_id','=','topland.client_master.city_id')->get();
        return view('complainmasterreport.create')->with('action', 'INSERT')->with('pageType', $this->pageType)->with(compact('clientDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client_id = $request->input('client_id');
        $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('from_date'))));
        $to = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('to_date'))));

        $complain = DB::table('complain')
            ->select('topland.city_master.city_name', 'complain.*','complain.created_at as complain_date')
            ->join('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->where('complain.branch_id', '=', Auth::user()->branch_id);
        if (!empty($client_id)) {
            $complain = $complain->where('complain.client_id', '=', $client_id);
        }
        $complain = $complain->whereBetween('complain.created_at', [$from, $to])
            ->get();

        $report_type = $request->input('report_type');

        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 13);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Ln();
        Fpdf::Cell(190, 5, 'Complain', 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::Ln();
        foreach ($complain as $key => $items) {
            if ($items->complain_status == $report_type or $report_type == 'All') {
                Fpdf::SetWidths(array(29, 58, 50, 40));
                Fpdf::SetFont('Courier', 'B', 9);
                Fpdf::Row(array('Complain No :', $items->complain_no, "Complain Date : ", date('d.m.Y', strtotime($items->created_at))), array('L', 'L', 'L', 'L'), '', array(), '');
                Fpdf::SetWidths(array(35, 58, 52, 61));
                Fpdf::Row(array('Complain Status :', $items->complain_status), array('L', 'L'), '', array(), '');
                if ($items->complain_status == 'Resolved') {
                    Fpdf::SetWidths(array(29, 45, 65, 40));
                    $Complain_from = Carbon::createFromFormat('Y-m-d H:s:i', $items->complain_date);
                    $complain_to = Carbon::createFromFormat('Y-m-d H:s:i', $items->resolve_date);

                    $diff_in_days = $complain_to->diffInDays($Complain_from);
                    Fpdf::Row(array('Resolve Date :', date('d-m-Y H:i:s', strtotime($items->resolve_date)), "Complain Resolve Duration Day :", $diff_in_days), array('L', 'L', 'L', 'L'), '', array(), '');

                }
                Fpdf::SetWidths(array(35, 58));
                Fpdf::Row(array('Complain Type :', $items->complain_type), array('L', 'L'), '', array(), '');
                Fpdf::SetWidths(array(30, 168));
                Fpdf::Row(array('Party Name :', $items->client_name), array('L', 'L'), '', array(), '');
                Fpdf::SetWidths(array(20, 40, 20, 33, 20, 33));
                Fpdf::Row(array('City :', $items->city_name, 'District:', $items->district, 'State :', $items->state), array('L', 'L', 'L', 'L', 'L', 'L'), '', array(), '');
                Fpdf::Ln();
                $complainProduct = DB::table('complain_item_details')
                    ->select('topland.product_master.product_name', 'complain_item_details.*', 'complain_item_details.warranty', 'complain_item_details.serial_no')
                    ->join('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
                    ->where('complain_item_details.complain_id', '=', $items->complain_id)
                    ->get();
                if ($items->complain_type == 'Product Complain') {

                    Fpdf::SetWidths(array(52, 48, 50, 18, 22));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);

                    Fpdf::Row(array("Product Name", 'Complain', 'Solution', 'Warranty', 'Serial No'), array('L', 'C', 'C', 'C', 'C'), '', array(), true);
                    foreach ($complainProduct as $key => $value) {
                        Fpdf::Row(array($value->product_name, $value->complain, $value->solution, $value->warranty, $value->serial_no), array('L', 'L', 'L', 'C', 'C'), '', array(), true);
                    }
                } else {
                    Fpdf::SetWidths(array(25, 173));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);

                    Fpdf::Row(array('PROBLEM  :-', $items->problem), array('L', 'L'), '', array(), true);
                }
                Fpdf::Ln();
            }
        }
        Fpdf::Output();
        exit();
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
