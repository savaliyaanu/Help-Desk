<?php

namespace App\Http\Controllers;


use App\FinancialYear;
use App\Helpers\Helper;
use Fpdf;
use App\DeliveryChallanOut;
use App\DeliveryChallanOutProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeliveryChallanOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_out = DB::table('delivery_challan_out')
            ->select('complain.complain_no', 'complain.client_name', 'delivery_challan_out.*', 'topland.supplier_master.supplier_name',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = delivery_challan_out.financial_id) as fyear"))
            ->join('challan', 'challan.challan_id', '=', 'delivery_challan_out.challan_id')
            ->join('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->join('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->join('topland.supplier_master', 'topland.supplier_master.supplier_id', '=', 'delivery_challan_out.supplier_id')
            ->where('delivery_challan_out.branch_id', '=', Auth::user()->branch_id)
            ->orderByDesc('delivery_challan_out_id')
            ->get();

        return view('deliverychallan.index')->with(compact('delivery_out'));
//        return view('deliverychallan.index')->with('AJAX_PATH', 'get-delivery-challan');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'delivery_challan_view';

        /** Table's primary key */
        $primaryKey = 'delivery_challan_out_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'complain_no', 'dt' => 0),
            array('db' => 'client_name', 'dt' => 1),
            array('db' => 'date', 'dt' => 2),
            array('db' => 'supplier_name', 'dt' => 3),
            array('db' => 'status', 'dt' => 4),
            array('db' => 'print_pdf_out', 'dt' => 5),
            array('db' => 'print_pdf', 'dt' => 6),
            array('db' => 'product_inward', 'dt' => 7),
            array('db' => 'edit', 'dt' => 8),
            array('db' => 'delete', 'dt' => 9)
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
        $challan_list = DB::table('challan')
            ->select('complain.complain_no', 'challan.challan_id', 'complain.client_name',
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"),'challan.branch_id')
            ->join('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->join('complain', 'complain.complain_id', '=', 'billty.complain_id')
//            ->whereNOTIn('challan_id', function ($query) {
//                $query->select('challan_id')->from('delivery_challan_out');
//            })
            ->where('challan.branch_id', '=', Auth::user()->branch_id)
            ->get();

        $supplier_list = DB::table('topland.supplier_master')->get();

//        print_r($challan_list);die();
        return view('deliverychallan.create')->with('action', 'INSERT')->with(compact('challan_list', 'supplier_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $deliveryNo = DB::table('helpdesk.delivery_challan_out')
            ->select('delivery_challan_no')
            ->where('branch_id', '=', Auth::user()->branch_id)
            ->orderBy('delivery_challan_no', 'desc')
            ->get()
            ->take(1)
            ->toArray();
        $deliveryNo = json_decode(json_encode($deliveryNo), true);
        $deliveryNo = (!empty($deliveryNo[0]['delivery_challan_no'])) ? $deliveryNo[0]['delivery_challan_no'] + 1 : 1;

        $challan_id = $request->input('challan_id');

        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $delivery_out = new DeliveryChallanOut();
        $delivery_out->financial_id = $financialYear->financial_id;
        $delivery_out->delivery_challan_no = $deliveryNo;
        $delivery_out->challan_id = implode(',',$challan_id);
        $delivery_out->supplier_id = $request->input('supplier_id');
        $delivery_out->despatched_through = $request->input('despatched_through');
        $delivery_out->destination = $request->input('destination');
        $delivery_out->transport_vehicle = $request->input('transport_vehicle');
        $delivery_out->lr_no = $request->input('lr_no');
        $delivery_out->created_id = Auth::user()->user_id;
        $delivery_out->branch_id = Auth::user()->branch_id;
        $delivery_out->save();
        foreach ( $challan_id as $item) {
            DB::table('multiple_complain_to_supplier')->insertGetId(
                [
                    'delivery_challan_out_id' => $delivery_out->delivery_challan_out_id,
                    'challan_id' => $item,
                    'created_id' => Auth::user()->user_id
                ]
            );
        }
        $request->session()->put('delivery_challan_out_id', $delivery_out->delivery_challan_out_id);
        $request->session()->flash('create-status', 'Delivery Challan Successfully Created..');
        return redirect('delivery-challan-product/' . $delivery_out->delivery_challan_out_id);
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
        $challan_list = DB::table('challan')
            ->select('complain.complain_no', 'challan.challan_id', 'complain.client_name','challan.branch_id',
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->join('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->join('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->where('challan.branch_id', '=', Auth::user()->branch_id)
            ->get();
        $supplier_list = DB::table('topland.supplier_master')->get();
        $delivery_challan_out = DeliveryChallanOut::find($id);
        return view('deliverychallan.create')->with('action', 'UPDATE')->with(compact('challan_list', 'supplier_list', 'delivery_challan_out'));
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
        $challan_id = $request->input('challan_id');
        $delivery_out = DeliveryChallanOut::find($id);
        $delivery_out->challan_id =$challan_id;
        $delivery_out->supplier_id = $request->input('supplier_id');
        $delivery_out->despatched_through = $request->input('despatched_through');
        $delivery_out->destination = $request->input('destination');
        $delivery_out->transport_vehicle = $request->input('transport_vehicle');
        $delivery_out->lr_no = $request->input('lr_no');
        $delivery_out->updated_id = Auth::user()->user_id;
        $delivery_out->branch_id = Auth::user()->branch_id;
        $delivery_out->save();
        $request->session()->flash('update-status', 'Delivery Challan Successfully Updated..');
        return redirect('delivery-challan-product/' . $delivery_out->delivery_challan_out_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        DeliveryChallanOut::destroy($id);
        DeliveryChallanOutProduct::where('delivery_challan_out_id', $id)->get();
        $request->session()->flash('delete-status', 'Delivery Challan Successfully Deleted..');

        return redirect('delivery-out');
    }

    public function challanOutReport($delivery_challan_out_id)
    {
        $challanOut = Helper::deliveryChallanOutReport($delivery_challan_out_id);
        Fpdf::Output();
        echo $challanOut;
    }

    public function challanInReport($delivery_challan_out_id)
    {
        $challanOut = Helper::deliveryChallanInReport($delivery_challan_out_id);
        Fpdf::Output();
        echo $challanOut;
    }
}
