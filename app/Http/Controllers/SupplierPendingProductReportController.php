<?php

namespace App\Http\Controllers;

use App\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;

class SupplierPendingProductReportController extends Controller
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
        $supplierDetail = DB::table('topland.supplier_master')->get();
        $branch = Branch::where('branch_id', '=', Auth::user()->branch_id)
            ->get();
        return view('supplierReport.create')->with('action', 'INSERT')->with(compact('supplierDetail', 'branch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $report_type = $request->input('report_type');
        $supplier_id = $request->input('supplier_id');
        $branch_id = $request->input('branch_id');
        $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('from_date'))));
        $to = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('to_date'))));

        $branchDetail = Branch::where('branch_id', '=', $branch_id)->first();
        $queryResult = DB::table('delivery_challan_out')
            ->select('topland.supplier_master.supplier_name', 'challan.challan_id', 'complain.client_name', 'complain.complain_no', 'complain.created_at as complain_date', 'delivery_challan_out.branch_id',
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = delivery_challan_out.financial_id) as fyear"),
                'topland.supplier_master.city', 'topland.supplier_master.state', 'topland.supplier_master.district', 'delivery_challan_out.status', 'delivery_challan_out.delivery_challan_out_id')
            ->leftJoin('topland.supplier_master', 'topland.supplier_master.supplier_id', '=', 'delivery_challan_out.supplier_id')
            ->leftJoin('challan', 'challan.challan_id', '=', 'delivery_challan_out.challan_id')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->where('delivery_challan_out.branch_id', '=', $branch_id);
        if (!empty($supplier_id)) {
            $queryResult->where('delivery_challan_out.supplier_id', '=', $supplier_id);
        }
        if ($report_type == 'Pending') {
            $queryResult->where('delivery_challan_out.status', '=', 'Pending');
        }
        $queryResult->where(DB::raw('DATE_FORMAT(delivery_challan_out.created_at,"%Y-%m-%d")'), '>=', $from);
        $queryResult->where(DB::raw('DATE_FORMAT(delivery_challan_out.created_at,"%Y-%m-%d")'), '<=', $to);
        $complainDetail = $queryResult->get();
//echo "<pre>";
//print_r($complainDetail);exit;


        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 13);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Cell(190, 5, $branchDetail->branch_name, 0, 0, 'C');
        Fpdf::Ln(6);
        Fpdf::Cell(190, 5, 'SUPPLIER PENDING PRODUCT REPORT', 0, 0, 'C');
        Fpdf::Ln(6);
        Fpdf::Cell(190, 5, 'DATE BETWEEN ' . date('d-m-y', strtotime($from)) . ' TO ' . date('d-m-y', strtotime($to)), 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::Ln();
        $totalNos = 0;
        foreach ($complainDetail as $key => $items) {
            if ($items->branch_id == 1) {
                $complains_no = 'PF-TKT/' . $items->fyear . '/' . $items->complain_no;
            } elseif ($items->branch_id == 3) {
                $complains_no = 'TE-TKT/' . $items->fyear . '/' . $items->complain_no;
            } elseif ($items->branch_id == 4) {
                $complains_no = 'TP-TKT/' . $items->fyear . '/' . $items->complain_no;
            }
//            if ($report_type == 'All') {

            Fpdf::SetFont('Courier', 'B', 10);

            Fpdf::Cell(25, 5, 'COMPLAIN NO :  ', 'LT', 0, 'L');
            Fpdf::Cell(50, 5, '  ' . $items->complain_no, 'T', 0, 'L');
            Fpdf::Cell(25, 5, "DATE : ", 'T', 0, 'L');
            Fpdf::Cell(50, 5, date('d-m-Y', strtotime($items->complain_date)), 'T', 0, 'L');
            Fpdf::Cell(20, 5, "STATUS : ", 'T', 0, 'L');
            Fpdf::Cell(27, 5, $items->status, 'TR', 1, 'L');


            Fpdf::Cell(27, 5, "SUPPLIER NAME : ", 'L', 0, 'L');
            Fpdf::CellFitScale(170, 5, '   ' . $items->supplier_name, 'R', 1, 'L');

            Fpdf::Cell(25, 5, "CITY : ", 'L', 0, 'L');
            Fpdf::CellFitScale(50, 5, $items->city, '', 0, 'L');
            Fpdf::Cell(25, 5, "DISTRICT:", '', 0, 'L');
            Fpdf::CellFitScale(50, 5, $items->district, '', 0, 'L');
            Fpdf::Cell(20, 5, "STATE :", '', 0, 'L');
            Fpdf::CellFitScale(27, 5, $items->state, 'R', 1, 'L');

            Fpdf::SetWidths(array(12, 100, 41, 22, 22));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);

            $supplier_product = DB::table('delivery_challan_out_product')
                ->select('topland.product_master.product_name', 'challan_item_master.serial_no', 'challan_item_master.quantity', 'challan_item_master.warranty')
                ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'delivery_challan_out_product.challan_product_id')
                ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id')
                ->where('delivery_challan_out_id', '=', $items->delivery_challan_out_id)
                ->get();

            $i = 1;
            Fpdf::Row(array('NO.', "ITEM DESCRIPTION", 'SERIAL NO.', 'WARRANTY', 'QTY'), array('C', 'L', 'C', 'C', 'C'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::SetWidths(array(12, 100, 41, 22, 22));
            foreach ($supplier_product as $value) {
                Fpdf::Row(array($i++, $value->product_name, $value->serial_no, $value->warranty, $value->quantity), array('C', 'L', 'C', 'C', 'C'), '', array(), true);
                $totalNos = $totalNos + $value->quantity;
            }
            Fpdf::Ln();
//            }
        }
        Fpdf::SetFont('Courier', 'B', 12);
        Fpdf::SetWidths(array(175, 22));
        Fpdf::Row(array('Total Nos : ', $totalNos), array('R', 'C'), '', array(), true);
        Fpdf::Output();
        exit();
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
