<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Challan;
use App\CreditNote;
use Carbon\Carbon;
use Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChallanReportController extends Controller
{
    private $pageType;
    private $invoiceEngineY = 0;
    private $invoiceEngineN = 0;
    private $invoiceCentrifigalY = 0;
    private $invoiceCentrifigalN = 0;
    private $invoicePumpSetY = 0;
    private $invoicePumpSetN = 0;
    private $invoiceAcY = 0;
    private $invoiceAcN = 0;
    private $creditNoteEngineY = 0;
    private $creditNoteEngineN = 0;
    private $creditNoteCentrifigalY = 0;
    private $creditNoteCentrifigalN = 0;
    private $creditNotePumpSetY = 0;
    private $creditNotePumpSetN = 0;
    private $creditNoteAcY = 0;
    private $creditNoteAcN = 0;
    private $PendingEngineY = 0;
    private $PendingEngineN = 0;
    private $PendingCentrifigalY = 0;
    private $PendingCentrifigalN = 0;
    private $PendingPumpSetY = 0;
    private $PendingPumpSetN = 0;
    private $PendingAcY = 0;
    private $PendingAcN = 0;
    private $destroyEngineY = 0;
    private $destroyEngineN = 0;
    private $destroyCentrifigalY = 0;
    private $destroyCentrifigalN = 0;
    private $destroyPumpSetY = 0;
    private $destroyPumpSetN = 0;
    private $destroyAcY = 0;
    private $destroyAcN = 0;
    private $dispatchEngineY = 0;
    private $dispatchEngineN = 0;
    private $dispatchCentrifigalY = 0;
    private $dispatchCentrifigalN = 0;
    private $dispatchPumpSetY = 0;
    private $dispatchPumpSetN = 0;
    private $dispatchAcY = 0;
    private $dispatchAcN = 0;


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
    public function create()
    {
        $clientDetail = DB::table('topland.client_master')->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'topland.client_master.city_id')->get();
        $branch = Branch::leftjoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('branch_master.company_id', '=', Auth::user()->branch_id)
            ->get();
        return view('challanreport.create')->with('action', 'INSERT')->with('clientDetail', $clientDetail)->with('branch', $branch);
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
        $client_id = $request->input('client_id');
        $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('from_date'))));
        $to = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('to_date'))));
        $query = Challan::with('getBilltyDetail.getTransport')
            ->with('getBilltyDetail.getComplain.getCity.getDistrict.getState')
            ->with('getCity.getDistrict.getState')
            ->select('complain.created_at as complain_date', 'complain.*', 'challan.*', 'topland.city_master.city_name', 'topland.district_master.district_name', 'topland.state_master.state_name',
                'billty.*', 'challan.created_at as challan_date')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('challan.branch_id', '=', Auth::user()->branch_id);

        if (!empty($client_id)) {
            $query = $query->where('complain.client_id', '=', $client_id);
        }
        $query->where(DB::raw('DATE_FORMAT(challan.created_at,"%Y-%m-%d")'), '>=', $from);
        $query->where(DB::raw('DATE_FORMAT(challan.created_at,"%Y-%m-%d")'), '<=', $to);

        if ($report_type == 'Pending') {
            $query->where('challan.dispatch_status', '=', 'N');
        }
        $challan = $query->get();

        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 13);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Ln();
        Fpdf::Cell(190, 5, 'Challan Pending Date Between ' . $from . ' To ' . $to, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::Ln();
        $totalNos = 0;


        foreach ($challan as $key => $items) {
            $current_status = $items->current_status;

            if ($items->change_bill_address == 'Y') {
                $client_name = $items->billing_name;
                $city_name = $items->city_name;
                $district_name = $items->district_name;
                $state_name = $items->state_name;
            } else {
                $client_name = $items->client_name;
                $city_name = $items->city_name;
                $district_name = $items->district_name;
                $state_name = $items->state_name;
            }
            $complain_no = $items->complain_no;
            $complain_date = $items->complain_date;

            $i = 1;
            $a = 0;
            if (isset($items->getPendingChallanSpareItems[0]->getOptionalSparePending)) {
                $a = $items->getPendingChallanSpareItems[0]->getOptionalSparePending->count();
            }

            $pendingItems = $items->getPendingChallanItems->count() + $a;

            if ($pendingItems >= 1 or $report_type == 'All') {

                Fpdf::SetFont('Courier', 'B', 10);

                Fpdf::Cell(25, 5, 'CHALLAN NO :  ', 'LT', 0, 'L');
                Fpdf::Cell(50, 5, ' ' . $items->challan_no, 'T', 0, 'L');
                Fpdf::Cell(25, 5, "CH. DATE : ", 'T', 0, 'L');
                Fpdf::Cell(50, 5, date('d.m.Y', strtotime($items->challan_date)), 'T', 0, 'L');
                Fpdf::Cell(20, 5, "STATUS : ", 'T', 0, 'L');
                Fpdf::Cell(27, 5, strtoupper($items->current_status), 'TR', 1, 'L');

                if ($items->complain_status != 'Resolved') {
                    Fpdf::Cell(25, 5, "TKT. NO : ", 'L', 0, 'L');
                    Fpdf::CellFitScale(50, 5, strtoupper($complain_no), '', 0, 'L');
                    Fpdf::Cell(25, 5, "TKT. DATE :", '', 0, 'L');
                    Fpdf::CellFitScale(97, 5, date('d.m.Y', strtotime($complain_date)), 'R', 1, 'L');
                } elseif ($items->complain_status == 'Resolved') {
                    Fpdf::Cell(25, 5, "TKT. NO : ", 'L', 0, 'L');
                    Fpdf::CellFitScale(50, 5, '  ' . strtoupper($complain_no), '', 0, 'L');
                    Fpdf::Cell(25, 5, "TKT. DATE :", '', 0, 'L');
                    Fpdf::CellFitScale(50, 5, date('d.m.Y', strtotime($complain_date)), '', 0, 'L');
//                    $Complain_from = Carbon::createFromFormat('Y-m-d', $items->complain_date);
//                    $Challan_to = Carbon::createFromFormat('Y-m-d', $items->resolve_date);
//
//                    $diff_in_days = $Challan_to->diffInDays($Complain_from);
//                    print_r($diff_in_days);exit();
                    Fpdf::Cell(20, 5, "DAY :", '', 0, 'L');
                    Fpdf::CellFitScale(27, 5, '', 'R', 1, 'L');
                }
                $dispatch_date = ($items->dispatch_date > 1970 - 01 - 01) ? date('d-m-Y',
                    strtotime($items->dispatch_date)) : '';
                if ($current_status == "Dispatch") {
                    Fpdf::Cell(27, 5, "PARTY NAME : ", 'L', 0, 'L');
                    Fpdf::CellFitScale(90, 5, strtoupper($client_name), '', 0, 'L');
                    Fpdf::Cell(30, 5, "DISPATCH DATE : ", '', 0, 'L');
                    Fpdf::CellFitScale(50, 5, '  ' . $dispatch_date, 'R', 1, 'L');
                }else{
                    Fpdf::Cell(27, 5, "PARTY NAME : ", 'L', 0, 'L');
                    Fpdf::CellFitScale(170, 5, strtoupper($client_name), 'R', 1, 'L');
                }

                Fpdf::Cell(25, 5, "CITY : ", 'L', 0, 'L');
                Fpdf::CellFitScale(50, 5, $city_name, '', 0, 'L');
                Fpdf::Cell(25, 5, "DISTRICT:", '', 0, 'L');
                Fpdf::CellFitScale(50, 5, $district_name, '', 0, 'L');
                Fpdf::Cell(20, 5, "STATE :", '', 0, 'L');
                Fpdf::CellFitScale(27, 5, $state_name, 'R', 1, 'L');

                Fpdf::SetWidths(array(12, 100, 41, 22, 22));
                Fpdf::SetFont('Verdana-Bold', 'B', 8);

                Fpdf::Row(array('NO.', "ITEM DESCRIPTION", 'SERIAL NO.', 'WARRANTY', 'QTY'), array('C', 'L', 'C', 'C', 'C'), '', array(), true);
                Fpdf::SetFont('Verdana', '', 8);
                Fpdf::SetWidths(array(12, 100, 41, 22, 22));

                foreach ($items->getPendingChallanItems as $key_cre => $value_cre) {

                    $this->summary($value_cre->warranty, $value_cre->category_id, $items->current_status, 'Pending', $value_cre->quantity);
                    Fpdf::Row(array($i++, $value_cre->getProduct->product_name, $value_cre->serial_no, $value_cre->warranty, $value_cre->quantity), array('C', 'L', 'C', 'C', 'C'), '', array(), true);
                    $totalNos = $totalNos + $value_cre->quantity;
                }
                foreach ($items->getPendingChallanSpareItems as $key_cre => $value_cre) {
                    foreach ($value_cre->getOptionalSparePending as $key_pending => $value_pending) {
                        $this->summary($value_cre->warranty, $value_cre->category_id, $items->current_status, 'Pending', $value_pending->qty);
//                    Fpdf::Row(array($i++, $value_pending->getProduct->product_name . ' (' . $value_cre->getProduct->product_name . ')', $value_cre->serial_no, $value_cre->warranty, $value_pending->qty), array('C', 'L', 'C', 'C', 'C'), '', array(), true);
                        $totalNos = $totalNos + $value_pending->qty;
                    }
                }
                foreach ($items->getCreditnote as $key_cre => $value_cre) {
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    $itemList = DB::table('credit_note_item')
                        ->select('topland.product_master.category_id', 'topland.product_master.product_name', 'challan_item_master.serial_no',
                            'challan_item_master.warranty', 'challan_item_master.quantity as qty', DB::raw("' ' as pname"))
                        ->leftjoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'credit_note_item.challan_product_id')
                        ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'credit_note_item.product_id')
                        ->where('type', '=', 'product')->where('credit_note_id', '=', $value_cre->credit_note_id)->get();
                    $itemList = json_decode(json_encode($itemList), true);

                    $itemList1 = DB::table('credit_note_item')
                        ->select('a.category_id', 'topland.product_master.product_name', 'challan_item_master.serial_no', 'challan_item_master.warranty', 'challan_optional.qty as qty',
                            DB::raw("(select concat('(',product_name,')') from topland.product_master as p WHERE p.product_id = challan_item_master.product_id) as pname"))
                        ->leftjoin('challan_optional', 'challan_optional.challan_optional_id', '=', 'credit_note_item.challan_product_id')
                        ->leftjoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'challan_optional.challan_product_id')
                        ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'credit_note_item.product_id')
                        ->leftjoin('topland.product_master as a', 'a.product_id', '=', 'challan_item_master.product_id')
                        ->where('type', '=', 'spare')->where('credit_note_id', '=', $value_cre->credit_note_id)->get();
                    $itemList1 = json_decode(json_encode($itemList1), true);
                    $item_lis = array_merge($itemList, $itemList1);
                    Fpdf::SetWidths(array(112, 41, 44));
                    if ($report_type != 'Pending') {
                        Fpdf::Row(array('CREDIT NOTE', $value_cre->credit_note_id, date('d.m.Y', strtotime($value_cre->created_at))), array('C', 'C', 'C'), '', array(), true);
                    }
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::SetWidths(array(12, 100, 41, 22, 22));

                    foreach ($item_lis as $itemss) {
                        $this->summary($itemss['warranty'], $itemss['category_id'], $items->current_status, 'Credit Note', $itemss['qty']);
                        if ($report_type != 'Pending') {
                            Fpdf::Row(array($i++, $itemss['product_name'] . ' ' . $itemss['pname'], $itemss['serial_no'], $itemss['warranty'], $itemss['qty']), array('C', 'L', 'C', 'C', 'C'), '', array(), true);
                            $totalNos = $totalNos + $itemss['qty'];
                        }
                    }
                }
                foreach ($items->getInvoice as $key_cre => $value_cre) {
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    $itemList2 = DB::table('invoice_items')->select('topland.product_master.category_id', 'topland.product_master.product_name', 'challan_item_master.serial_no', 'challan_item_master.warranty', 'challan_item_master.quantity as qty', DB::raw("' ' as pname"))
                        ->leftjoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'invoice_items.challan_product_id')
                        ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'invoice_items.product_id')
                        ->where('type', '=', 'product')->where('invoice_id', '=', $value_cre->invoice_id)->get();
                    $itemList2 = json_decode(json_encode($itemList2), true);
                    $itemList3 = DB::table('invoice_items')
                        ->select('a.category_id', 'topland.product_master.product_name', 'challan_item_master.serial_no', 'challan_item_master.warranty', 'challan_optional.qty as qty',
                            DB::raw("(select concat('(',product_name,')') from topland.product_master as p WHERE p.product_id = challan_item_master.product_id) as pname")
                        )
                        ->leftjoin('challan_optional', 'challan_optional.challan_optional_id', '=', 'invoice_items.challan_product_id')
                        ->leftjoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'challan_optional.challan_product_id')
                        ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'invoice_items.product_id')
                        ->leftjoin('topland.product_master as a', 'a.product_id', '=', 'challan_item_master.product_id')
                        ->where('type', '=', 'spare')->where('invoice_id', '=', $value_cre->invoice_id)->get();
                    $itemList3 = json_decode(json_encode($itemList3), true);
                    $item_lis1 = array_merge($itemList2, $itemList3);

                    Fpdf::SetWidths(array(112, 41, 44));
                    if ($report_type != 'Pending') {
                        Fpdf::Row(array('INVOICE', $value_cre->invoice_no, date('d.m.Y', strtotime($value_cre->invoice_date))), array('C', 'C', 'C'), '', array(), true);
                    }
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::SetWidths(array(12, 100, 41, 22, 22));

                    foreach ($item_lis1 as $itemss) {
                        $this->summary($itemss['warranty'], $itemss['category_id'], $items->current_status, 'Invoice', $itemss['qty']);
                        if ($report_type != 'Pending') {
                            Fpdf::Row(array($i++, $itemss['product_name'] . ' ' . $itemss['pname'], $itemss['serial_no'], $itemss['warranty'], $itemss['qty']), array('C', 'L', 'C', 'C', 'C'), '', array(), true);
                            $totalNos = $totalNos + $itemss['qty'];
                        }
                    }
                }

                foreach ($items->getDestroy as $key_cre => $value_cre) {
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    $itemList2 = DB::table('destroy_item')->select('topland.product_master.category_id', 'topland.product_master.product_name', 'challan_item_master.serial_no', 'challan_item_master.warranty', 'challan_item_master.quantity as qty', DB::raw("' ' as pname"))
                        ->leftjoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'destroy_item.challan_product_id')
                        ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'destroy_item.product_id')
                        ->where('type', '=', 'product')->where('destroy_id', '=', $value_cre->destroy_id)->get();
                    $itemList2 = json_decode(json_encode($itemList2), true);
                    $itemList3 = DB::table('destroy_item')
                        ->select('a.category_id', 'topland.product_master.product_name', 'challan_item_master.serial_no', 'challan_item_master.warranty', 'challan_optional.qty as qty',
                            DB::raw("(select concat('(',product_name,')') from topland.product_master as p WHERE p.product_id = challan_item_master.product_id) as pname")
                        )
                        ->leftjoin('challan_optional', 'challan_optional.challan_optional_id', '=', 'destroy_item.challan_product_id')
                        ->leftjoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'challan_optional.challan_product_id')
                        ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'destroy_item.product_id')
                        ->leftjoin('topland.product_master as a', 'a.product_id', '=', 'challan_item_master.product_id')
                        ->where('type', '=', 'spare')->where('destroy_id', '=', $value_cre->destroy_id)->get();
                    $itemList3 = json_decode(json_encode($itemList3), true);
                    $item_lis1 = array_merge($itemList2, $itemList3);
                    Fpdf::SetWidths(array(112, 41, 44));
                    if ($report_type != 'Pending') {
                        Fpdf::Row(array('DESTROY', $value_cre->destroy_id, date('d.m.Y', strtotime($value_cre->created_at))), array('C', 'C', 'C'), '', array(), true);
                    }
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::SetWidths(array(12, 100, 41, 22, 22));

                    foreach ($item_lis1 as $itemss) {
                        $this->summary($itemss['warranty'], $itemss['category_id'], $items->current_status, 'Destroy', $itemss['qty']);
                        if ($report_type != 'Pending') {
                            Fpdf::Row(array($i++, $itemss['product_name'] . ' ' . $itemss['pname'], $itemss['serial_no'], $itemss['warranty'], $itemss['qty']), array('C', 'L', 'C', 'C', 'C'), '', array(), true);
                            $totalNos = $totalNos + $itemss['qty'];
                        }
                    }

                }

                Fpdf::Ln();
            }
        }
        Fpdf::SetFont('Courier', 'B', 12);
        Fpdf::SetWidths(array(175, 22));
        Fpdf::Row(array('Total Nos : ', $totalNos), array('R', 'C'), '', array(), true);

        Fpdf::SetFont('Courier', 'B', 13);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Ln();
        Fpdf::Cell(190, 5, 'SUMMARY', 0, 1, 'C');
        Fpdf::Ln();

        Fpdf::SetFont('Courier', 'B', 9);
        Fpdf::Cell(40, 5, 'PARTICULAR', 'LT', 0, 'C');
        Fpdf::Cell(30, 5, 'ENGINES', 'LT', 0, 'C');
        Fpdf::Cell(30, 5, 'CEN. PUMP', 'LT', 0, 'C');
        Fpdf::Cell(30, 5, "SUB. PUMP", 'LT', 0, 'C');
        Fpdf::Cell(30, 5, 'A C GEN.', 'LT', 0, 'C');
        Fpdf::Cell(30, 5, "TOTAL", 'LTR', 1, 'C');

        Fpdf::SetFont('Courier', 'B', 9);
        Fpdf::Cell(40, 5, '', 'LB', 0, 'C');
        Fpdf::Cell(15, 5, 'YES', '1', 0, 'C');
        Fpdf::Cell(15, 5, 'NO', '1', 0, 'C');
        Fpdf::Cell(15, 5, 'YES', '1', 0, 'C');
        Fpdf::Cell(15, 5, 'NO', '1', 0, 'C');
        Fpdf::Cell(15, 5, 'YES', '1', 0, 'C');
        Fpdf::Cell(15, 5, 'NO', '1', 0, 'C');
        Fpdf::Cell(15, 5, 'YES', '1', 0, 'C');
        Fpdf::Cell(15, 5, 'NO', '1', 0, 'C');
        Fpdf::Cell(30, 5, "", 'LBR', 1, 'C');

        $firstTotal2 = $this->creditNoteEngineY + $this->creditNoteEngineN + $this->creditNoteCentrifigalY + $this->creditNoteCentrifigalN + $this->creditNotePumpSetY + $this->creditNotePumpSetN + $this->creditNoteAcY + $this->creditNoteAcN;

        Fpdf::Cell(40, 5, 'CREDIT NOTE', 1, 0, 'C');
        Fpdf::Cell(15, 5, $this->creditNoteEngineY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->creditNoteEngineN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->creditNoteCentrifigalY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->creditNoteCentrifigalN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->creditNotePumpSetY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->creditNotePumpSetN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->creditNoteAcY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->creditNoteAcN, '1', 0, 'C');
        Fpdf::Cell(30, 5, $firstTotal2, 1, 1, 'C');

        $firstTotal1 = $this->invoiceEngineY + $this->invoiceEngineN + $this->invoiceCentrifigalY + $this->invoiceCentrifigalN + $this->invoicePumpSetY + $this->invoicePumpSetN + $this->invoiceAcY + $this->invoiceAcN;
        Fpdf::Cell(40, 5, 'INVOICE', 1, 0, 'C');
        Fpdf::Cell(15, 5, $this->invoiceEngineY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->invoiceEngineN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->invoiceCentrifigalY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->invoiceCentrifigalN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->invoicePumpSetY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->invoicePumpSetN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->invoiceAcY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->invoiceAcN, '1', 0, 'C');
        Fpdf::Cell(30, 5, $firstTotal1, 1, 1, 'C');

        $firstTotal4 = $this->destroyEngineY + $this->destroyEngineN + $this->destroyCentrifigalY + $this->destroyCentrifigalN + $this->destroyPumpSetY + $this->destroyPumpSetN + $this->destroyAcY + $this->destroyAcN;
        Fpdf::Cell(40, 5, 'DESTROY', 1, 0, 'C');
        Fpdf::Cell(15, 5, $this->destroyEngineY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->destroyEngineN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->destroyCentrifigalY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->destroyCentrifigalN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->destroyPumpSetY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->destroyPumpSetN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->destroyAcY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->destroyAcN, '1', 0, 'C');
        Fpdf::Cell(30, 5, $firstTotal4, 1, 1, 'C');

        $firstTotal5 = $this->PendingEngineY + $this->PendingEngineN + $this->PendingCentrifigalY + $this->PendingCentrifigalN + $this->PendingPumpSetY + $this->PendingPumpSetN + $this->PendingAcY + $this->PendingAcN;
        Fpdf::Cell(40, 5, 'REPAIRING', 1, 0, 'C');
        Fpdf::Cell(15, 5, $this->PendingEngineY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->PendingEngineN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->PendingCentrifigalY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->PendingCentrifigalN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->PendingPumpSetY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->PendingPumpSetN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->PendingAcY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->PendingAcN, '1', 0, 'C');
        Fpdf::Cell(30, 5, $firstTotal5, 1, 1, 'C');

        $firstTotal6 = $this->dispatchEngineY + $this->dispatchEngineN + $this->dispatchCentrifigalY + $this->dispatchCentrifigalN + $this->dispatchPumpSetY + $this->dispatchPumpSetN + $this->dispatchAcY + $this->dispatchAcN;
        Fpdf::Cell(40, 5, 'DISPATCH', 1, 0, 'C');
        Fpdf::Cell(15, 5, $this->dispatchEngineY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->dispatchEngineN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->dispatchCentrifigalY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->dispatchCentrifigalN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->dispatchPumpSetY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->dispatchPumpSetN, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->dispatchAcY, '1', 0, 'C');
        Fpdf::Cell(15, 5, $this->dispatchAcN, '1', 0, 'C');
        Fpdf::Cell(30, 5, $firstTotal6, 1, 1, 'C');

        Fpdf::SetWidths(array(160, 30));
        Fpdf::Row(array('Total Nos : ', $firstTotal1 + $firstTotal2 + $firstTotal4 + $firstTotal5 + $firstTotal6), array('R', 'C'), '', array(), true);
        Fpdf::Output();
        exit();
    }

    public function summary($warranty_period, $category_id, $status, $nameOfColumn, $qty)
    {
        if ($nameOfColumn == 'Pending') {
            if ($category_id == '1' or $category_id == '2' or $category_id == '3') {
                if ($status == 'Repairing') {
                    if ($warranty_period == 'Y') {
                        $this->PendingEngineY = $this->PendingEngineY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->PendingEngineN = $this->PendingEngineN + $qty;
                    }
                } elseif ($status == 'Dispatch') {
                    if ($warranty_period == 'Y') {
                        $this->dispatchEngineY = $this->dispatchEngineY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->dispatchEngineN = $this->dispatchEngineN + $qty;

                    }
                }

            } elseif ($category_id == '4') {
                if ($status == 'Repairing') {
                    if ($warranty_period == 'Y') {
                        $this->PendingCentrifigalY = $this->PendingCentrifigalY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->PendingCentrifigalN = $this->PendingCentrifigalN + $qty;

                    }
                } elseif ($status == 'Dispatch') {
                    if ($warranty_period == 'Y') {
                        $this->dispatchCentrifigalY = $this->dispatchCentrifigalY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->dispatchCentrifigalN = $this->dispatchCentrifigalN + $qty;
                    }
                }

            } elseif ($category_id == '5') {

                if ($status == 'Repairing') {
                    if ($warranty_period == 'Y') {
                        $this->PendingAcY = $this->PendingAcY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->PendingAcN = $this->PendingAcN + $qty;

                    }
                } elseif ($status == 'Dispatch') {
                    if ($warranty_period == 'Y') {
                        $this->dispatchAcY = $this->dispatchAcY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->dispatchAcN = $this->dispatchAcN + $qty;
                    }
                }

            } elseif ($category_id == '6' or $category_id == '7' or $category_id == '11' or $category_id == '12') {

                if ($status == 'Repairing') {
                    if ($warranty_period == 'Y') {
                        $this->PendingPumpSetY = $this->PendingPumpSetY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->PendingPumpSetN = $this->PendingPumpSetN + $qty;
                    }
                } elseif ($status == 'Dispatch') {
                    if ($warranty_period == 'Y') {
                        $this->dispatchPumpSetY = $this->dispatchPumpSetY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->dispatchPumpSetN = $this->dispatchPumpSetN + $qty;
                    }
                }
            }
        } else {

            if ($category_id == '1' or $category_id == '2' or $category_id == '3') {
                if ($nameOfColumn == 'Invoice') {
                    if ($warranty_period == 'Y') {
                        $this->invoiceEngineY = $this->invoiceEngineY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->invoiceEngineN = $this->invoiceEngineN + $qty;

                    }
                } elseif ($nameOfColumn == 'Credit Note') {
                    if ($warranty_period == 'Y') {
                        $this->creditNoteEngineY = $this->creditNoteEngineY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->creditNoteEngineN = $this->creditNoteEngineN + $qty;
                    }
                } elseif ($nameOfColumn == 'Destroy') {
                    if ($warranty_period == 'Y') {
                        $this->destroyEngineY = $this->destroyEngineY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->destroyEngineN = $this->destroyEngineN + $qty;
                    }
                }

            } elseif ($category_id == '4') {
                if ($nameOfColumn == 'Invoice') {
                    if ($warranty_period == 'Y') {
                        $this->invoiceCentrifigalY = $this->invoiceCentrifigalY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->invoiceCentrifigalN = $this->invoiceCentrifigalN + $qty;
                    }
                } elseif ($nameOfColumn == 'Credit Note') {
                    if ($warranty_period == 'Y') {
                        $this->creditNoteCentrifigalY = $this->creditNoteCentrifigalY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->creditNoteCentrifigalN = $this->creditNoteCentrifigalN + $qty;
                    }
                } elseif ($nameOfColumn == 'Destroy') {
                    if ($warranty_period == 'Y') {
                        $this->destroyCentrifigalY = $this->destroyCentrifigalY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->destroyCentrifigalN = $this->destroyCentrifigalN + $qty;
                    }
                }

            } elseif ($category_id == '5') {

                if ($nameOfColumn == 'Invoice') {
                    if ($warranty_period == 'Y') {
                        $this->invoiceAcY = $this->invoiceAcY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->invoiceAcN = $this->invoiceAcN + $qty;
                    }
                } elseif ($nameOfColumn == 'Credit Note') {
                    if ($warranty_period == 'Y') {
                        $this->creditNoteAcY = $this->creditNoteAcY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->creditNoteAcN = $this->creditNoteAcN + $qty;
                    }
                } elseif ($nameOfColumn == 'Destroy') {
                    if ($warranty_period == 'Y') {
                        $this->destroyAcY = $this->destroyAcY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->destroyAcN = $this->destroyAcN + $qty;
                    }
                }

            } elseif ($category_id == '6' or $category_id == '7' or $category_id == '11' or $category_id == '12') {

                if ($nameOfColumn == 'Invoice') {
                    if ($warranty_period == 'Y') {
                        $this->invoicePumpSetY = $this->invoicePumpSetY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->invoicePumpSetN = $this->invoicePumpSetN + $qty;
                    }
                } elseif ($nameOfColumn == 'Credit Note') {
                    if ($warranty_period == 'Y') {
                        $this->creditNotePumpSetY = $this->creditNotePumpSetY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->creditNotePumpSetN = $this->creditNotePumpSetN + $qty;
                    }
                } elseif ($nameOfColumn == 'Destroy') {
                    if ($warranty_period == 'Y') {
                        $this->destroyPumpSetY = $this->creditNotePumpSetY + $qty;
                    } elseif ($warranty_period == 'N') {
                        $this->destroyPumpSetN = $this->creditNotePumpSetN + $qty;
                    }
                }

            }

        }
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
