<?php

namespace App\Http\Controllers;

use App\Brands;
use App\FinancialYear;
use App\Helpers\Helper;
use App\Products;
use App\Challan;
use App\Destroy;
use App\DestroyItem;
use App\ChallanOptional;
use App\ChallanProduct;
use Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DestroyController extends Controller
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
        $destroyIndex = DB::table('destroy')
            ->select('destroy.created_at as destroy_date', 'destroy.*', 'complain.complain_no', 'complain.client_name',
                'topland.city_master.city_name','topland.district_master.district_name','topland.state_master.state_name','challan.*',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = destroy.financial_id) as fyear"))
            ->leftJoin('challan', 'challan.challan_id', '=', 'destroy.challan_id')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'billty.transport_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('destroy.branch_id', '=', Auth::user()->branch_id)
            ->orderByDesc('destroy_id')
            ->get();
        $request->session()->get('danger');
        return view('destroy.index')->with('destroyIndex', $destroyIndex);
//        return view('destroy.index')->with('AJAX_PATH', 'get-destroy');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'destroy_view';

        /** Table's primary key */
        $primaryKey = 'destroy_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'complain_no', 'dt' => 0),
            array('db' => 'date', 'dt' => 1),
            array('db' => 'client_name', 'dt' => 2),
            array('db' => 'print', 'dt' => 3),
            array('db' => 'edit', 'dt' => 4),
            array('db' => 'delete', 'dt' => 5),
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
        $challanDetail = DB::table('helpdesk.challan')
            ->select('complain.complain_no', 'challan.challan_id','complain.client_name','challan.branch_id',
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->join('billty', 'billty.billty_id', 'challan.billty_id')
            ->join('complain', 'complain.complain_id', 'billty.complain_id')
//            ->whereNOTIn('challan_id', function ($query) {
//                $query->select('challan_id')->from('destroy');
//            })
            ->where('challan.branch_id', '=', Auth::user()->branch_id)
            ->get();

        return view('destroy.create')->with('action', 'INSERT')->with('pageType', $this->pageType)->with('challanDetail', $challanDetail);
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
            'challan_id.required' => 'Please select Challan No.',
        ];
        $rules = [
            'challan_id' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $financialID= $financialYear->financial_id;
        $destroy_no = DB::table('helpdesk.destroy')
            ->select('destroy_no')
            ->where('branch_id', '=', Auth::user()->branch_id)
            ->where('financial_id', '=', $financialID)
            ->orderBy('destroy_no', 'desc')
            ->get()
            ->take(1)
            ->toArray();
        $destroy_no = json_decode(json_encode($destroy_no), true);
        $destroy_no = (!empty($destroy_no[0]['destroy_no'])) ? $destroy_no[0]['destroy_no'] + 1 : 1;

        $destroy = new Destroy();
        $destroy->challan_id = $request->input('challan_id');
        $destroy->client_name = $request->input('client_name');
        $destroy->client_id = $request->input('client_id');
        $destroy->financial_id = $financialYear->financial_id;
        $destroy->destroy_no = $destroy_no;
        $destroy->created_id = Auth::user()->user_id;
        $destroy->branch_id = Auth::user()->branch_id;
        $destroy->created_at = date('Y-m-d H:i:s');
        $destroy->save();
        $request->session()->put('destroy_id', $destroy->destroy_id);
        $request->session()->flash('create-status', 'Destroy Successfully Created...');
        return redirect('destroy-items/' . $destroy->destroy_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Destroy $destroy
     * @return \Illuminate\Http\Response
     */
    public function show(Destroy $destroy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Destroy $destroy
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $destroyDetail = Destroy::find($id);

        $challanDetail = DB::table('helpdesk.challan')
            ->select('complain.complain_no', 'challan.challan_id','complain.client_name')
            ->join('billty', 'billty.billty_id', 'challan.billty_id')
            ->join('complain', 'complain.complain_id', 'billty.complain_id')
            ->where('challan.branch_id', '=', Auth::user()->branch_id)
            ->get();
        $request->session()->put('destroy_id', $id);
        return view('destroy.create')->with('action', 'UPDATE')->with('pageType', $this->pageType)->with('challanDetail', $challanDetail)->with('destroyDetail', $destroyDetail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Destroy $destroy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'challan_id.required' => 'Please select Challan No.',
        ];
        $rules = [
            'challan_id' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $destroy = Destroy::find($id);
//        $destroy->challan_id = $request->input('challan_id');
        $destroy->client_name = $request->input('client_name');
        $destroy->client_id = $request->input('client_id');
        $destroy->updated_id = Auth::user()->user_id;
        $destroy->created_at = date('Y-m-d H:i:s');
        $destroy->save();
        $request->session()->put('destroy_id', $destroy->destroy_id);
        $request->session()->flash('update-status', 'Destroy Successfully Updated...');

        return redirect('destroy-items/' . $destroy->destroy_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Destroy $destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $destroyID = DestroyItem::where('destroy_id', '=', $id)->get();
        foreach ($destroyID as $row) {
            $type = $row->type;
            if ($type == 'Product') {
                $challanProduct = ChallanProduct::find($row->challan_product_id);
                $challanProduct->is_used = 'N';
                $challanProduct->save();
            } else {
                $challanOptional = ChallanOptional::find($row->challan_product_id);
                $challanOptional->is_used = 'N';
                $challanOptional->save();
            }
            DestroyItem::destroy($row->destroy_item_id);
        }
        Destroy::destroy($id);
        $request->session()->flash('delete-status', 'Delete Successful..');
        return redirect('destroy');
    }

    public function destroyFpdf($destroy_id, Request $request)
    {
        $request->session()->flash('delete-status', 'Product Not Available..!');
         Helper::destroyChallanReport($destroy_id);
         Fpdf::Output();

    }

}
