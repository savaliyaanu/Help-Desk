<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Citys;
use App\CompanyMaster;
use App\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('branchmaster.index')->with('AJAX_PATH', 'get-branch');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'branch_master_view';

        /** Table's primary key */
        $primaryKey = 'branch_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        if (in_array(Auth::user()->role_id, [1])) {
            $columns = array(
                array('db' => 'company_name', 'dt' => 0),
                array('db' => 'branch_name', 'dt' => 1),
                array('db' => 'city_name', 'dt' => 2),
                array('db' => 'district', 'dt' => 3),
                array('db' => 'state', 'dt' => 4),
                array('db' => 'gst_no', 'dt' => 5),
                array('db' => 'edit', 'dt' => 6),
                array('db' => 'delete', 'dt' => 7),
            );
        } elseif (in_array(Auth::user()->role_id, [2])) {
            $columns = array(
                array('db' => 'company_name', 'dt' => 0),
                array('db' => 'branch_name', 'dt' => 1),
                array('db' => 'city_name', 'dt' => 2),
                array('db' => 'district', 'dt' => 3),
                array('db' => 'state', 'dt' => 4),
                array('db' => 'gst_no', 'dt' => 5),
                array('db' => 'edit', 'dt' => 6),
            );
        }

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

        $dataRows = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns);
        echo json_encode($dataRows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyList = CompanyMaster::get();
        $cityList = Citys::get();
        return view('branchmaster.create')->with('action', 'INSERT')->with('companyList', $companyList)->with('cityList', $cityList);
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
            'company_id.required' => 'Please Select Company Name',
            'city_is.required' => 'Please Select City Name',
        ];
        $rules = [
            'company_id' => 'required',
            'branch_name' => 'required',
            'address1' => 'required',
            'city_id' => 'required',
            'pincode' => 'required',
            'gst_no' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $financialYear = FinancialYear::where('is_active', 'Y')->first();

        $branchDetail = new Branch();
        $branchDetail->financial_id = $financialYear->financial_id;
        $branchDetail->company_id = $request->input('company_id');
        $branchDetail->branch_name = $request->input('branch_name');
        $branchDetail->address1 = $request->input('address1');
        $branchDetail->address2 = $request->input('address2');
        $branchDetail->address3 = $request->input('address3');
        $branchDetail->city_id = $request->input('city_id');
        $branchDetail->district_id = $request->input('district_id');
        $branchDetail->state_id = $request->input('state_id');
        $branchDetail->gst_no = $request->input('gst_no');
        $branchDetail->pincode = $request->input('pincode');
        $branchDetail->created_id = Auth::user()->user_id;
        $branchDetail->created_at = date('Y-m-d H:i:s');
        $branchDetail->save();
        $request->session()->put('branch_id', $branchDetail->branch_id);
        $request->session()->flash('create-status', 'Branch Successful Created...');
        return redirect('branch');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companyList = CompanyMaster::get();
        $cityList = Citys::get();
        $branch = Branch::find($id);
        return view('branchmaster.create')->with('action', 'UPDATE')->with('companyList', $companyList)->with('cityList', $cityList)->with('branch', $branch);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'company_id.required' => 'Please Select Company Name',
            'city_is.required' => 'Please Select City Name',
        ];
        $rules = [
            'company_id' => 'required',
            'branch_name' => 'required',
            'address1' => 'required',
            'city_id' => 'required',
            'pincode' => 'required',
            'gst_no' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $branchDetail = Branch::find($id);
        $branchDetail->company_id = $request->input('company_id');
        $branchDetail->branch_name = $request->input('branch_name');
        $branchDetail->address1 = $request->input('address1');
        $branchDetail->address2 = $request->input('address2');
        $branchDetail->address3 = $request->input('address3');
        $branchDetail->city_id = $request->input('city_id');
        $branchDetail->district_id = $request->input('district_id');
        $branchDetail->state_id = $request->input('state_id');
        $branchDetail->gst_no = $request->input('gst_no');
        $branchDetail->pincode = $request->input('pincode');
        $branchDetail->created_id = Auth::user()->user_id;
        $branchDetail->created_at = date('Y-m-d H:i:s');
        $branchDetail->save();
        $request->session()->flash('update-status', 'Branch Successful Updated...');
        return redirect('branch');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy($branch_id, Request $request)
    {
        Branch::destroy($branch_id);
        $request->session()->flash('delete-status', 'Branch Successful Deleted...');
        return redirect('branch');
    }


}
