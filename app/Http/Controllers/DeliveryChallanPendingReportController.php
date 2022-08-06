<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Fpdf;


class DeliveryChallanPendingReportController extends Controller
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
        $complain_no = DB::table('delivery_challan_out')
            ->select('complain.*')
            ->leftJoin('challan', 'challan.challan_id', '=', 'delivery_challan_out.challan_id')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->get();
//        print_r($complain_no);die();
        return view('deliverychallan.pending')->with('action', 'INSERT')->with(compact('complain_no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = $request->input('status');

        $complainDetail = DB::table('delivery_challan_out')
            ->select('complain.complain_no', 'complain.complain_id', 'complain.client_name', 'complain.district', 'complain.state', 'topland.city_master.city_name', 'delivery_challan_out.created_at')
            ->leftJoin('challan', 'challan.challan_id', '=', 'delivery_challan_out.challan_id')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->where('complain.complain_id', '=', $request->input('complain_id'))
            ->get();
        $complainProduct = DB::table('delivery_challan_out')
            ->select('topland.product_master.product_name')
            ->leftJoin('delivery_challan_out_product', 'delivery_challan_out_product.delivery_challan_out_id', '=', 'delivery_challan_out.delivery_challan_out_id')
            ->leftJoin('challan', 'challan.challan_id', '=', 'delivery_challan_out.challan_id')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'delivery_challan_out_product.challan_product_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id')
            ->where('complain.complain_id', '=', $complainDetail[0]->complain_id)
            ->get();

        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 13);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Ln();

        if ($status == 'Out') {
            Fpdf::Cell(190, 5, 'Delivery Challan Out Product', 0, 0, 'C');
            Fpdf::Ln();
            Fpdf::Ln();
            Fpdf::SetWidths(array(29, 58, 50, 40));
            Fpdf::SetFont('Courier', 'B', 9);
            Fpdf::Row(array('Complain No :', $complainDetail[0]->complain_no, "Delivery Challan Date : ", date('d.m.Y', strtotime($complainDetail[0]->created_at))), array('L', 'L', 'L', 'L'), '', array(), '');
            Fpdf::SetWidths(array(35, 58, 52, 61));
            Fpdf::SetWidths(array(30, 168));
            Fpdf::Row(array('Party Name :', $complainDetail[0]->client_name), array('L', 'L'), '', array(), '');
            Fpdf::SetWidths(array(20, 40, 20, 33, 20, 33));
            Fpdf::Row(array('City :', $complainDetail[0]->city_name, 'District:', $complainDetail[0]->district, 'State :', $complainDetail[0]->state), array('L', 'L', 'L', 'L', 'L', 'L'), '', array(), '');
            Fpdf::Ln();
            Fpdf::SetWidths(array(20, 175));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('Sr No', "Product Name"), array('C', 'C'), '', array(), true);
            $temp = 0;
            foreach ($complainProduct as $key => $value) {
                $temp++;
                Fpdf::Row(array($temp, $value->product_name), array('C', 'L'), '', array(), true);
            }
        } else {
            $inward_product = DB::table('delivery_challan_out')
                ->select('topland.product_master.product_name')
                ->leftJoin('delivery_challan_out_product', 'delivery_challan_out_product.delivery_challan_out_id', '=', 'delivery_challan_out.delivery_challan_out_id')
                ->leftJoin('challan', 'challan.challan_id', '=', 'delivery_challan_out.challan_id')
                ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
                ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
                ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'delivery_challan_out_product.challan_product_id')
                ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id')
                ->where('complain.complain_id', '=', $complainDetail[0]->complain_id)
                ->where('delivery_challan_out_product.is_inward', '=', 'Y')
                ->get();


            Fpdf::Cell(190, 5, 'Delivery Challan Inward Product', 0, 0, 'C');
            Fpdf::Ln();
            Fpdf::Ln();
            Fpdf::SetWidths(array(29, 58, 50, 40));
            Fpdf::SetFont('Courier', 'B', 9);
            Fpdf::Row(array('Complain No :', $complainDetail[0]->complain_no, "Delivery Challan Date : ", date('d.m.Y', strtotime($complainDetail[0]->created_at))), array('L', 'L', 'L', 'L'), '', array(), '');
            Fpdf::SetWidths(array(35, 58, 52, 61));
            Fpdf::SetWidths(array(30, 168));
            Fpdf::Row(array('Party Name :', $complainDetail[0]->client_name), array('L', 'L'), '', array(), '');
            Fpdf::SetWidths(array(20, 40, 20, 33, 20, 33));
            Fpdf::Row(array('City :', $complainDetail[0]->city_name, 'District:', $complainDetail[0]->district, 'State :', $complainDetail[0]->state), array('L', 'L', 'L', 'L', 'L', 'L'), '', array(), '');
            Fpdf::Ln();

            Fpdf::SetWidths(array(20, 175));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('Sr No', "Product Name"), array('C', 'C'), '', array(), true);
            $temp = 0;
            foreach ($inward_product as $key => $value) {
                $temp++;
                Fpdf::Row(array($temp, $value->product_name), array('C', 'L'), '', array(), true);
            }
        }
        Fpdf::Ln();
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
