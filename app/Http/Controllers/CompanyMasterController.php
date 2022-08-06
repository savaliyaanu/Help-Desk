<?php

namespace App\Http\Controllers;

use App\Citys;
use App\CompanyMaster;
use App\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CompanyMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('companymaster.index')->with('AJAX_PATH', 'get-company');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'company_master_view';

        /** Table's primary key */
        $primaryKey = 'company_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
            $columns = array(
                array('db' => 'company_name', 'dt' => 0),
                array('db' => 'city_name', 'dt' => 1),
                array('db' => 'district', 'dt' => 2),
                array('db' => 'state', 'dt' => 3),
                array('db' => 'phone', 'dt' => 4),
                array('db' => 'edit', 'dt' => 5),
                array('db' => 'delete', 'dt' => 6),
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
        $cityList = Citys::get();
        return view('companymaster.create')->with('action', 'INSERT')->with('cityList', $cityList);
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

        $companyItem = new CompanyMaster();
        $companyItem->company_name = $request->input('company_name');
        $companyItem->financial_id = $financialYear->financial_id;
        $companyItem->address1 = $request->input('address1');
        $companyItem->address2 = $request->input('address2');
        $companyItem->address3 = $request->input('address3');
        $companyItem->city_id = $request->input('city_id');
        $companyItem->district_id = $request->input('district_id');
        $companyItem->state_id = $request->input('state_id');
        $companyItem->phone = $request->input('phone');
        $companyItem->pincode = $request->input('pincode');
        $companyItem->email = $request->input('email');
        $companyItem->created_id = Auth::user()->user_id;
        $companyItem->created_at = date('Y-m-d H:i:s');
        $companyItem->save();
        $request->session()->flash('create-status', 'Company Successful Created...');
        return redirect('company');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\CompanyMaster $companyMaster
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyMaster $companyMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\CompanyMaster $companyMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cityList = Citys::get();
        $companyDetail = CompanyMaster::find($id);
        return view('companymaster.create')->with('action', 'UPDATE')->with('cityList', $cityList)->with('companyItem', $companyDetail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\CompanyMaster $companyMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $messages = [
//            'company_name.required' => 'Please Enter Company Name',
//        ];
//        $rules = [
//            'company_name' => 'required',
//            'address1' => 'required',
//            'city_id' => 'required',
//            'district_id' => 'required',
//            'state_id' => 'required',
//            'phone' => 'required',
//            'pincode' => 'required',
//            'email' => 'required',
//        ];
//        Validator::make($request->all(), $rules, $messages)->validate();
        $companyItem = CompanyMaster::find($id);
        $companyItem->company_name = $request->input('company_name');
        $companyItem->address1 = $request->input('address1');
        $companyItem->address2 = $request->input('address2');
        $companyItem->address3 = $request->input('address3');
        $companyItem->city_id = $request->input('city_id');
        $companyItem->district_id = $request->input('district_id');
        $companyItem->state_id = $request->input('state_id');
        $companyItem->phone = $request->input('phone');
        $companyItem->pincode = $request->input('pincode');
        $companyItem->email = $request->input('email');
        $companyItem->created_id = Auth::user()->user_id;
        $companyItem->created_at = date('Y-m-d H:i:s');
        $companyItem->save();
        $request->session()->flash('update-status', 'Company Successful Updated...');
        return redirect('company');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CompanyMaster $companyMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($company_id, Request $request)
    {
        CompanyMaster::destroy($company_id);
        $request->session()->flash('delete-status', 'Company Successful Deleted...');
        return redirect('company');
    }


    public function downloadExcel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');
    }
}
