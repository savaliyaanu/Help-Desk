<?php

namespace App\Http\Controllers;

use App\Branch;
use App\CompanyMaster;
use App\FinancialYear;
use App\ServiceStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceStationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $serviceDetail = ServiceStation::with('getBranchName')->with('getCompany')->get();
        return view('servicestation.index')->with('AJAX_PATH', 'get-service-station');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'service_station_view';

        /** Table's primary key */
        $primaryKey = 'service_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'company_name', 'dt' => 0),
            array('db' => 'branch_name', 'dt' => 1),
            array('db' => 'service_station_name', 'dt' => 2),
            array('db' => 'edit', 'dt' => 3),
            array('db' => 'delete', 'dt' => 4),
        );

        /** SQL server connection information */
        $sql_details = array(
            'user' => env('DB_USERNAME', 'root@localhost'),
            'pass' => env('DB_PASSWORD', ''),
            'db' => env('DB_DATABASE', 'helpdesk'),
            'host' => env('DB_HOST', '172.16.6.50')
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */
//        $where = "branch_id=" . Auth::user()->branch_id;
        $dataRows = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "");
        echo json_encode($dataRows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyDetail = CompanyMaster::get();
        return view('servicestation.create')->with('action', 'INSERT')->with('companyDetail', $companyDetail);
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
        ];
        $rules = [
            'company_id' => 'required',
            'branch_id' => 'required',
            'service_station_name' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $service_station = new ServiceStation();
        $service_station->company_id = $request->input('company_id');
        $service_station->financial_id = $financialYear->financial_id;
        $service_station->branch_id = $request->input('branch_id');
        $service_station->service_station_name = $request->input('service_station_name');
        $service_station->created_id = Auth::user()->user_id;
        $service_station->created_at = date('Y-m-d H:i:s');
        $service_station->save();
        $request->session()->flash('create-status', 'Service Station Successful Created...');
        return redirect('service-station');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ServiceStation $serviceStation
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceStation $serviceStation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ServiceStation $serviceStation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companyDetail = CompanyMaster::get();
        $service_station = ServiceStation::find($id);

        return view('servicestation.create')->with('action', 'UPDATE')->with('companyDetail', $companyDetail)->with('serviceStation', $service_station);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ServiceStation $serviceStation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'company_id.required' => 'Please Select Company Name',
        ];
        $rules = [
            'company_id' => 'required',
            'branch_id' => 'required',
            'service_station_name' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $service_station = ServiceStation::find($id);
        $service_station->company_id = $request->input('company_id');
        $service_station->branch_id = $request->input('branch_id');
        $service_station->service_station_name = $request->input('service_station_name');
        $service_station->updated_id = Auth::user()->user_id;
        $service_station->created_at = date('Y-m-d H:i:s');
        $service_station->save();
        $request->session()->flash('update-status', 'Service Station Successful Updated...');
        return redirect('service-station');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ServiceStation $serviceStation
     * @return \Illuminate\Http\Response
     */
    public function destroy($service_id, Request $request)
    {
        ServiceStation::destroy($service_id);
        $request->session()->flash('delete-status', 'Service Station Successful Deleted...');
        return redirect('service-station');
    }

    public function getBranchDetails(Request $request)
    {
        $company_id = $request->input('company_id');
        $branchList =
            DB::table('branch_master')
                ->select('branch_id', 'branch_name')
                ->where('company_id', '=', $company_id)
                ->get()
                ->toArray();
        $branchList = json_decode(json_encode($branchList), true);
//        print_r($branchList);die();
        $option = "<option value=''>Select Product Name</option>";
        foreach ($branchList as $row) {
            $option .= "<option value='" . $row['branch_id'] . "'>" . $row['branch_name'] . "</option>";
        }
        echo $option;
    }

}
