<?php

namespace App\Http\Controllers;

use App\Billty;
use App\Challan;
use App\Clients;
use App\Complain;
use App\FinancialYear;
use App\Helpers\Helper;
use App\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Fpdf;
use phpDocumentor\Reflection\Types\Integer;

class BilltyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch_id = $request->session()->get('branch_id');
        $billtyIndex = DB::table('billty')
            ->select('billty.*', 'billty_handover_date.handover_date', 'complain.complain_no', 'users.role_id', 'role.role_name', 'complain.client_name',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = billty.financial_id) as fyear"))
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('billty_handover_date', 'billty_handover_date.billty_id', '=', 'billty.billty_id')
            ->leftJoin('users', 'users.user_id', '=', 'billty.created_id')
            ->leftJoin('role', 'role.role_id', '=', 'users.role_id')
            ->where('billty.branch_id', '=', Auth::user()->branch_id)
            ->orderByDesc('billty.billty_id')->paginate(10);
        return view('billty.index')->with(compact('branch_id', 'billtyIndex'));
//        return view('billty.index')->with('AJAX_PATH', 'get-billty');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'billty_view';

        /** Table's primary key */
        $primaryKey = 'billty_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'complain_no', 'dt' => 0),
            array('db' => 'date', 'dt' => 1),
            array('db' => 'challan_type', 'dt' => 2),
            array('db' => 'client_name', 'dt' => 3),
            array('db' => 'lr_no', 'dt' => 4),
            array('db' => 'lr_date', 'dt' => 5),
            array('db' => 'handover_date', 'dt' => 6),
            array('db' => 'billty_pdf', 'dt' => 7),
            array('db' => 'hd_date', 'dt' => 8),
            array('db' => 'edit', 'dt' => 9),
            array('db' => 'delete', 'dt' => 10),
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
        $complainList = Complain::select(DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"),
        'complain.*')
        ->where('branch_id', Auth::user()->branch_id)->get();

        $clientMaster = Clients::select('client_id', 'client_name')
            ->get();
        $transportReceive = Transport::get();
        return view('billty.create')->with('action', 'INSERT')->with('clientMaster', $clientMaster)->with('complainList', $complainList)->with('transportReceive', $transportReceive);
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
            'complain_id.required' => 'Please select Complain No',
            'entry_by.required' => 'Please Enter Entry By Name',
            'transport_id.required' => 'Please select Transport Name',
            'freight_rs.required' => 'Enter only Numeric ',
        ];
        $rules = [
            'complain_id' => 'required',
            'transport_id' => 'required',
            'freight_rs' => 'required',
            'entry_by' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $financialID = $financialYear->financial_id;
        $billtyNo = DB::table('helpdesk.billty')
            ->select('billty_no')
            ->where('branch_id', '=', Auth::user()->branch_id)
            ->where('financial_id', '=', $financialID)
            ->orderBy('billty_no', 'desc')
            ->get()
            ->take(1)
            ->toArray();
        $billtyNo = json_decode(json_encode($billtyNo), true);
        $billtyNo = (!empty($billtyNo[0]['billty_no'])) ? $billtyNo[0]['billty_no'] + 1 : 1;

        $complainID = empty(implode(',', (array)$request->input('complain_id'))) ? '' : implode(',', (array)$request->input('complain_id'));

        $billty = new Billty();
        $billty->financial_id = $financialYear->financial_id;
        $billty->complain_id = $complainID;

        $client_name = DB::table('complain')->where('complain_id', $billty->complain_id)->first();
        $billty->challan_type = $request->input('challan_type');
        $billty->other = $request->input('other');
        $billty->client_id = $client_name->client_id;
        $billty->transport_id = $request->input('transport_id');
        $billty->freight_rs = $request->input('freight_rs');
        $billty->freight_rs_by = $request->input('freight_rs_by');
        $billty->lr_no = $request->input('lr_no');
        $billty->lr_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('lr_date'))));
        $billty->entry_by = $request->input('entry_by');
        $billty->remark = $request->input('remark');
        $billty->created_id = Auth::user()->user_id;
        $billty->branch_id = Auth::user()->branch_id;
        $billty->created_at = date('Y-m-d H:i:s');
        $billty->billty_no = $billtyNo;
        $billty->save();
        if (!empty($request->post('multiple_complain'))) {
            foreach ($request->post('multiple_complain') as $key => $row) {
                $lArray = explode(',', $key);
                $complain_productData = DB::table('complain_item_details')->where('cid_id', $lArray)->first();
                if (count($lArray) > 0) {
                    DB::table('billty_product_details')->insertGetId(
                        [
                            'billty_id' => $billty->billty_id,
                            'complain_id' => $complain_productData->complain_id,
                            'cid_id' => $complain_productData->cid_id,
                            'category_id' => $complain_productData->category_id,
                            'product_id' => $complain_productData->product_id,
                            'serial_no' => $complain_productData->serial_no,
                            'warranty' => $complain_productData->warranty,
                            'complain' => $complain_productData->complain,
                            'production_no' => $complain_productData->production_no,
                            'invoice_no' => $complain_productData->invoice_no,
                            'invoice_date' => $complain_productData->invoice_date,
                            'quantity' => $complain_productData->qty,
                            'created_id' => Auth::user()->user_id,
                            'application' => $complain_productData->application
                        ]
                    );
                }
            }
        }
        $request->session()->flash('create-status', 'Billty Successfully Created..');

        return redirect('billty');
    }

    /**
     * Display the specified resource.
     *c
     * @param \App\Billty $billty
     * @return \Illuminate\Http\Response
     */
    public function show(Billty $billty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Billty $billty
     * @return \Illuminate\Http\Response
     */
    public function edit(Billty $billty)
    {
        $clientMaster =
            DB::table('topland.client_master')->where('client_id', $billty->client_id)
                ->get()
                ->toArray();
        $clientMaster = json_decode(json_encode($clientMaster), true);
        $complainList = DB::table('helpdesk.complain')
            ->where('branch_id', '=', Auth::user()->branch_id)
            ->get()
            ->toArray();
        $complainList = json_decode(json_encode($complainList), true);
        $transportReceive = DB::table('topland.transport_master')->where('transport_id', $billty->transport_id)
            ->get()
            ->toArray();
        $transportReceive = json_decode(json_encode($transportReceive), true);

        return view('billty.create')->with('action', 'UPDATE')->with(compact('billty'))->with('clientMaster', $clientMaster)->with('complainList', $complainList)->with('transportReceive', $transportReceive);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Billty $billty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Billty $billty)
    {
        $messages = [
            'complain_id.required' => 'Please select Complain No',
            'entry_by.required' => 'Please Enter Entry By Name',
            'transport_id.required' => 'Please select Transport Name',
            'freight_rs.required' => 'Enter only Numeric ',
        ];
        $rules = [
            'complain_id' => 'required',
            'transport_id' => 'required',
            'freight_rs' => 'required',
            'entry_by' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $billty->challan_type = $request->input('challan_type');
        $billty->other = $request->input('other');
        $billty->transport_id = $request->input('transport_id');
        $billty->freight_rs = $request->input('freight_rs');
        $billty->freight_rs_by = $request->input('freight_rs_by');
        $billty->lr_no = $request->input('lr_no');
        $billty->lr_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('lr_date'))));
        $billty->entry_by = $request->input('entry_by');
        $billty->remark = $request->input('remark');
        $billty->updated_id = Auth::user()->user_id;
        $billty->updated_at = date('Y-m-d H:i:s');
        $billty->save();
        $request->session()->flash('update-status', 'Billty Successfully Updated...');
        return redirect('billty');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Billty $billty
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $billty = Billty::find($id);
        $challan = Challan::where('challan.billty_id', '=', $id)->get();
        if (!empty(isset($challan[0]->billty_id) == $id)) {
            $request->session()->flash('delete-status', 'Challan Created so Do not Delete Billty...!');
            return redirect('billty');
        } else {
            DB::table('complain')->where('complain_id', $billty->complain_id)->update(['billty_create' => 'N']);
            DB::table('billty_product_details')->where('billty_id', $id)->delete();
            Billty::destroy($id);
            $request->session()->flash('delete-status', 'Billty Successfully Deleted..');
            return redirect('billty');
        }
    }

    public function saveHandOverDate(Request $request)
    {
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $billty_id = $_POST['billty_id'];
        $handover_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('handover_date'))));
        $created_id = Auth::user()->user_id;
        $financial_id = $financialYear->financial_id;
        DB::table('billty_handover_date')->where('billty_id', $billty_id)->delete();
        DB::table('billty_handover_date')->insert(array('created_id' => $created_id, 'financial_id' => $financial_id, 'billty_id' => $billty_id, 'handover_date' => $handover_date, 'created_at' => date('Y-m-d')));
        return redirect('billty');
    }

    public function billtyFpdf($billty_id)
    {
        $billty = Helper::billtyPDF($billty_id);
        Fpdf::Output();
        echo $billty;
    }

    public function getComplainProduct()
    {
        $complain_id = \request()->input('complain_id');
        $productList = DB::table('complain_item_details')
            ->select('topland.product_master.product_name', 'complain_item_details.cid_id', 'complain.complain_no',
                'complain_item_details.serial_no', 'complain_item_details.complain', 'complain_item_details.invoice_no',
                'complain_item_details.invoice_date', 'complain_item_details.warranty', 'complain_item_details.production_no','complain_item_details.qty as quantity',
                'complain_item_details.application', 'topland.category_master.category_name','complain.client_name')
            ->leftJoin('complain', 'complain.complain_id', '=', 'complain_item_details.complain_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'topland.product_master.category_id')
            ->where('complain_item_details.is_check', '=', 'N')
            ->where('complain_item_details.complain_id', $complain_id)->get();
        return response()->json($productList);
    }
}
