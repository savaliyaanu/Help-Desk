<?php

namespace App\Http\Controllers;

use App\Branch;
use App\CreditNote;
use Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreditNoteReportController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $clientDetail = DB::table('topland.client_master')->get();
        $branch = Branch::leftjoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('branch_master.company_id', '=', Auth::user()->branch_id)
            ->get();
        return view('creditnotereport.create')->with('action', 'INSERT')->with('pageType', $this->pageType)->with('clientDetail', $clientDetail)->with('branch', $branch);
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

        $query = CreditNote::select(DB::raw("(select SUM(credit_note_item.amount) from credit_note_item  WHERE credit_note_item.credit_note_id = credit_note.credit_note_id) as amount"),
            'challan.*', 'credit_note.*')
            ->with('getchallan.getBilltyDetail.getClients.getCity.getDistrict.getState')
            ->with('getchallan.getCity.getDistrict.getState')
            ->leftJoin('challan', 'challan.challan_id', '=', 'credit_note.challan_id')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->where('credit_note.branch_id', '=', Auth::user()->branch_id)
            ->where(DB::raw('DATE_FORMAT(credit_note.created_at,"%Y-%m-%d")'), '>=', $from)
            ->where(DB::raw('DATE_FORMAT(credit_note.created_at,"%Y-%m-%d")'), '<=', $to);
        if (!empty($client_id)) {
            $query->where('billty.client_id', $client_id);
        }
        $creditIndex = $query->get();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Ln();
        Fpdf::Cell(190, 5, 'Credit Note Between ' . $request->input('from_date') . ' To ' . $request->input('to_date'), 0, 0, 'C');
        Fpdf::Ln(8);
        foreach ($creditIndex as $key => $items) {

            if ($items->getchallan->change_bill_address == 'Y') {
                $client_name = $items->getchallan->billing_name;
                $city_name = $items->getchallan->getCity->city_name;
                $district_name = $items->getchallan->getCity->getDistrict->district_name;
                $state_name = $items->getchallan->getCity->getDistrict->getState->state_name;
            } else {
                $client_name = $items->getchallan->getBilltyDetail->getClients->client_name;
                $city_name = $items->getchallan->getBilltyDetail->getClients->getCity->city_name;
                $district_name = $items->getchallan->getBilltyDetail->getClients->getCity->getDistrict->district_name;
                $state_name = $items->getchallan->getBilltyDetail->getClients->getCity->getDistrict->getState->state_name;
            }

            Fpdf::SetWidths(array(28, 55, 50, 61));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(32, 5, 'Credit Note No :', '', 0, 'L');
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(100, 5, $items->credit_note_no, '', 0, 'L');
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(12, 5, 'Credit Note Date :', '', 0, 'R');
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(38, 5, date('d-m-Y', strtotime($items->created_at)), '', 0, 'L');
            Fpdf::Ln();
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(24, 5, 'Challan No :', '', 0, 'L');
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(100, 5, $items->getchallan->challan_no, '', 0, 'L');
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(12, 5, 'Challan Date :', '', 0, 'R');
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(38, 5, date('d-m-Y', strtotime($items->getchallan->created_at)), '', 0, 'L');
            Fpdf::Ln();
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(24, 5, 'Party Name :', '', 0, 'L');
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(100, 5, $client_name, '', 0, 'L');
            Fpdf::Ln();
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(13, 5, 'City :', '', 0, 'L');
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(60, 5, $city_name, '', 0, 'L');
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(12, 5, 'District :', '', 0, 'R');
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(55, 5, $district_name, '', 0, 'L');
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(12, 5, 'State :', '', 0, 'R');
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(38, 5, $state_name, '', 0, 'L');
            Fpdf::Ln();
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(18, 5, 'Amount :', '', 0, 'L');
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(100, 5, $items->amount, '', 0, 'L');
            Fpdf::Ln(8);
            Fpdf::SetWidths(array(12, 100, 41, 44));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            $itemList = DB::table('credit_note_item')->select('topland.product_master.product_name', 'challan_item_master.serial_no', 'challan_item_master.warranty')
                ->leftjoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'credit_note_item.challan_product_id')
                ->leftjoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
                ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'complain_item_details.product_id')
                ->where('type', '=', 'product')->where('credit_note_id', '=', $items->credit_note_id)->get();

            Fpdf::Row(array('No.', "Item Description", 'Serial No.', 'Warranty'), array('C', 'L', 'C', 'C'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            foreach ($itemList as $keys => $itemss) {
                Fpdf::Row(array('1', $itemss->product_name, $itemss->serial_no, $itemss->warranty), array('C', 'L', 'C', 'C'), '', array(), true);
            }

            $itemList = DB::table('credit_note_item')
                ->select('topland.product_master.product_name', 'challan_item_master.serial_no', 'challan_item_master.warranty',
                    DB::raw('(select product_name from topland.product_master as p WHERE p.product_id = challan_item_master.product_id) as pname')
                )
                ->leftjoin('challan_optional', 'challan_optional.challan_optional_id', '=', 'credit_note_item.challan_product_id')
                ->leftjoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'challan_optional.challan_product_id')
                ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'credit_note_item.product_id')
                ->where('type', '=', 'spare')->where('credit_note_id', '=', $items->credit_note_id)->get();

            foreach ($itemList as $keys => $itemss) {
                Fpdf::Row(array('1', $itemss->product_name . ' (' . $itemss->pname . ')', $itemss->serial_no, $itemss->warranty), array('C', 'L', 'C', 'C'), '', array(), true);
            }
            Fpdf::Ln();
        }
        Fpdf::Output();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\CreditNote $creditNote
     * @return \Illuminate\Http\Response
     */
    public function show(CreditNote $creditNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\CreditNote $creditNote
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\CreditNote $creditNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CreditNote $creditNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
