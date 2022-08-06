<?php

namespace App\Http\Controllers;

use App\Billty;
use App\Brands;
use App\Challan;
use App\ChallanAccessories;
use App\ChallanOptional;
use App\ChallanPanel;
use App\ChallanProduct;
use App\ChallanTestingMaster;
use App\CreditNote;
use App\Destroy;
use App\FinancialYear;
use App\Helpers\Helper;
use App\Image;
use App\InspectionReport;
use App\Invoice;
use App\Products;
use App\SpareInspectionReport;
use Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChallanController extends Controller
{

    private $pageType;

    public function __construct()
    {

        $this->pageType = 'Challan';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $challan = DB::table('challan')
            ->select('challan.created_at as challan_date', 'challan.*', 'complain.complain_no', 'complain.client_name',
                'topland.city_master.city_name', 'topland.district_master.district_name', 'topland.state_master.state_name', 'challan.*',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = challan.financial_id) as fyear"))
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'billty.transport_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('challan.branch_id', Auth::user()->branch_id)
            ->orderByDesc('challan.challan_id')
            ->get();

        $error = $request->session()->get('danger');
        return view('challan.index')->with('error', $error)->with(compact('challan'));
//        return view('challan.index')->with('AJAX_PATH', 'get-challan');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'challan_view';

        /** Table's primary key */
        $primaryKey = 'challan_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'complain_no', 'dt' => 0),
            array('db' => 'date', 'dt' => 1),
            array('db' => 'client_name1', 'dt' => 2),
            array('db' => 'city_name', 'dt' => 3),
            array('db' => 'district', 'dt' => 4),
            array('db' => 'state', 'dt' => 5),
            array('db' => 'current_status', 'dt' => 6),
            array('db' => 'testing_report', 'dt' => 7),
            array('db' => 'inspection_report', 'dt' => 8),
            array('db' => 'challan_report', 'dt' => 9),
            array('db' => 'edit', 'dt' => 10),
            array('db' => 'delete', 'dt' => 11),
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
        $billty = DB::table('helpdesk.billty')
            ->select('complain.complain_no', 'billty.billty_id', 'billty.billty_no', 'complain.complain_id', 'billty.branch_id', 'complain.client_name',
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->leftJoin('complain', 'complain.complain_id', 'billty.complain_id', 'billty_billty_no')
//            ->whereNOTIn('billty_id', function ($query) {
//                $query->select('billty_id')->from('challan');
//            })
            ->where('billty.branch_id', '=', Auth::user()->branch_id)
            ->get();
        $city_master = DB::table('topland.city_master')
            ->select('city_id', 'city_name')
            ->get();
        return view('challan.create')->with('action', 'INSERT')->with('pageType', $this->pageType)->with('city_master', $city_master)->with('billty', $billty)->with('CURRENT_PAGE', 'CHALLAN');

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
            'billty_id.required' => 'Please select Complain No',
        ];
        $rules = [
            'billty_id' => 'required'
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $financialID = $financialYear->financial_id;
        $challanNo = DB::table('helpdesk.challan')
            ->select('challan_no')
            ->where('branch_id', '=', Auth::user()->branch_id)
            ->where('financial_id', '=', $financialID)
            ->orderBy('challan_no', 'desc')
            ->get()
            ->take(1)
            ->toArray();
        $challanNo = json_decode(json_encode($challanNo), true);
        $challanNo = (!empty($challanNo[0]['challan_no'])) ? $challanNo[0]['challan_no'] + 1 : 1;

        $challan = new Challan();
        $challan->financial_id = $financialYear->financial_id;
        $challan->billty_id = $request->input('billty_id');
        $challan->client_id = $request->input('client_id');
        $challan->billing_name = $request->input('billing_name');
        $challan->address1 = $request->input('address1');
        $challan->address2 = $request->input('address2');
        $challan->address3 = $request->input('address3');
        $challan->city_id = $request->input('city_id');
        $challan->pincode = $request->input('pincode');
        $challan->gst_no = $request->input('gst_no');
        $challan->contact_person = $request->input('contact_person');
        $challan->phone = $request->input('phone');
        $challan->mobile = $request->input('mobile');
        $challan->challan_no = $challanNo;
        $challan->change_bill_address = ($request->input('change_bill_address') == 'on') ? 'Y' : 'N';
        $challan->created_id = Auth::user()->user_id;
        $challan->branch_id = Auth::user()->branch_id;
        $challan->created_at = date('Y-m-d H:i:s');
        $challan->save();
//        print_r($challan->challan_id);die();
//        $request->session()->put('challan_id', $challan->challan_id);
        $request->session()->flash('create-status', 'Challan Successfully Created...');
        return redirect('challan-product-create/' . $challan->challan_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Challan $challan
     * @return \Illuminate\Http\Response
     */
    public function show(Challan $challan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Challan $challan
     * @return \Illuminate\Http\Response
     */
    public function edit(Challan $challan, Request $request)
    {
        $request->session()->put('challan_id', $challan->challan_id);

        $billtySelect = DB::table('helpdesk.billty')
            ->select('complain.complain_no', 'billty.billty_id', 'billty.billty_no', 'complain.complain_id', 'billty.branch_id', 'complain.client_name',
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->join('complain', 'complain.complain_id', 'billty.complain_id')
            ->where('billty_id', '=', $challan->billty_id);

        $billty = DB::table('helpdesk.billty')
            ->select('complain.complain_no', 'billty.billty_id', 'billty.billty_no', 'complain.complain_id', 'billty.branch_id', 'complain.client_name',
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->join('complain', 'complain.complain_id', 'billty.complain_id')
            ->whereNOTIn('billty_id', function ($query) {
                $query->select('billty_id')->from('challan');
            })
            ->where('billty.branch_id', '=', Auth::user()->branch_id)
            ->union($billtySelect)
            ->get();

        $city_master = DB::table('topland.city_master')->where('city_id', $challan->city_id)
            ->get()
            ->toArray();
        $city_master = json_decode(json_encode($city_master), true);

        return view('challan.create')->with(compact('challan'))->with('action', 'UPDATE')->with('pageType', $this->pageType)->with('billty', $billty)->with('city_master', $city_master);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Challan $challan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challan $challan)
    {
        $messages = [
            'billty_id.required' => 'Please select Billty',
        ];
        $rules = [
            'billty_id' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $challan->client_id = $request->input('client_id');
        $challan->billing_name = $request->input('billing_name');
        $challan->address1 = $request->input('address1');
        $challan->address2 = $request->input('address2');
        $challan->address3 = $request->input('address3');
        $challan->city_id = $request->input('city_id');
        $challan->pincode = $request->input('pincode');
        $challan->gst_no = $request->input('gst_no');
        $challan->contact_person = $request->input('contact_person');
        $challan->phone = $request->input('phone');
        $challan->mobile = $request->input('mobile');
        $challan->change_bill_address = ($request->input('change_bill_address') == 'on') ? 'Y' : 'N';
        $challan->updated_id = Auth::user()->user_id;
        $challan->updated_at = date('Y-m-d H:i:s');
        $challan->save();
        $request->session()->flash('update-status', 'Challan Successful Updated...');
        return redirect('challan-product-create/' . $challan->challan_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Challan $challan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $challanProduct = ChallanProduct::where('challan_id', $id)->first();
        $complain_product_id = !empty($challanProduct->complain_product_id) ? $challanProduct->complain_product_id : '';
        $serial_no = !empty($challanProduct->serial_no) ? $challanProduct->serial_no : '';
        $invoice = Invoice::where('invoice.challan_id', '=', $id)->get();
        $creditnote = CreditNote::where('credit_note.challan_id', '=', $id)->get();
        $destroy = Destroy::where('destroy.challan_id', '=', $id)->get();
        if (!empty(isset($invoice[0]->challan_id) == $id)) {
            $request->session()->flash('delete-status', 'Invoice Created so Do not Deleted  Challan...');
            return redirect('challan');
        } elseif (!empty(isset($creditnote[0]->challan_id) == $id)) {
            $request->session()->flash('delete-status', 'Credit Note Created so Do not Deleted  Challan...');
            return redirect('challan');
        } elseif (!empty(isset($destroy[0]->challan_id) == $id)) {
            $request->session()->flash('delete-status', 'Destroy Created so Do not Deleted  Challan...');
            return redirect('challan');
        } else {
            if (!empty($complain_product_id)) {
                DB::table('billty_product_details')->where('cid_id', $complain_product_id)->where('serial_no', $serial_no)->update(['is_product_used' => 'N']);
            }
            Challan::destroy($id);
            InspectionReport::where('challan_id', $id)->delete();
            Image::where('challan_id', $id)->delete();
            ChallanProduct::where('challan_id', $id)->delete();
            $request->session()->flash('delete-status', 'Challan Successfully Deleted...');
            return redirect('challan');
        }

    }

    public function getBilltyDetails(Request $request)
    {
        $billty_id = $request->input('billty_id');
        $billtyDetails =
            DB::table('billty')
                ->select('complain.client_name', 'transport_master.transport_name', 'billty.*', 'complain.client_id')
                ->leftjoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
                ->leftjoin('topland.transport_master', 'transport_master.transport_id', '=', 'billty.transport_id')
                ->where('billty_id', '=', $billty_id)
                ->get()
                ->toArray();
        return json_encode($billtyDetails[0]);
    }

    public function updateChallanStatus($challan_id)
    {
        $challan = DB::table('helpdesk.challan')
            ->select('current_status')
            ->where('challan_id', '=', $challan_id)
            ->first();

        if ($challan->current_status === 'Repairing') {
            DB::table('challan')->where('challan_id', '=', $challan_id)->update(['current_status' => 'Dispatch', 'dispatch_status' => 'Y', 'dispatch_date' => date('Y-m-d H:i:s')]);
        } elseif ($challan->current_status === 'Dispatch') {
            DB::table('challan')->where('challan_id', '=', $challan_id)->update(['current_status' => 'Repairing', 'dispatch_status' => 'N', 'dispatch_date' => null]);
        }
        return redirect('challan');
    }

    public function printFpdf($challan_id)
    {
        \request()->session()->flash('delete-status', 'Challan Product not found.....!');
        $challan = Helper::challanPDF($challan_id);
        Fpdf::Output();
        echo $challan;
    }

    public function sparePdf($challan_id)
    {
        \request()->session()->flash('delete-status', 'Change Spare Product not found.....!');
        $challanSpare = Helper::changeSparePdf($challan_id);
        Fpdf::Output();
        echo $challanSpare;
    }


    public function inspectionReport($challan_id, Request $request)
    {
        $request->session()->flash('delete-status', 'Please Add Product.....!');
        $inspection = Helper::productInspectionReport($challan_id);
        Fpdf::Output();
        echo $inspection;
    }

    public function testingReport($challan_id, Request $request)
    {
        $request->session()->flash('delete-status', 'Testing Data Not Found.....!');
        $testing = Helper::engineTestingReport($challan_id);
        Fpdf::Output();
        echo $testing;
    }
}
