<?php

namespace App\Http\Controllers;

use App\Challan;
use App\ChallanOptional;
use App\Citys;
use App\FinancialYear;
use App\Helpers\Helper;
use App\Invoice;
use App\ChallanProduct;
use App\InvoiceItem;
use App\Transport;
use Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\DeclareDeclare;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver;

class InvoiceController extends Controller
{
    private $pageType;

    public function __construct()
    {

        $this->pageType = 'create';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoiceList = DB::table('invoice')
            ->select( 'invoice.*', 'complain.complain_no', 'complain.client_name',DB::raw('invoice.created_at as date_invoice'),
                'topland.city_master.city_name','topland.district_master.district_name','topland.state_master.state_name','challan.*',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = invoice.financial_id) as fyear"))
            ->leftJoin('challan','challan.challan_id','=','invoice.challan_id')
            ->leftJoin('billty','billty.billty_id','=','challan.billty_id')
            ->leftJoin('complain','complain.complain_id','=','billty.complain_id')
            ->leftJoin('topland.city_master','topland.city_master.city_id','=','complain.city_id')
            ->leftJoin('topland.district_master','topland.district_master.district_id','=','topland.city_master.district_id')
            ->leftJoin('topland.state_master','topland.state_master.state_id','=','topland.district_master.state_id')
            ->where('invoice.branch_id', '=', Auth::user()->branch_id)
            ->orderByDesc('invoice.invoice_id')
            ->get();

        return view('invoice.index')->with(compact('invoiceList'));
//        return view('invoice.index')->with('AJAX_PATH', 'get-invoice');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'invoice_view';

        /** Table's primary key */
        $primaryKey = 'invoice_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'complain_no', 'dt' => 0),
            array('db' => 'date', 'dt' => 1),
            array('db' => 'client_name', 'dt' => 2),
            array('db' => 'city_name', 'dt' => 3),
            array('db' => 'district', 'dt' => 4),
            array('db' => 'state', 'dt' => 5),
            array('db' => 'invoice_pdf', 'dt' => 6),
            array('db' => 'edit', 'dt' => 7),
            array('db' => 'delete', 'dt' => 8),
        );

        /** SQL server connection information */
        $sql_details = array(
            'user' => env('DB_USERNAME', 'root@localhost'),
            'pass' => env('DB_PASSWORD', ''),
            'db' => env('DB_DATABASE', 'helpdesk'),
            'host' => env('DB_HOST', '172.16.14.121')
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        $where = "branch_id=" . Auth::user()->branch_id;

        $dataRows = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "", $where);
        echo json_encode($dataRows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $challanList = DB::table('helpdesk.challan')
            ->select('complain.complain_no', 'challan.challan_id', 'complain.client_name','challan.branch_id',\
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->leftjoin('billty', 'billty.billty_id', 'challan.billty_id')
            ->leftjoin('complain', 'complain.complain_id', 'billty.complain_id')
//            ->whereNOTIn('challan_id', function ($query) {
//                $query->select('challan_id')->from('invoice');
//            })
            ->where('challan.branch_id', '=', Auth::user()->branch_id)
            ->get();
        $transportList = Transport::get();
        $cityList = Citys::get();

        return view('invoice.create')->with('action', 'INSERT')->with('pageType', $this->pageType)->with('challanList', $challanList)->with('transportList', $transportList)->with('cityList', $cityList)->with('CURRENT_PAGE', 'INVOICE');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'invoice_date.required' => 'Please select Invoice Date',
            'challan_id.required' => 'Please select Challan No.',
            'transport_id.required' => 'Please select Transport Name',
            'lr_no.required' => 'Please select LR. No.'
        ];
        $rules = [
            'invoice_date' => 'required',
            'challan_id' => 'required',
            'transport_id' => 'required',
            'lr_no' => 'required',
            'lory_no' => 'required'
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $financialID = $financialYear->financial_id;
        $invoiceNo = DB::table('helpdesk.invoice')
            ->select('invoice_no')
            ->where('branch_id', '=', Auth::user()->branch_id)
            ->where('financial_id', '=', $financialID)
            ->orderBy('invoice_no', 'desc')
            ->get()
            ->take(1)
            ->toArray();
        $invoiceNo = json_decode(json_encode($invoiceNo), true);
        $invoiceNo = (!empty($invoiceNo[0]['invoice_no'])) ? $invoiceNo[0]['invoice_no'] + 1 : 1;

        $invoice = new Invoice();
        $invoice->challan_id = $request->input('challan_id');
        $invoice->financial_id = $financialYear->financial_id;
        $invoice->invoice_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('invoice_date'))));
        $invoice->view_accessories = ($request->input('view_accessories') == 'on') ? 'Y' : 'N';
        $invoice->transport_id = $request->input('transport_id');
        $invoice->lr_no = $request->input('lr_no');
        $invoice->lory_no = $request->input('lory_no');
        $invoice->client_id = $request->input('client_id');
        $invoice->client_name = $request->input('client_name');
        $invoice->remark = $request->input('remark');
        $invoice->change_develiry_address = ($request->input('change_develiry_address') == 'on') ? 'Y' : 'N';
        $invoice->billing_name = $request->input('billing_name');
        $invoice->address1 = $request->input('address1');
        $invoice->address2 = $request->input('address2');
        $invoice->address3 = $request->input('address3');
        $invoice->city_id = $request->input('city_id');
        $invoice->pincode = $request->input('pincode');
        $invoice->gst_no = $request->input('gst_no');
        $invoice->mobile = $request->input('mobile');
        $invoice->contact_person = $request->input('contact_person');
        $invoice->lr_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('lr_date'))));
        $invoice->phone = $request->input('phone');
        $invoice->invoice_no = $invoiceNo;
        $invoice->created_id = Auth::user()->user_id;
        $invoice->branch_id = Auth::user()->branch_id;
        $invoice->created_at = date('Y-m-d H:i:s');
        $invoice->save();
        $request->session()->put('invoice_id', $invoice->invoice_id);
        $request->session()->flash('create-status', 'Invoice Successfully Created...');
        return redirect('invoice-items-create/'.$invoice->invoice_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
       $branch_id=Auth::user()->branch_id;
        $challanList = DB::table('helpdesk.challan')
            ->select('complain.complain_no', 'challan.challan_id', 'complain.client_name','challan.branch_id',\
            DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->leftjoin('billty', 'billty.billty_id', 'challan.billty_id')
            ->leftjoin('complain', 'complain.complain_id', 'billty.complain_id')
//            ->whereNOTIn('challan_id', function ($query) {
//                $query->select('challan_id')->from('invoice');
//            })
            ->where('challan.branch_id', '=', $branch_id)
            ->get();


        $transportList = Transport::get();
        $cityList = Citys::get();

        $invoiceList = DB::table('invoice')->where('invoice_id', '=', $id)->get();
        $request->session()->put('invoice_id', $id);

        return view('invoice.create')->with('action', 'UPDATE')->with(compact('branch_id'))->with('pageType', $this->pageType)->with('invoiceDetail', $invoiceList[0])->with('challanList', $challanList)->with('transportList', $transportList)->with('cityList', $cityList);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'invoice_date.required' => 'Please select Invoice Date',
            'transport_id.required' => 'Please select Transport Name',
            'lr_no.required' => 'Please select LR. No.',

        ];
        $rules = [
            'invoice_date' => 'required',
            'transport_id' => 'required',
            'lr_no' => 'required',
            'lory_no' => 'required',

        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $invoice = Invoice::find($id);
        $invoice->invoice_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('invoice_date'))));
        $invoice->view_accessories = ($request->input('view_accessories') == 'on') ? 'Y' : 'N';
        $invoice->transport_id = $request->input('transport_id');
        $invoice->lr_no = $request->input('lr_no');
        $invoice->lory_no = $request->input('lory_no');
        $invoice->remark = $request->input('remark');
        $invoice->change_develiry_address = ($request->input('change_develiry_address') == 'on') ? 'Y' : 'N';
        $invoice->billing_name = $request->input('billing_name');
        $invoice->client_id = $request->input('client_id');
        $invoice->client_name = $request->input('client_name');
        $invoice->address1 = $request->input('address1');
        $invoice->address2 = $request->input('address2');
        $invoice->address3 = $request->input('address3');
        $invoice->city_id = $request->input('city_id');
        $invoice->pincode = $request->input('pincode');
        $invoice->gst_no = $request->input('gst_no');
        $invoice->mobile = $request->input('mobile');
        $invoice->contact_person = $request->input('contact_person');
        $invoice->lr_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('lr_date'))));
        $invoice->phone = $request->input('phone');
        $invoice->updated_id = Auth::user()->user_id;
        $invoice->branch_id = Auth::user()->branch_id;
        $invoice->save();
        $request->session()->flash('update-status', 'Invoice Successfully Updated..');
        return redirect('invoice-items-create/'.$invoice->invoice_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $request->session()->flash('delete-status', 'Invoice Successfully Deleted...');
        $invoiceItems = InvoiceItem::where('invoice_id', '=', $id)->get();
        foreach ($invoiceItems as $row) {
            $type = $row->type;
            if ($type == 'product') {
                $challanProduct = ChallanProduct::find($row->challan_product_id);
                $challanProduct->is_used = 'N';
                $challanProduct->save();
            } else {
                $challanOptional = ChallanOptional::find($row->challan_product_id);
                $challanOptional->is_used = 'N';
                $challanOptional->save();
            }
            InvoiceItem::destroy($row->invoice_item_id);
        }
        Invoice::destroy($id);
        return redirect('invoice');
    }

    public function getChallanDetails(Request $request)
    {
        $challan_id = $request->input('challan_id');

        $challanDetail = DB::table('challan')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->where('challan_id', $challan_id)->first();
        $client_name = '';
        if ($challanDetail->change_bill_address == 'Y') {
            $client_name = strtoupper($challanDetail->billing_name);
        } else {
            $client_name = strtoupper($challanDetail->client_name);
        }

        return json_encode(array('created_at' => date('d-m-Y', strtotime($challanDetail->created_at)), 'client_name' => $client_name, 'client_id' => $challanDetail->client_id));
    }

    public function printPdf($invoice_id, Request $request)
    {
        $request->session()->flash('delete-status', 'Invoice product not Found.....!');
        $invoice = Helper::InvoicePdf($invoice_id);
        Fpdf::Output();
        echo $invoice;
    }
}
