<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;

class ChallanDispatchController extends Controller
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
        $clientDetail = DB::table('topland.client_master')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'topland.client_master.city_id')->get();
        return view('challan.dispatch')->with('action', 'INSERT')->with(compact('clientDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authID = Auth::user()->branch_id;
        $client_id = $request->input('client_id');
        $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('from_date'))));
        $to = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('to_date'))));
        if(empty($client_id)){
            $query='';
        }else{
            $query="where billty.client_id in($client_id)";
        }

        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        Fpdf::SetAutoPageBreak(false);
        Fpdf::Ln();
        Fpdf::Cell(195, 10, 'Replacement Dispatch Between ' . $request->input('from_date') . ' To ' . $request->input('to_date'), 'B', 0, 'C');
        Fpdf::Ln();

        Fpdf::SetFont('Verdana-Bold', 'B', 10);

        $result = DB::select("SELECT
	invoice.invoice_no,
	billty.lr_date,
	billty.lr_no,
IF (
	challan.change_bill_address = 'Y',
	challan.billing_name,
	topland.client_master.client_name
) AS client_name,
 topland.transport_master.transport_name,
 date_format(
	challan.created_at,
	'%d/%m/%Y'
) AS challan_date,
 challan.challan_id
FROM
	challan
INNER JOIN invoice ON invoice.challan_id = challan.challan_id
AND invoice.created_at BETWEEN '$from'
AND '$to'
LEFT JOIN (
	topland.city_master
	LEFT JOIN (
		topland.district_master
		LEFT JOIN topland.state_master ON topland.state_master.state_id = topland.district_master.state_id
	) ON topland.district_master.district_id = topland.city_master.district_id
) ON challan.city_id = topland.city_master.city_id
LEFT JOIN billty ON billty.billty_id = challan.billty_id
LEFT JOIN topland.client_master ON topland.client_master.client_id = billty.client_id
LEFT JOIN topland.transport_master ON topland.transport_master.transport_id = billty.transport_id
 WHERE challan.branch_id = '$authID'
 $query
UNION
	SELECT
		'',
		'',
		'',
	IF (
		challan.change_bill_address = 'Y',
		challan.billing_name,
	topland.client_master.client_name
	) AS client_name,
	topland.transport_master.transport_name,
	date_format(
		challan.created_at,
		'%d/%m/%Y'
	) AS challan_date,
	challan.challan_id
FROM
	challan
INNER JOIN credit_note ON credit_note.challan_id = challan.challan_id
AND credit_note.created_at BETWEEN '$from'
AND '$to'
LEFT JOIN (
	topland.city_master
	LEFT JOIN (
		topland.district_master
		LEFT JOIN topland.state_master ON topland.state_master.state_id = topland.district_master.state_id
	) ON topland.district_master.district_id = topland.city_master.district_id
) ON challan.city_id = topland.city_master.city_id
LEFT JOIN billty ON billty.billty_id = challan.billty_id
LEFT JOIN topland.client_master ON topland.client_master.client_id = billty.client_id
LEFT JOIN topland.transport_master ON topland.transport_master.transport_id = billty.transport_id
LEFT JOIN challan_item_master ON challan_item_master.challan_id = challan.challan_id
WHERE challan.branch_id = '$authID'");



        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::SetWidths(array(20, 70, 45, 50, 10));
        Fpdf::Row(array(
            'Inv No' . "\n" . '& Ord Date' . "\n" . 'Complain No.',
            'Party Name' . "\n" . 'City - District - State' . "\n" . 'Destination - Document Through',
            'Transport' . "\n" . 'Lr.No' . "\n" . 'LR Date',
            'Item Description',
            'Qty'), array('L', 'L', 'L', 'L', 'L', 'R'), '', '', true, 4);
//        $item['city_name'] . "    " . $item['district_name'] . "  " . $item['state_name'] . "\n" . $item['destination'] . '    ' .
        foreach ($result as $item) {
            $challan_id = $item->challan_id;
            $string1 = $item->challan_date."\n".$item->invoice_no;
            $string2 = $item->client_name . "\n" .  $item->transport_name;
            $string3 = $item->transport_name . "\n" . $item->lr_no . "\n" . (($item->lr_date != '01/01/1970') ? $item->lr_date : '');
            $product_detail = DB::  select("SELECT
	concat(
		LEFT (topland.brand_master.brand_name, 3),
		' ',
		LEFT (
			upper(
				challan_item_master.packing_type
			),
			1
		),
		' ',
		topland.product_master.product_name
	) AS product_name,
	challan_item_master.quantity
FROM
	challan_item_master
INNER JOIN topland.product_master ON topland.product_master.product_id = challan_item_master.product_id
LEFT JOIN topland.brand_master ON topland.brand_master.brand_id = challan_item_master.brand_id
WHERE
	challan_item_master.challan_id = $challan_id");
            $string4 = '';
            $string5 = '';
            foreach ($product_detail as $product_item) {
                $string4 .= $product_item->product_name . "\n";
                $string5 .= $product_item->quantity . "\n";
            }
            Fpdf::Row(array($string1, $string2, $string3, $string4, $string5), array('L', 'L', 'L', 'L', 'C'), '', '', true, 4);
        }
        Fpdf::SetWidths(array(165, 10, 24));
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Output();
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
