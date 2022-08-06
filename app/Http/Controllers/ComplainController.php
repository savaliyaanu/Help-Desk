<?php

namespace App\Http\Controllers;

use App\Billty;
use App\Citys;
use App\Complain;
use App\FinancialYear;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Fpdf;
use Symfony\Component\HttpKernel\Event\RequestEvent;


class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $complain = Complain::with('getClients')->with('getCity.getDistrict.getState')
            ->select('complain.*', DB::raw("CONCAT(topland.user_master.user_fname,' ',topland.user_master.user_lname) as assign_name"),
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"), 'users.name')
            ->leftJoin('topland.user_master', 'topland.user_master.user_id', '=', 'complain.assign_id')
            ->leftJoin('users', 'users.user_id', '=', 'complain.created_id')
            ->leftJoin('financial_year', 'financial_year.financial_id', '=', 'complain.financial_id')
            ->where('complain.branch_id', '=', Auth::user()->branch_id)
            ->orderByDesc('complain.complain_id')
            ->paginate(20);
        return view('complains.index')->with(compact('complain'));
//        return view('complains.index')->with('AJAX_PATH', 'get-complain-detail-table-view');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'complain_view';
        /** Table's primary key */
        $primaryKey = 'complain_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'complain_no', 'dt' => 0),
            array('db' => 'complain_date', 'dt' => 1),
            array('db' => 'complain_type', 'dt' => 2),
            array('db' => 'client_name', 'dt' => 3),
            array('db' => 'city_name', 'dt' => 4),
            array('db' => 'district_name', 'dt' => 5),
            array('db' => 'state_name', 'dt' => 6),
            array('db' => 'complain_status', 'dt' => 7),
            array('db' => 'medium_name', 'dt' => 8),
            array('db' => 'user_name', 'dt' => 9),
            array('db' => 'complain_assign', 'dt' => 10),
            array('db' => 'complain_resolved', 'dt' => 11),
            array('db' => 'complain_followup', 'dt' => 12),
            array('db' => 'complain_followup_history', 'dt' => 13),
            array('db' => 'complain_pdf', 'dt' => 14),
            array('db' => 'edit', 'dt' => 15)
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
    public function create(Request $request)
    {
        $categoryMaster =
            DB::table('topland.category_master')
                ->get()
                ->toArray();
        $categoryMaster = json_decode(json_encode($categoryMaster), true);
        $product_master =
            DB::table('topland.product_master')
                ->get()
                ->toArray();
        $product_master = json_decode(json_encode($product_master), true);
        $medium =
            DB::table('helpdesk.medium')
                ->get();
        $branch_id = $request->session()->get('branch_id');
        $ComplainList =
            DB::table('support')
                ->get()
                ->toArray();
        $ComplainList = json_decode(json_encode($ComplainList), true);
        return view('theme.metronic.complain.create')->with('action', 'INSERT')->with(compact('product_master', 'categoryMaster', 'branch_id', 'medium', 'ComplainList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $complainNo
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'medium_id.required' => 'Please select Medium Name',
        ];
        $rules = [
            'medium_id' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'city_id' => 'required',
            'district' => 'required',
            'state' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $financialID = $financialYear->financial_id;
        $complainNo = DB::table('helpdesk.complain')
            ->select('complain_no')
            ->where('branch_id', '=', Auth::user()->branch_id)
            ->where('financial_id', '=', $financialID)
            ->orderBy('complain_no', 'desc')
            ->get()
            ->take(1)
            ->toArray();
        $complainNo = json_decode(json_encode($complainNo), true);
        $complainNo = (!empty($complainNo[0]['complain_no'])) ? $complainNo[0]['complain_no'] + 1 : 1;

        $columnArray = [
            'financial_id' => $financialYear->financial_id,
            'client_id' => $request->post('client_id'),
            'distributor_id' => $request->post('distributor_id'),
            'complain_type' => $request->post('complain_type'),
            'problem' => $request->post('problem'),
            'client_name' => $request->post('client_name'),
            'address' => $request->post('address'),
            'mobile' => $request->post('mobile'),
            'mobile2' => $request->post('mobile2'),
            'email_address' => $request->post('email_address'),
            'city_id' => $request->post('city_id'),
            'district' => $request->post('district'),
            'state' => $request->post('state'),
            'medium_id' => $request->post('medium_id'),
            'complain_gst' => $request->post('complain_gst'),
            'created_id' => Auth::user()->user_id,
            'branch_id' => Auth::user()->branch_id,
            'created_at' => date('Y-m-d H:i:s'),
            'complain_no' => $complainNo,
        ];
        $ID = DB::table('complain')->insertGetId($columnArray);
        $request->session()->put('id', $ID);

        $complanMedium = [
            'whatsapp_no' => $request->post('whatsapp_no'),
            'email' => $request->post('email'),
            'voucher_no' => $request->post('voucher_no'),
            'mobile_no' => $request->post('mobile_no'),
            'vehicle_no' => $request->post('vehicle_no'),
            'staff_name' => $request->post('staff_name'),
            'created_id' => Auth::user()->user_id,
            'branch_id' => Auth::user()->branch_id,
            'created_at' => date('Y-m-d H:i:s'),
            'complain_id' => $ID,
        ];
        DB::table('complain_medium_details')->insertGetId($complanMedium);
        $i = 0;
        DB::table('complain_log')->insert(['complain_id' => $ID, 'complain_status' => 'Complain Registered', 'created_id' => Auth::user()->user_id, 'created_at' => date('Y-m-d H:i:s')]);
        if (!empty($request->post('data'))) {

            foreach ($request->post('data') as $row) {
                if (!empty($row['product_id'])) {
                    $cid_id = DB::table('complain_item_details')->insertGetId(
                        [
                            'complain_id' => $ID,
                            'category_id' => $row['category_id'],
                            'product_id' => $row['product_id'],
                            'serial_no' => $row['sr_no'],
                            'warranty' => $row['warranty'],
                            'production_no' => $row['production_no'],
                            'invoice_no' => $row['invoice_no'],
                            'invoice_date' => $row['invoice_date'],
                            'qty' => $row['qty'],
                            'branch_id' => Auth::user()->branch_id,
                            'created_id' => Auth::user()->user_id,
                            'application' => $row['application']
                        ]
                    );

                    foreach ($row['complain'] as $complain) {
                        DB::table('multiple_product_complain')->insertGetId(
                            [
                                'complain_id' => $ID,
                                'complain_product_id' => $cid_id,
                                'complain_in_word' => $complain,
                                'created_id' => Auth::user()->user_id
                            ]
                        );
                    }
                }
                $i++;
            }
        }
        $request->session()->flash('create-status', 'Complain Successfully Created..');

        $next_assign = $request->post('next_assign');
        if ($next_assign) {
            return redirect('complain-assign/' . $ID);
        }
        return redirect('complain-detail/');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Complain $complain
     * @return \Illuminate\Http\Response
     */
    public function show(Complain $complain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Complain $complain
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ComplainList =
            DB::table('support')
                ->get()
                ->toArray();
        $ComplainList = json_decode(json_encode($ComplainList), true);
//        echo "<pre>";
//        print_r($ComplainList);exit;
        $complain =
            DB::table('complain')
                ->where('complain_id', '=', $id)
                ->get()
                ->toArray();
        $complain = json_decode(json_encode($complain), true);

        $complainMedium =
            DB::table('complain_medium_details')
                ->where('complain_id', '=', $id)
                ->get()
                ->toArray();
        $complainMedium = json_decode(json_encode($complainMedium), true);


        $complain_detail =
            DB::table('complain_item_details')
                ->where('complain_id', '=', $id)
                ->get()
                ->toArray();
        $complain_detail = json_decode(json_encode($complain_detail), true);

        $cityMaster =
            DB::table('topland.city_master')->where('city_id', $complain[0]['city_id'])
                ->get();
        $clientMaster =
            DB::table('topland.client_master')->where('client_id', $complain[0]['client_id'])
                ->get();

        $categoryMaster =
            DB::table('topland.category_master')
                ->get()
                ->toArray();
        $categoryMaster = json_decode(json_encode($categoryMaster), true);
        $product_master =
            DB::table('topland.product_master')
                ->get()
                ->toArray();
        $product_master = json_decode(json_encode($product_master), true);
        $medium =
            DB::table('helpdesk.medium')
                ->get();

        return view('theme.metronic.complain.create')->with(compact('complain', 'ComplainList', 'clientMaster', 'product_master', 'categoryMaster', 'medium', 'complain_detail', 'cityMaster', 'complainMedium'))->with('action', 'UPDATE');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Complain $complain
     * @param $columnArray
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $complan_id)
    {

        $messages = [
            'medium_id.required' => 'Please select Medium Name',
        ];
        $rules = [
            'medium_id' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'city_id' => 'required',
            'district' => 'required',
            'state' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $columnArray = [
            'client_id' => $request->post('client_id'),
            'distributor_id' => $request->post('distributor_id'),
            'complain_type' => $request->post('complain_type'),
            'problem' => $request->post('problem'),
            'client_name' => $request->post('client_name'),
            'address' => $request->post('address'),
            'mobile' => $request->post('mobile'),
            'mobile2' => $request->post('mobile2'),
            'email_address' => $request->post('email_address'),
            'city_id' => $request->post('city_id'),
            'district' => $request->post('district'),
            'state' => $request->post('state'),
            'medium_id' => $request->post('medium_id'),
            'complain_gst' => $request->post('complain_gst'),
            'updated_id' => Auth::user()->user_id,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('complain')
            ->where('complain_id', $complan_id)
            ->update($columnArray);

        $complanMedium = [
            'whatsapp_no' => $request->post('whatsapp_no'),
            'email' => $request->post('email'),
            'voucher_no' => $request->post('voucher_no'),
            'mobile_no' => $request->post('mobile_no'),
            'vehicle_no' => $request->post('vehicle_no'),
            'staff_name' => $request->post('staff_name'),
            'updated_id' => Auth::user()->user_id,
            'branch_id' => Auth::user()->branch_id,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('complain_medium_details')->where('complain_id', $complan_id)->update($complanMedium);

        DB::table('complain_item_details')->where('complain_id', $complan_id)->update(['is_delete' => 'N']);
        $i = 0;
        if (!empty($request->post('data'))) {
            foreach ($request->post('data') as $row) {
                if (!empty($row['product_id'])) {
                    $array = [
                        'complain_id' => $complan_id,
                        'category_id' => $row['category_id'],
                        'is_delete' => 'Y',
                        'product_id' => $row['product_id'],
                        'serial_no' => $row['sr_no'],
                        'warranty' => $row['warranty'],
                        'production_no' => $row['production_no'],
                        'invoice_no' => $row['invoice_no'],
                        'invoice_date' => $row['invoice_date'],
                        'qty' => $row['qty'],
                        'branch_id' => Auth::user()->branch_id,
                        'updated_id' => Auth::user()->user_id,
                        'application' => $row['application']
                    ];

                    $billtyArray = [
                        // 'cid_id'=>$request->post('cid_id'),
                        'complain_id' => $complan_id,
                        'category_id' => $row['category_id'],
                        'product_id' => $row['product_id'],
                        'serial_no' => $row['sr_no'],
                        'warranty' => $row['warranty'],
                        'complain' => $row['complain'],
                        'production_no' => $row['production_no'],
                        'invoice_no' => $row['invoice_no'],
                        'invoice_date' => $row['invoice_date'],
                        'quantity' => $row['qty'],
                        'updated_id' => Auth::user()->user_id,
                        'application' => $row['application']
                    ];
                    $challanArray = [
                        // 'complain_product_id'=>$request->post('cid_id'),
                        'complain_id' => $complan_id,
                        'category_id' => $row['category_id'],
                        'product_id' => $row['product_id'],
                        'serial_no' => $row['sr_no'],
                        'warranty' => $row['warranty'],
                        'production_no' => $row['production_no'],
                        'bill_no' => $row['invoice_no'],
                        'bill_date' => $row['invoice_date'],
                        'quantity' => $row['qty'],
                        'updated_id' => Auth::user()->user_id,
                        'application' => $row['application']
                    ];
                    if (!empty($request->post('cid_id')[$i])) {
                        DB::table('complain_item_details')->where('cid_id', $request->post('cid_id')[$i])->update($array);
                        DB::table('billty_product_details')->where('cid_id', $request->post('cid_id')[$i])->update($billtyArray);
                        DB::table('challan_item_master')->where('complain_product_id', $request->post('cid_id')[$i])->update($challanArray);
                    } else {
                        DB::table('complain_item_details')->insert($array);
//                        DB::table('billty_product_details')->insert($billtyArray);
                    }
                }
                $i++;
            }
        }

        DB::table('complain_item_details')->where('complain_id', $complan_id)->where('is_delete', 'N')->delete();
        $request->session()->flash('update-status', 'Complain Successfully Updated..');
        $next_assign = $request->post('next_assign');
        if ($next_assign) {
            return redirect('complain-assign/' . $complan_id);
        }
        return redirect('complain-detail/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Complain $complain
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $billty = Billty::where('billty.complain_id', '=', $id)->get();
        if (!empty(isset($billty[0]->complain_id) == $id)) {
            $request->session()->flash('delete-status', 'Billty Created so Do not Deleted  Complain....!');
            return redirect('complain-detail/');
        } else {
            DB::table('complain_item_details')->where('complain_id', '=', $id)->delete();
            Complain::destroy($id);
            $request->session()->flash('delete-status', 'Complain Deleted Successfully....!');
            return redirect('complain-detail/');
        }
    }

    public function getClientDetails(Request $request)
    {
        $client_id = $request->input('client_id');
        $clientDetail =
            DB::table('topland.client_master')
                ->select('topland.client_master.gst_no as complain_gst', 'topland.client_master.email as complain_email', 'city_master.city_name', 'client_name', 'client_id', 'address1', 'address2', 'address3', 'client_master.city_id', 'client_master.state_id', 'client_master.district_id', 'client_master.mobile')
                ->leftjoin('topland.city_master', 'city_master.city_id', '=', 'client_master.city_id')
                ->where('client_id', '=', $client_id)
                ->get()
                ->toArray();

        return json_encode($clientDetail[0]);
    }

    public function getProducts(Request $request)
    {
        $categoryId = $request->input('category_id');
        $product_id = $request->input('product_id');
        $products = DB::table('topland.product_master')->where('category_id', $categoryId)->orderBy('product_name', 'ASC')->get();
        $options = '';
        foreach ($products as $key => $value) {
            $selected = ($value->product_id == $product_id) ? 'selected' : '';
            $options .= '<option value="' . $value->product_id . '" ' . $selected . '>' . $value->product_name . '( ' . $value->part_code . ' )' . '</option>';
        }
        return Response($options);
    }

    public function log($id)
    {
        $complainLog = DB::table('followup')
            ->select('users.name', 'followup.*')
            ->leftjoin('users', 'user_id', '=', 'created_id')
            ->where('complain_id', '=', $id)
            ->get()
            ->toArray();
        $complainLog = json_decode(json_encode($complainLog), true);

        return view('complains.log')->with('complainLog', $complainLog);
    }

    public function assignComplain($id)
    {
        $userList = DB::table('topland.user_master')
            ->select('user_fname', 'user_lname', 'user_id')
            ->get()
            ->toArray();
        $userList = json_decode(json_encode($userList), true);

        $complain = Complain::find($id);
        return view('theme.metronic.complain.assign')->with('action', 'INSERT')->with('userList', $userList)->with('complain_no', $complain);
    }

    public function saveAssign(Request $request)
    {
        $complain_id = $request->input('com_id');
        $assign_id = $request->input('assign_id');
        $complain = Complain::find($complain_id);
        $complain->assign_id = $assign_id;
        $complain->save();
        return redirect('complain-detail/');
    }

    public function saveFollowUp(Request $request)
    {
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $complain_id = $request->input('complain_id');
        $remark = $request->input('remark');
        $financial_id = $financialYear->financial_id;
        $created_id = Auth::user()->user_id;
        $next_followup_date = $request->input('next_followup_date');
        DB::table('followup')->insert(array('created_id' => $created_id, 'complain_id' => $complain_id, 'remark' => $remark, 'created_at' => date('Y-m-d H:i:s'), 'financial_id' => $financial_id, 'next_followup_date' => date('Y-m-d', strtotime(str_replace('/', '-', $next_followup_date)))));
        return redirect('complain-detail/');
    }

    public function resolved(Request $request)
    {
        $complain_id = $_POST['complain_id'];
        $resolve_date = $request->input('resolve_date');
        $complainDetails = DB::table('complain')
            ->select('*')
            ->where('complain_id', '=', $complain_id)
            ->get()
            ->toArray();
        $complainDetails = json_decode(json_encode($complainDetails), true);
        if ($complainDetails[0]['complain_type'] == 'Product Complain') {
            $complainLog = DB::table('complain_item_details')
                ->select('topland.product_master.product_name', 'complain_item_details.*')
                ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'complain_item_details.product_id')
                ->where('complain_id', '=', $complain_id)
                ->get()
                ->toArray();
            $complainLog = json_decode(json_encode($complainLog), true);
            echo $table = '
    <input type="hidden" name="complain_id" value="' . $complain_id . '">
     <div class="form-group row">
        <label class="col-form-label text-right col-lg-3 col-sm-12">Resolve Date <span
                class="text-danger">*</span></label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            <div class="input-group date">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="la la-calendar"></i>
                    </span>
                </div>
                <input type="date"
                       class="form-control "
                       name="resolve_date" placeholder="Select Date" id="resolve_date"
                       value="' . $resolve_date . '"/>
            </div>
        </div>
   </div>

<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Problem</th>
                        <th>Solution</th>
                        <th>Solution By</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($complainLog as $row) {
                $pending = ($row['complain_status'] == 'Pending') ? 'selected' : '';
                $resolved = ($row['complain_status'] == 'Resolved') ? 'selected' : '';
                echo '<tr>
                        <td>' . $row['product_name'] . '</td>
                        <td>' . $row['complain'] . '</td>
                        <td><input type="text" name="solution[]" value="' . $row['solution'] . '" placeholder="Enter Solution" class="form-control"><input type="hidden" name="cid[]" value="' . $row['cid_id'] . '"></td>
                        <td><input type="text" name="solution_by[]" value="' . $row['solution_by'] . '" placeholder="Enter Solution By" class="form-control"></td>
                    <td><select class="form-control" name="complain_status[]"><option value="Pending" ' . $pending . '>Pending</option><option value="Resolved" ' . $resolved . '>Resolved</option></select></td>
                    </tr>';
            }
            echo '</tbody></table>';
        } else {
            echo $table = '
    <input type="hidden" name="complain_id" value="' . $complain_id . '">
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-3 col-sm-12">Resolve Date <span
                class="text-danger">*</span></label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            <div class="input-group date">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="la la-calendar"></i>
                    </span>
                </div>
                <input type="date"
                       class="form-control "
                       name="resolve_date" placeholder="Select Date" id="resolve_date"
                      value="' . $resolve_date . '"/>
            </div>
        </div>
   </div>
<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                    <thead>
                    <tr>
                        <th>Problem</th>
                        <th>Solution</th>
                        <th>Solution By</th>
                    </tr>
                    </thead>
                    <tbody>';
            $pending = ($complainDetails[0]['complain_status'] == 'Pending') ? 'selected' : '';
            $resolved = ($complainDetails[0]['complain_status'] == 'Resolved') ? 'selected' : '';
            echo '<tr>
                        <td><input type="text" name="problem" value="' . $complainDetails[0]['problem'] . '" placeholder="Enter Solution" class="form-control"></td>
                        <td><input type="text" name="solution" value="' . $complainDetails[0]['solution'] . '" placeholder="Enter Solution" class="form-control"></td>
                        <td><input type="text" name="solution_by" value="' . $complainDetails[0]['solution_by'] . '" placeholder="Enter Solution By" class="form-control "></td>
                    </tr>';
            echo '</tbody></table>';

        }
    }

    public function getLastComplain()
    {
        $sr_no = $_POST['sr_no'];
        $current_complain_id = $_POST['current_complain_id'];
        $product_id = $_POST['product_id'];

        $productHistory = DB::table('topland.invoice_serial_info')
            ->select('topland.product_master.product_name', 'topland.client_master.client_name', 'topland.invoice_serial_info.invoice_no', 'topland.invoice_serial_info.invoice_date', 'topland.invoice_serial_info.production_no')
            ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'topland.invoice_serial_info.product_id')
            ->leftjoin('topland.client_master', 'topland.client_master.client_id', '=', 'topland.invoice_serial_info.party_id')
            ->where('topland.invoice_serial_info.product_id', '=', $product_id)
            ->where('topland.invoice_serial_info.serial_no', '=', $sr_no)
            ->get()
            ->toArray();
        $productHistory = json_decode(json_encode($productHistory), true);
        if (!empty($productHistory)) {
            echo $table = '
<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                    <thead>
                    <tr>
                        <th class="text-center" colspan="6">INVOICE DETAIL</th>
                    </tr><tr>
                        <th>Client Name</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Production No</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($productHistory as $row) {
                echo '<tr>
                        <td>' . $row['client_name'] . '</td>
                        <td>' . $row['invoice_no'] . '</td>
                        <td>' . date('d-m-Y', strtotime($row['invoice_date'])) . '</td>
                        <td>' . $row['production_no'] . '</td>
                    </tr>';
            }
            echo '</tbody></table>';
        }

        $complainLog = DB::table('complain_item_details')
            ->select('topland.product_master.product_name', 'complain.complain_no', 'complain_item_details.complain_id', 'complain.created_at', 'complain_item_details.complain', 'complain_item_details.solution', 'complain_item_details.solution_by')
            ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'complain_item_details.product_id')
            ->leftjoin('complain', 'complain.complain_id', '=', 'complain_item_details.complain_id')
            ->where('complain_item_details.product_id', '=', $product_id)
            ->where('serial_no', '=', $sr_no)
            ->where('cid_id', '!=', $current_complain_id)
            ->get()
            ->toArray();
        $complainLog = json_decode(json_encode($complainLog), true);
        if (!empty($complainLog)) {
            echo $table = '
<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                    <thead>
                    <tr>
                        <th class="text-center" colspan="6">COMPLAIN HISTORY</th>
                    </tr><tr>
                        <th>C. No</th>
                        <th>C. Date</th>
                        <th>Product Name</th>
                        <th>Problem</th>
                        <th>Solution</th>
                        <th>Solution By</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($complainLog as $row) {
                echo '<tr>
                        <td><a target="_blank" href="' . url('/complain-pdf') . '/' . $row['complain_id'] . '">' . $row['complain_no'] . '</a></td>
                        <td>' . date('d-m-Y h:i:s', strtotime($row['created_at'])) . '</td>
                        <td>' . $row['product_name'] . '</td>
                        <td>' . $row['complain'] . '</td>
                        <td>' . $row['solution'] . '</td>
                        <td>' . $row['solution_by'] . '</td>
                    </tr>';
            }
            echo '</tbody></table>';
        }

    }

    public function getClientInfo()
    {
        $sr_no = $_POST['sr_no'];
        $production_no = $_POST['production_no'];
        $current_complain_id = $_POST['current_complain_id'];
        $product_id = $_POST['product_id'];

        $productHistory = DB::table('topland.invoice_serial_info')
            ->select('topland.client_master.c_type', 'topland.client_master.client_id', 'topland.client_master.client_name', 'topland.invoice_serial_info.invoice_no', 'topland.invoice_serial_info.invoice_date', 'topland.invoice_serial_info.production_no')
            ->leftjoin('topland.client_master', 'topland.client_master.client_id', '=', 'topland.invoice_serial_info.party_id')
            ->where('topland.invoice_serial_info.product_id', '=', $product_id)
            ->where('topland.invoice_serial_info.serial_no', '=', $sr_no)
            ->where('topland.invoice_serial_info.production_no', '=', $production_no)
            ->first();

        echo json_encode($productHistory);
    }

    public function getFollowUpLastDetail()
    {
        $complain_id = $_POST['complain_id'];
        $complain_details = Complain::join('topland.user_master', 'user_id', 'assign_id')->where('complain_id', $complain_id)->get();
        $client_name = $complain_details[0]->client_name;
        $assign_name = $complain_details[0]->user_fname . ' ' . $complain_details[0]->user_lname;
        return json_encode(array('client_name' => $client_name, 'assign_name' => $assign_name));
    }

    public function resolvedSave(Request $request)
    {
        $complain_id = $request->post('complain_id');
        $resolve_date = $request->input('resolve_date');
        $complainDetails = DB::table('complain')
            ->select('*')
            ->where('complain_id', '=', $complain_id)
            ->get()
            ->toArray();
        $complainDetails = json_decode(json_encode($complainDetails), true);
        if ($complainDetails[0]['complain_type'] == 'Product Complain') {

            $i = 0;
            $s = 0;
            foreach ($request->post('cid') as $row) {
                DB::table('complain_item_details')
                    ->where('cid_id', $row)
                    ->update(['complain_status' => $request->post('complain_status')[$i], 'solution' => $request->post('solution')[$i], 'solution_by' => $request->post('solution_by')[$i]]);
                if (empty($request->post('solution')[$i])) {
                    $s++;
                }
                $i++;
            }

            if ($s == 0) {
                $status = 'Resolved';
                $updateData = array('complain_status' => $status, 'resolve_date' => $resolve_date);
            } else {
                $status = 'Pending';
                $updateData = array('complain_status' => $status);
            }
            DB::table('complain')->where('complain_id', $request->post('complain_id'))->update($updateData);
        } else {
            $complain_status = (!empty($request->post('solution'))) ? 'Resolved' : 'Pending';
            $solution = $request->post('solution');
            $solution_by = $request->post('solution_by');
            if ($complain_status == 'Resolved') {
                $updateData = array('complain_status' => $complain_status, 'solution' => $solution, 'solution_by' => $solution_by, 'resolve_date' => $resolve_date);
            } else {
                $updateData = array('complain_status' => $complain_status, 'solution' => $solution, 'solution_by' => $solution_by);
            }
            DB::table('complain')->where('complain_id', $complain_id)->update($updateData);
        }
        return redirect('complain-detail/');
    }

    public function getCityDetails(Request $request)
    {
        $city_id = $request->input('city_id');
        $cityname = Citys::with('getDistrict.getState')->where('city_id', '=', $city_id)->first();

        return json_encode(array('city_name' => $cityname->city_name, 'district_id' => $cityname->getDistrict->district_name, 'state' => $cityname->getDistrict->getState->state_name));
    }

    public function getComplainData()
    {
        $getComplain = DB::table('topland.replacement_complain')
            ->select('complain_id', 'client_id', 'client_name', 'address', 'city_id', 'district_name', 'state_name', 'mobile', 'medium', 'created_at', 'updated_at', 'created_id', 'updated_id')
            ->get();
        foreach ($getComplain as $key => $value) {
            $value->complain_id = '';
        }
    }

    public function ComplainReport($complain_id)
    {
        $complainDetail = DB::table('complain')
            ->where('complain_id', $complain_id)
            ->get();
        $billtyDetail = DB::table('billty')
            ->where('complain_id', $complainDetail[0]->complain_id)
            ->get();
        $billty_id = isset($billtyDetail[0]->billty_id) ? $billtyDetail[0]->billty_id : 0;
        $challanDetail = DB::table('challan')
            ->where('.billty_id', $billty_id)
            ->get();
        $challan_id = isset($challanDetail[0]->challan_id) ? $challanDetail[0]->challan_id : 0;

        $testing = DB::table('challan_testing_master')
            ->where('challan_id', $challan_id)
            ->get();

        $inspection = DB::table('inspection_report')
            ->where('challan_id', $challan_id)
            ->get();

        $invoiceDetail = DB::table('invoice')
            ->leftJoin('challan', 'challan.challan_id', '=', 'invoice.challan_id')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->where('invoice.challan_id', $challan_id)
            ->get();

        $credit_note = DB::table('credit_note')
            ->where('challan_id', $challan_id)
            ->get();

        $destroy_detail = DB::table('destroy')
            ->where('challan_id', $challan_id)
            ->get();

        $expense = DB::table('replacement_expense')
            ->where('complain_id', $complain_id)
            ->get();

        $ad_replacement = DB::table('advance_replacement_out')
            ->where('complain_id', $complain_id)
            ->get();

        $delievryChallan = DB::table('delivery_challan_out')
            ->where('challan_id', $challan_id)
            ->get();

        if (!empty($complainDetail)) {
            $complain = Helper::complainDetail($complain_id);
            if (!empty($billtyDetail[0]->complain_id)) {
                $billty = Helper::billtyPDF($billtyDetail[0]->billty_id);
                if (!empty($challanDetail[0]->billty_id)) {
                    if (!empty($challanDetail)) {
                        foreach ($challanDetail as $item) {
                            $challan = Helper::challanPDF($item->challan_id);
                        }
                    }
                    if (!empty($testing[0]->challan_id)) {
                        $testing = Helper::engineTestingReport($testing[0]->challan_id);
                    }
                    if (!empty($inspection[0]->challan_id)) {
                        $inspection = Helper::productInspectionReport($inspection[0]->challan_id);
                    }
                    if (!empty($invoiceDetail[0]->challan_id)) {
                        if ($invoiceDetail[0]->state == 'GUJARAT' || $invoiceDetail[0]->state = 'SAURASHTRA') {
                            if (!empty($invoiceDetail)) {
                                foreach ($invoiceDetail as $invo) {
                                    $inv = Helper::CGSTReport($invo->invoice_id);
                                }
                            } else {
                                foreach ($invoiceDetail as $invoice) {
                                    $inv = Helper::IGSTReport($invoice->invoice_id);
                                }
                            }
                        }
                    }
                    if (!empty($credit_note[0]->challan_id)) {
                        foreach ($credit_note as $credit) {
                            $credit_note = Helper::creditNoteReport($credit->credit_note_id);
                        }
                    }
                    if (!empty($destroy_detail[0]->challan_id)) {
                        foreach ($destroy_detail as $destroy) {
                            $destroy = Helper::destroyChallanReport($destroy->destroy_id);
                        }
                    }
                    if (!empty($delievryChallan[0]->challan_id)) {
                        foreach ($delievryChallan as $de_challan) {
                            $delivery = Helper::deliveryChallanOutReport($de_challan->delivery_challan_out_id);
                        }
                    }
                }
            }
            if (!empty($expense[0]->complain_id)) {
                foreach ($expense as $service) {
                    $exp_service = Helper::serviceExpenseReport($service->expense_id);
                }
            }
            if (!empty($ad_replacement[0]->complain_id)) {
                foreach ($ad_replacement as $replacement) {
                    $advanceRep = Helper::advanceReplacementOutPdf($replacement->replacement_out_id);
                }
            }
            Fpdf::Output();
        }
    }

    public function getOldData()
    {
        $searchTerm = request()->input('searchTerm');
        $products = DB::table('replacement_old_data')
            ->select(DB::raw('id as id'), DB::raw("serial_no as text"))
            ->whereRaw("(serial_no like '%$searchTerm%')")
            ->orderBy('serial_no', 'ASC')->limit(20)->get()->toArray();
        return response()->json($products);
    }

    public function getFAQComplain(Request $request)
    {
        $category_id = $request->input('category_id');
//        ->where('city_id', '=', $city_id)
        $cityname = Citys::with('getDistrict.getState')->first();

        return json_encode(array('city_name' => $cityname->city_name, 'district_id' => $cityname->getDistrict->district_name, 'state' => $cityname->getDistrict->getState->state_name));
    }

    public function saveComplainResolvedDate()
    {

    }
}

