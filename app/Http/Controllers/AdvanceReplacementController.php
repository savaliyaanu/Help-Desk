<?php

namespace App\Http\Controllers;

use App\AdvanceReplacement;
use App\AdvanceReplacementIn;
use App\FinancialYear;
use App\Helpers\Helper;
use App\ReplacementProductIn;
use App\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;

class AdvanceReplacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $replacement_out = DB::table('advance_replacement_out')
            ->select('complain.*', 'advance_replacement_out.*',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = advance_replacement_out.financial_id) as fyear"))
            ->join('complain', 'complain.complain_id', '=', 'advance_replacement_out.complain_id')
            ->where('advance_replacement_out.branch_id', '=', Auth::user()->branch_id)
            ->orderByDesc('advance_replacement_out.replacement_out_id')
            ->get();
        return view('advancereplacement.index')->with(compact('replacement_out'));
//        return view('advancereplacement.index')->with('AJAX_PATH', 'get-replacement');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'advance_replacement_view';

        /** Table's primary key */
        $primaryKey = 'replacement_out_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'complain_no', 'dt' => 0),
            array('db' => 'order_id', 'dt' => 1),
            array('db' => 'date', 'dt' => 2),
            array('db' => 'client_name', 'dt' => 3),
            array('db' => 'status', 'dt' => 4),
            array('db' => 'product_inward', 'dt' => 5),
            array('db' => 'print_pdf', 'dt' => 6),
            array('db' => 'edit', 'dt' => 7),
            array('db' => 'delete', 'dt' => 8)
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
        $complain = DB::table('complain')
            ->select( DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"),
                'complain.*')
            ->where('branch_id', '=', Auth::user()->branch_id)->get();
        $spare_list = DB::table('topland.product_master')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();
        $financial_year = DB::table('topland.financial_year')->where('is_delete', 'N')->orderBy('financial_id', 'DESC')->get();
        $transport_list = Transport::get();
        return view('advancereplacement.create')->with('action', 'INSERT')->with(compact('complain', 'spare_list', 'financial_year', 'transport_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $advancereplacement = new AdvanceReplacement();
        $advancereplacement->complain_id = $request->input('complain_id');
        $advancereplacement->financial_year = $request->input('financial_id');
        $advancereplacement->financial_id = $financialYear->financial_id;
        $advancereplacement->company_name = $request->input('company_name');
        $advancereplacement->order_id = $request->input('order_auto_id');
        $advancereplacement->billty_no = $request->input('billty_no');
        $advancereplacement->mobile_no = $request->input('mobile_no');
        $advancereplacement->transport_id = $request->input('transport_id');
        $advancereplacement->lr_no = $request->input('lr_no');
        $advancereplacement->lory_no = $request->input('lory_no');
        $advancereplacement->branch_id = Auth::user()->branch_id;
        $advancereplacement->created_id = Auth::user()->user_id;
        $request->session()->flash('create-status', 'Successfully Created..');
        $advancereplacement->save();
        return redirect('advance-replacement');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\AdvanceReplacement $advanceReplacement
     * @return \Illuminate\Http\Response
     */
    public function show(AdvanceReplacement $advanceReplacement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\AdvanceReplacement $advanceReplacement
     * @return \Illuminate\Http\Response
     */
    public function edit(AdvanceReplacement $advanceReplacement)
    {
        $companyItem = $advanceReplacement;
        $complain = DB::table('complain')->where('branch_id', '=', Auth::user()->branch_id)->get();
        $spare_list = DB::table('topland.product_master')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();
        $financial_year = DB::table('topland.financial_year')->where('is_delete', 'N')->orderBy('financial_id', 'DESC')->get();
        $transport_list = Transport::get();
        return view('advancereplacement.create')->with('action', 'UPDATE')->with(compact('companyItem', 'complain', 'spare_list', 'financial_year', 'transport_list'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\AdvanceReplacement $advanceReplacement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $advanceReplacement = AdvanceReplacement::find($id);
        $advanceReplacement->complain_id = $request->input('complain_id');
        $advanceReplacement->company_name = $request->input('company_name');
        $advanceReplacement->order_id = $request->input('order_auto_id');
        $advanceReplacement->billty_no = $request->input('billty_no');
        $advanceReplacement->mobile_no = $request->input('mobile_no');
        $advanceReplacement->transport_id = $request->input('transport_id');
        $advanceReplacement->lr_no = $request->input('lr_no');
        $advanceReplacement->lory_no = $request->input('lory_no');
        $advanceReplacement->branch_id = Auth::user()->branch_id;
        $advanceReplacement->updated_id = Auth::user()->user_id;
        $advanceReplacement->save();
        $request->session()->flash('update-status', 'Successfully Updated...');
        return redirect('advance-replacement');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\AdvanceReplacement $advanceReplacement
     * @return \Illuminate\Http\Response
     */
    public function destroy($replacement_out_id, Request $request)
    {
        AdvanceReplacement::destroy($replacement_out_id);
        AdvanceReplacementIn::where('replacement_out_id', $replacement_out_id)->delete();
        $request->session()->flash('delete-status', 'Successfully Deleted..');
        return redirect('advance-replacement');

    }

    public function getOrderNo(Request $request)
    {
        $company_name = $request->input('company_name');
        $financial_id = $request->input('financial_id');
        $financial_year = DB::table('topland.financial_year')->where('financial_id', $financial_id)->first();
        $year_heading = $financial_year->year_heading;
        if ($company_name === 'PFMA') {
            $order_master = DB::table($year_heading . '.order_master')
                ->select($year_heading . '.order_master.order_auto_id', $year_heading . '.product_master.product_name', $year_heading . '.order_master.order_quantity', $year_heading . '.order_master.order_id', $year_heading . '.order_master.order_type')
                ->join($year_heading . '.product_master', $year_heading . '.product_master.product_id', '=', $year_heading . '.order_master.product_id')
                ->where('order_type', 'Spare')
                ->groupBy($year_heading . '.order_master.order_id')
                ->get()
                ->toArray();
            $order_master = json_decode(json_encode($order_master), true);
            $option = "<option value=''>Select Order No</option>";
            foreach ($order_master as $row) {
                $option .= "<option value='" . $row['order_id'] . "'>" . $row['order_id'] . '-' . $row['order_type'] . "</option>";
            }
            echo $option;


        } elseif ($company_name === 'TEPL') {

            $order_master = DB::table($year_heading . '.engine_order_master')
                ->select($year_heading . '.engine_order_master.order_auto_id', $year_heading . '.product_master.product_name', $year_heading . '.engine_order_master.order_quantity', $year_heading . '.engine_order_master.order_id', $year_heading . '.engine_order_master.order_type')
                ->join($year_heading . '.product_master', $year_heading . '.product_master.product_id', '=', $year_heading . '.engine_order_master.product_id')
                ->where('order_type', 'Spare')
                ->groupBy($year_heading . '.engine_order_master.order_id')
                ->get()
                ->toArray();
            $order_master = json_decode(json_encode($order_master), true);
            $option = "<option value=''>Select Order No</option>";
            foreach ($order_master as $row) {
                $option .= "<option value='" . $row['order_id'] . "'>" . $row['order_id'] . '-' . $row['order_type'] . "</option>";
            }
            echo $option;
        } else {
            $order_master = DB::table($year_heading . '.tppl_order_master')
                ->select($year_heading . '.tppl_order_master.order_auto_id', $year_heading . '.product_master.product_name', $year_heading . '.tppl_order_master.order_quantity', $year_heading . '.tppl_order_master.order_id', $year_heading . '.tppl_order_master.order_type')
                ->join($year_heading . '.product_master', $year_heading . '.product_master.product_id', '=', $year_heading . '.tppl_order_master.product_id')
                ->where('order_type', 'Spare')
                ->groupBy($year_heading . '.tppl_order_master.order_id')
                ->get()
                ->toArray();

            $order_master = json_decode(json_encode($order_master), true);
            $option = "<option value=''>Select Order No</option>";
            foreach ($order_master as $row) {
                $option .= "<option value='" . $row['order_id'] . "'>" . $row['order_id'] . '-' . $row['order_type'] . "</option>";
            }
            echo $option;
        }
    }

    public function getOrderItems(Request $request)
    {
        $order_id = $request->input('order_id');
        $company_name = $request->input('company_name');
        $financial_id = $request->input('financial_id');
        $financial_year = DB::table('topland.financial_year')->where('financial_id', $financial_id)->first();
        $year_heading = $financial_year->year_heading;

        if ($company_name === 'PFMA') {
            $order_master = DB::table($year_heading . '.order_master')
                ->select($year_heading . '.order_master.order_auto_id', $year_heading . '.order_master.item_name', $year_heading . '.order_master.order_quantity', $year_heading . '.order_master.order_id', $year_heading . '.order_master.order_type')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get()
                ->toArray();
            $order_master = json_decode(json_encode($order_master), true);

        } elseif ($company_name === 'TEPL') {
            $order_master = DB::table($year_heading . '.engine_order_master')
                ->select($year_heading . '.engine_order_master.order_auto_id', $year_heading . '.engine_order_master.item_name', $year_heading . '.engine_order_master.order_quantity', $year_heading . '.engine_order_master.order_id', $year_heading . '.engine_order_master.order_type')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get()
                ->toArray();
            $order_master = json_decode(json_encode($order_master), true);
        } else {
            $order_master = DB::table($year_heading . '.tppl_order_master')
                ->select($year_heading . '.tppl_order_master.order_auto_id', $year_heading . '.tppl_order_master.item_name', $year_heading . '.tppl_order_master.order_quantity', $year_heading . '.tppl_order_master.order_id', $year_heading . '.tppl_order_master.order_type')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get()
                ->toArray();
            $order_master = json_decode(json_encode($order_master), true);
        }

        $option = "<table class='table table-bordered'><tr><th>Product Name</th><th>Qty</th></tr>";
        foreach ($order_master as $row) {
            $option .= "<tr><td>" . $row['item_name'] . "</td><td>" . $row['order_quantity'] . "</td></tr>";
        }
        $option .= "</table>";
        echo $option;
    }

    public function productOutPdf($replacement_out_id, Request $request)
    {
        $ad_rep = Helper::advanceReplacementOutPdf($replacement_out_id);
        Fpdf::Output();
        echo $ad_rep;
    }
}
