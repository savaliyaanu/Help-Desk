<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;

class ProductWiseReportController extends Controller
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
        $productMaster = DB::table('topland.product_master')->get();
        return view('productWise.create')->with('action', 'INSERT')->with(compact('productMaster'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_id = $request->input('product_id');
        $serial_no = $request->input('serial_no');

        $complain_service = $request->input('complain_service');
        $result = DB::table('complain_item_details')
            ->select('topland.product_master.product_name', DB::raw('complain.created_at as complain_date'), 'complain_item_details.*', 'complain.*', 'topland.city_master.city_name', 'complain_item_details.solution as complain_solution')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'complain_item_details.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->where('complain_item_details.complain', '=', $complain_service)
            ->get();
        $i = 1;
        if (!empty($complain_service)) {
            Fpdf::AddPage('L', 'A4');
            Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
            Fpdf::AddFont('Verdana', '', 'Verdana.php');
            Fpdf::SetFont('Verdana-Bold', 'B', 10);
            Fpdf::SetAutoPageBreak(true);
            Fpdf::Ln();
            Fpdf::Cell(270, 5, 'Complain Wise Report', 0, 0, 'C');
            Fpdf::Ln(8);

            Fpdf::SetWidths(array(10,10, 20, 50, 30, 35, 38, 35, 55));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('Sr. No','Com.No', 'Com. Date', 'Client Name', 'City Name', 'Product Name', 'Serial No.', 'Complain', 'Solution'), array('C', 'C','C', 'C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            foreach ($result as $key => $items) {
                Fpdf::Row(array($i++,$items->complain_no, date('d-m-Y', strtotime($items->complain_date)), strtoupper($items->client_name), strtoupper($items->city_name), strtoupper($items->product_name), strtoupper($items->serial_no), $items->complain, $items->complain_solution), array('C', 'C', 'L', 'L', 'L', 'L', 'L', 'L', 'L'), '', array(), true);
            }
            Fpdf::Ln(6);
            Fpdf::Output();
            exit();
        }

        $invoice = DB::select("SELECT
	complain.client_name,challan_item_master.*,complain.*,complain.created_at as complain_date,topland.city_master.city_name,topland.product_master.product_name,(SELECT complain FROM complain_item_details WHERE complain_item_details.complain_id = complain.complain_id LIMIT 1) as complain_service
FROM
	invoice_items
LEFT JOIN challan_item_master ON challan_item_master.challan_product_id = invoice_items.challan_product_id
LEFT JOIN complain_item_details ON complain_item_details.cid_id = challan_item_master.complain_product_id
LEFT JOIN challan ON challan.challan_id = challan_item_master.challan_id
LEFT JOIN billty ON billty.billty_id = challan.billty_id
LEFT JOIN complain ON complain.complain_id = billty.complain_id
LEFT JOIN topland.city_master ON topland.city_master.city_id = complain.city_id
LEFT JOIN topland.product_master ON topland.product_master.product_id = invoice_items.product_id
WHERE
	complain_item_details.product_id = $product_id
	AND complain_item_details.serial_no = $serial_no");

        if (empty($product_id) && empty($serial_no)) {
            $request->session()->flash('delete-status', 'Data not Found......!');
            return redirect('product-wise-report/create');
        }
        if (!empty($product_id) || !empty($serial_no)) {
            Fpdf::AddPage();
            Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
            Fpdf::AddFont('Verdana', '', 'Verdana.php');
            Fpdf::SetFont('Verdana-Bold', 'B', 10);
            Fpdf::SetAutoPageBreak(true);
            Fpdf::Ln();
            Fpdf::Cell(190, 5, 'Product Wise Report', 0, 0, 'C');
            Fpdf::Ln(8);
            if (!empty($invoice)) {
                Fpdf::SetFont('Verdana-Bold', 'B', 10);
                Fpdf::Cell(190, 5, 'Invoice', 0, 0, 'C');
                Fpdf::Ln(8);
            }

            if (!empty($serial_no)) {
                foreach ($invoice as $key => $items) {
                    Fpdf::SetWidths(array(28, 55, 50, 61));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(32, 5, 'Complain No :', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(100, 5, $items->complain_no, '', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(12, 5, 'Complain Date :', '', 0, 'R');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(38, 5, date('d-m-Y', strtotime($items->complain_date)), '', 0, 'L');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(24, 5, 'Party Name :', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(100, 5, $items->client_name, '', 0, 'L');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(13, 5, 'City :', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(60, 5, $items->city_name, '', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(12, 5, 'District :', '', 0, 'R');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(55, 5, $items->district, '', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(12, 5, 'State :', '', 0, 'R');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(38, 5, $items->state, '', 0, 'L');
                    Fpdf::Ln(8);
                    Fpdf::SetWidths(array(30, 20, 50, 50, 17, 20, 10));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array('Product Name', 'Serial No.', 'Complain', 'Solution', 'Warranty', 'Pro. No', 'Qty'), array('C', 'C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Row(array(strtoupper($items->product_name), strtoupper($items->serial_no), $items->complain_service, $items->solution, $items->warranty, $items->production_no, $items->quantity), array('L', 'C', 'L', 'L', 'C', 'L', 'C'), '', array(), true);
                    Fpdf::Ln(6);
                }
            }
            $creditNote = DB::select("SELECT
	complain.client_name,complain_item_details.solution,challan_item_master.*,complain.*,complain.created_at as complain_date,topland.city_master.city_name,topland.product_master.product_name,(SELECT complain FROM complain_item_details WHERE complain_item_details.complain_id = complain.complain_id LIMIT 1) as complain_service
FROM
	credit_note_item
LEFT JOIN challan_item_master ON challan_item_master.challan_product_id = credit_note_item.challan_product_id
LEFT JOIN complain_item_details ON complain_item_details.cid_id = challan_item_master.complain_product_id
LEFT JOIN challan ON challan.challan_id = challan_item_master.challan_id
LEFT JOIN billty ON billty.billty_id = challan.billty_id
LEFT JOIN complain ON complain.complain_id = billty.complain_id
LEFT JOIN topland.city_master ON topland.city_master.city_id = complain.city_id
LEFT JOIN topland.product_master ON topland.product_master.product_id = credit_note_item.product_id
WHERE
	credit_note_item.product_id = $product_id
	AND challan_item_master.serial_no = $serial_no");
            if (!empty($creditNote)) {
                Fpdf::SetFont('Verdana-Bold', 'B', 10);
                Fpdf::Cell(190, 5, 'Credit Note', 0, 0, 'C');
                Fpdf::Ln(8);
            }
            if (!empty($serial_no)) {
                foreach ($creditNote as $key => $items) {
                    Fpdf::SetWidths(array(28, 55, 50, 61));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(32, 5, 'Complain No :', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(100, 5, $items->complain_no, '', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(12, 5, 'Complain Date :', '', 0, 'R');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(38, 5, date('d-m-Y', strtotime($items->complain_date)), '', 0, 'L');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(24, 5, 'Party Name :', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(100, 5, $items->client_name, '', 0, 'L');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(13, 5, 'City :', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(60, 5, $items->city_name, '', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(12, 5, 'District :', '', 0, 'R');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(55, 5, $items->district, '', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(12, 5, 'State :', '', 0, 'R');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(38, 5, $items->state, '', 0, 'L');
                    Fpdf::Ln(8);
                    Fpdf::SetWidths(array(30, 20, 50, 50, 17, 20, 10));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array('Product Name', 'Serial No.', 'Complain', 'Solution', 'Warranty', 'Pro. No', 'Qty'), array('C', 'C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Row(array(strtoupper($items->product_name), strtoupper($items->serial_no), $items->application, $items->solution, $items->warranty, $items->production_no, $items->quantity), array('L', 'C', 'L', 'L', 'C', 'L', 'C'), '', array(), true);
                    Fpdf::Ln(6);
                }
            }
            $destroy = DB::select("SELECT
	complain.client_name,challan_item_master.*,complain.*,complain.created_at as complain_date,topland.city_master.city_name,topland.product_master.product_name,(SELECT complain FROM complain_item_details WHERE complain_item_details.complain_id = complain.complain_id LIMIT 1) as complain_service
FROM
	destroy_item
LEFT JOIN challan_item_master ON challan_item_master.challan_product_id = destroy_item.challan_product_id
LEFT JOIN challan ON challan.challan_id = challan_item_master.challan_id
LEFT JOIN billty ON billty.billty_id = challan.billty_id
LEFT JOIN complain ON complain.complain_id = billty.complain_id
LEFT JOIN topland.city_master ON topland.city_master.city_id = complain.city_id
LEFT JOIN topland.product_master ON topland.product_master.product_id = destroy_item.product_id
WHERE
	destroy_item.product_id = $product_id
	AND challan_item_master.serial_no = $serial_no");
            if (empty($serial_no)) {
                Fpdf::SetFont('Verdana-Bold', 'B', 10);
                Fpdf::Cell(190, 5, 'Destroy', 0, 0, 'C');
                Fpdf::Ln(8);
            }
            if (empty($serial_no)) {
                foreach ($destroy as $key => $items) {
                    Fpdf::SetWidths(array(28, 55, 50, 61));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(32, 5, 'Complain No :', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(100, 5, $items->complain_no, '', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(12, 5, 'Complain Date :', '', 0, 'R');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(38, 5, date('d-m-Y', strtotime($items->complain_date)), '', 0, 'L');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(24, 5, 'Party Name :', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(100, 5, $items->client_name, '', 0, 'L');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(13, 5, 'City :', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(60, 5, $items->city_name, '', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(12, 5, 'District :', '', 0, 'R');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(55, 5, $items->district, '', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(12, 5, 'State :', '', 0, 'R');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(38, 5, $items->state, '', 0, 'L');
                    Fpdf::Ln(8);
                    Fpdf::SetWidths(array(30, 20, 50, 50, 17, 20, 10));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array('Product Name', 'Serial No.', 'Complain', 'Solution', 'Warranty', 'Pro. No', 'Qty'), array('C', 'C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Row(array(strtoupper($items->product_name), strtoupper($items->serial_no), $items->application, $items->solution, $items->warranty, $items->production_no, $items->quantity), array('L', 'C', 'L', 'L', 'C', 'L', 'C'), '', array(), true);
                    Fpdf::Ln(6);
                }
            }
            Fpdf::Output();
            exit();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }

    public
    function getSerialNumber(Request $request)
    {
        $product_id = $request->input('product_id');
//        print_r($product_id);exit();
        $productList =
            DB::table('complain_item_details')
                ->select('serial_no', 'complain.client_name')
                ->leftJoin('complain', 'complain.complain_id', '=', 'complain_item_details.complain_id')
                ->where('product_id', '=', $product_id)
                ->get()
                ->toArray();
        $productList = json_decode(json_encode($productList), true);
        $option = "<option value=''>Select Serial No</option>";
        foreach ($productList as $row) {
            $option .= "<option value='" . $row['serial_no'] . "'>" . $row['serial_no'] . ' (' . $row['client_name'] . ')' . "</option>";
        }
        echo $option;
    }
}
