<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientMaster = DB::table('topland.client_master')
            ->leftJoin('topland.city_master','topland.city_master.city_id','=','topland.client_master.city_id')
            ->get();
        return view('clientmaster.index')->with(compact('clientMaster'));
//        ->with('AJAX_PATH', 'get-client-data')
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'client_master_view';

        /** Table's primary key */
        $primaryKey = 'client_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
            $columns = array(
                array('db' => 'client_name', 'dt' => 0),
                array('db' => 'city_name', 'dt' => 1),
                array('db' => 'district', 'dt' => 2),
                array('db' => 'state', 'dt' => 3),
                array('db' => 'mobile', 'dt' => 4),
                array('db' => 'gst_no', 'dt' => 5),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
