<?php

namespace App\Http\Controllers;

use App\Complain;
use App\FinancialYear;
use App\Helpers\Helper;
use App\OtherExpense;
use App\Party;
use App\ReplacementExpense;
use App\ReplacementExpenseProductIn;
use App\TravelingExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;
use Illuminate\Support\Facades\Validator;


class ReplacementExpenseController extends Controller
{
    private $pageType;

    public function __construct()
    {

        $this->pageType = 'Service Expense';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detail = DB::table('replacement_expense')
            ->select('topland.state_master.state_name', 'topland.mechanic_master.mechanic_name', 'replacement_expense.created_id', 'replacement_expense.created_at', 'replacement_expense.*', 'replacement_expense.status', 'replacement_expense.city_name', 'replacement_expense.party_name', 'complain.complain_no',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = replacement_expense.financial_id) as fyear"))
            ->join('topland.state_master', 'topland.state_master.state_id', '=', 'replacement_expense.state_id')
            ->join('topland.mechanic_master', 'topland.mechanic_master.mechanic_id', '=', 'replacement_expense.mechanic_id')
            ->join('complain', 'complain.complain_id', '=', 'replacement_expense.complain_id')
            ->where('replacement_expense.branch_id', '=', Auth::user()->branch_id)
            ->orderByDesc('replacement_expense.expense_id')
            ->get();
        return view('replacementexpense.index')->with('expense', $detail);
//        return view('replacementexpense.index')->with('AJAX_PATH', 'get-expense');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'replacement_expense_view';

        /** Table's primary key */
        $primaryKey = 'expense_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'complain_no', 'dt' => 0),
            array('db' => 'date', 'dt' => 1),
            array('db' => 'mechanic_name', 'dt' => 2),
            array('db' => 'state_name', 'dt' => 3),
            array('db' => 'city_name', 'dt' => 4),
            array('db' => 'party_name', 'dt' => 5),
            array('db' => 'status', 'dt' => 6),
            array('db' => 'print', 'dt' => 7),
            array('db' => 'callback_reason', 'dt' => 8),
            array('db' => 'service_expense_form', 'dt' => 9),
            array('db' => 'print_pdf', 'dt' => 10),
            array('db' => 'edit', 'dt' => 11),
            array('db' => 'delete', 'dt' => 12),
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
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $financialID = $financialYear->financial_id;
        $this->authorize('create', ReplacementExpense::class);
        $mechanicList = DB::table('topland.mechanic_master')->get();
        $stateList = DB::table('topland.state_master')->get();
        $complainList = DB::table('complain')
            ->select(DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"),
                'complain.*')
            ->whereNOTIn('complain_id', function ($query) {
                $query->select('complain_id')->from('replacement_expense');
            })
            ->where('complain.branch_id', '=', Auth::user()->branch_id)->get();
        return view('replacementexpense.create')->with('action', 'INSERT')->with('pageType', $this->pageType)->with(compact('mechanicList', 'stateList', 'complainList'))->with('CURRENT_PAGE', 'SERVICE-EXPENSE');
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
        $financialYearID = $financialYear->financial_id;
        $expense_no = DB::table('replacement_expense')
            ->select('expense_no')
            ->where('branch_id', '=', Auth::user()->branch_id)
            ->where('financial_id', '=', $financialYearID)->max('expense_no');

        $expense = new ReplacementExpense();
        $expense->complain_id = $request->input('complain_id');
        $expense->expense_no = $expense_no + 1;
        $expense->financial_id = $financialYearID;
        $expense->expense_id = $request->input('expense_id');
        $expense->city_name = $request->input('city_name');
        $expense->state_id = $request->input('state_id');
        $expense->mechanic_id = $request->input('mechanic_id');
        $expense->mechanic_id2 = $request->input('mechanic_id2');
        $expense->traveling_to = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('traveling_to'))));
        $expense->traveling_from = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('traveling_from'))));
        $expense->ta_da_amount = $request->input('ta_da_amount');
        $expense->advance_amount = $request->input('advance_amount');
        $expense->traveling_reason = $request->input('traveling_reason');
        $expense->traveling_days = $request->input('traveling_days');
        $expense->amount_taken_from_dealer = $request->input('amount_taken_from_dealer');
        $expense->expense_amount = $request->input('expense_amount');
        $expense->party_name = $request->input('party_name');
        $expense->company_id = $request->input('company_id');
        $expense->created_id = Auth::user()->user_id;
        $expense->branch_id = Auth::user()->branch_id;
        $expense->created_at = date('Y-m-d H:i:s');
        $expense->save();
        $request->session()->put('expense_id', $expense->expense_id);
        $request->session()->flash('create-status', 'Expense Successfully Created...');
        return redirect('party/create');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ReplacementExpense $replacementExpense
     * @return \Illuminate\Http\Response
     */
    public function show(ReplacementExpense $replacementExpense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ReplacementExpense $replacementExpense
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $expense = ReplacementExpense::find($id);
        $request->session()->put('expense_id', $expense->expense_id);
        $mechanicList = DB::table('topland.mechanic_master')->get();
        $stateList = DB::table('topland.state_master')->get();
        $expenseList = DB::table('replacement_expense')->where('expense_id', '=', $expense->expense_id)->get();
        $complainList = Complain::get();
        return view('replacementexpense.create')->with('action', 'UPDATE')->with('pageType', $this->pageType)->with('expense', $expenseList[0])->with('mechanicList', $mechanicList)->with('stateList', $stateList)->with('complainList', $complainList);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ReplacementExpense $replacementExpense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $financialYear = FinancialYear::where('is_active', 'Y')->first();

        $expense = ReplacementExpense::find($id);
        $expense->financial_id = $financialYear->financial_id;
        $expense->complain_id = $request->input('complain_id');
        $expense->city_name = $request->input('city_name');
        $expense->state_id = $request->input('state_id');
        $expense->mechanic_id = $request->input('mechanic_id');
        $expense->mechanic_id2 = $request->input('mechanic_id2');
        $expense->traveling_to = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('traveling_to'))));
        $expense->traveling_from = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('traveling_from'))));
        $expense->ta_da_amount = $request->input('ta_da_amount');
        $expense->advance_amount = $request->input('advance_amount');
        $expense->traveling_reason = $request->input('traveling_reason');
        $expense->traveling_days = $request->input('traveling_days');
        $expense->amount_taken_from_dealer = $request->input('amount_taken_from_dealer');
        $expense->expense_amount = $request->input('expense_amount');
        $expense->party_name = $request->input('party_name');
        $expense->company_id = $request->input('company_id');
        $expense->updated_id = Auth::user()->user_id;
        $expense->branch_id = Auth::user()->branch_id;
        $expense->updated_at = date('Y-m-d H:i:s');
        $expense->save();
        $request->session()->flash('update-status', 'Expense Successfully Updated...');
        return redirect('party/create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ReplacementExpense $replacementExpense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        ReplacementExpense::destroy($id);
        ReplacementExpenseProductIn::where('expense_id', $id)->delete();
        TravelingExpense::where('expense_id', $id)->delete();
        OtherExpense::where('expense_id', $id)->delete();
        Party::where('expense_id', $id)->delete();
        $request->session()->flash('delete-status', 'Expense Successfully Deleted...');
        return redirect('service-expense');
    }

    public function serviceReport($expense_id, Request $request)
    {
        $request->session()->flash('delete-status', 'Traveling Data not Found...');
        $expense = Helper::serviceExpenseReport($expense_id);
        Fpdf::Output();
        echo $expense;
    }

    public function spareReport($expense_id)
    {
        $spare = Helper::spareExpenseReport($expense_id);
        Fpdf::Output();
        echo $spare;
    }

    public function getComplainData()
    {
        $complain_id = \request()->input('complain_id');
        $complainData = DB::table('complain')
            ->select('topland.category_master.category_name as traveling_reason', 'complain.client_name as party_name',
                'topland.city_master.city_name','topland.state_master.state_id')
            ->leftJoin('complain_item_details', 'complain_item_details.complain_id', '=', 'complain.complain_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'complain_item_details.category_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('complain.complain_id', $complain_id)
            ->first();
        return json_encode($complainData);
    }

    public function spareReportDetail($expense_id)
    {
        $expense = DB::table('replacement_expense')
            ->select('topland.mechanic_master.mechanic_name', 'replacement_expense.*', 'topland.state_master.state_name', DB::raw('ifnull((select topland.mechanic_master.mechanic_name from topland.mechanic_master WHERE topland.mechanic_master.mechanic_id = replacement_expense.mechanic_id2),"")
                as mechanic_id2'), 'company_master.company_name', 'replacement_expense.expense_no')
            ->leftJoin('topland.mechanic_master', 'topland.mechanic_master.mechanic_id', '=', 'replacement_expense.mechanic_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'replacement_expense.state_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'replacement_expense.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('replacement_expense.expense_id', '=', $expense_id)
            ->get();

        $complain_id = $expense[0]->complain_id;
        $complains = DB::table('complain')
            ->select('complain_medium_details.*', 'complain.medium_id', 'complain.complain_id', 'complain.complain_no', 'medium.medium_name', 'complain.complain_type', 'complain.mobile2',
                'complain.email_address', 'complain.medium_id', 'topland.user_master.user_fname', 'complain.created_at', 'complain.client_name', 'complain.branch_id',
                'complain.address', 'complain.district', 'complain.state', 'topland.city_master.city_name', 'topland.client_master.pincode', 'complain.mobile',
                DB::raw("CONCAT(topland.user_master.user_fname,' ',topland.user_master.user_lname) as assign_name"),
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->leftJoin('topland.client_master', 'topland.client_master.client_id', '=', 'complain.client_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('medium', 'medium.medium_id', '=', 'complain.medium_id')
            ->leftJoin('complain_medium_details', 'complain_medium_details.complain_id', '=', 'complain.complain_id')
            ->leftJoin('topland.user_master', 'topland.user_master.user_id', '=', 'complain.assign_id')
            ->where('complain.complain_id', '=', $complain_id)
            ->get();


        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

        if ($complains[0]->medium_id == 1) {
            $mediumData = 'Mobile No : ' . $complains[0]->mobile_no;
        }
        if ($complains[0]->medium_id == 2) {
            $mediumData = 'Voucher No : ' . $complains[0]->voucher_no;
        }
        if ($complains[0]->medium_id == 3) {
            $mediumData = 'WhatsApp No : ' . $complains[0]->whatsapp_no;
        }
        if ($complains[0]->medium_id == 4) {
            $mediumData = 'Email : ' . $complains[0]->email;
        }
        if ($complains[0]->medium_id == 5) {
            $mediumData = 'Vehicle No : ' . $complains[0]->vehicle_no;
        }
        if ($complains[0]->medium_id == 6) {
            $mediumData = 'Staff Name : ' . $complains[0]->staff_name;
        }

        Fpdf::Ln();
        Fpdf::SetWidths(array(95, 95));
        Fpdf::Cell(190, 5, 'Service Expense', 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Ln();
//        print_r($complains[0]->branch_id);exit();

        if ($complains[0]->branch_id == 1) {
            $complain_no = 'PF-TKT/' . $complains[0]->fyear . '/' . $complains[0]->complain_no;
        } elseif ($complains[0]->branch_id == 3) {
            $complain_no = 'TE-TKT/' . $complains[0]->fyear . '/' . $complains[0]->complain_no;
        } elseif ($complains[0]->branch_id == 4) {
            $complain_no = 'TP-TKT/' . $complains[0]->fyear . '/' . $complains[0]->complain_no;
        }
        $field1 = (trim($complains[0]->client_name) . "\n" . trim($complains[0]->address)) . "\n" . 'City : ' . $complains[0]->city_name . "\n"
            . 'District : ' . $complains[0]->district . "\n" . 'State :' . $complains[0]->state . "\n" . 'PinCode :' . $complains[0]->pincode . "\n"
            . 'Mobile No. :' . $complains[0]->mobile . '/' . $complains[0]->mobile2 . "\n" . 'Email :' . $complains[0]->email_address;
        $field2 = 'Complain No : ' . $complain_no . "\n" . 'Complain Date : ' . date('d/m/Y', strtotime($complains[0]->created_at)) . "\n"
            . 'Complain Type : ' . strtoupper($complains[0]->complain_type) . "\n" . strtoupper($mediumData) . "\n"
            . 'Assign Name : ' . strtoupper($complains[0]->assign_name);
        /** print address */
        Fpdf::Row(array(strtoupper($field1), strtoupper($field2)), array('L', 'L'), '', '', true, 4);

        $spareDetail = DB::table('replacement_expense_item')
            ->select('topland.product_master.product_name', 'replacement_expense_item.*')
            ->leftjoin('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_expense_item.product_id')
            ->where('replacement_expense_item.expense_id', '=', $expense_id)
            ->get();

        $complainProduct = DB::table('complain_item_details')
            ->select('topland.product_master.product_name', 'complain_item_details.*')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('complain_id', '=', $complain_id)->get();

        if (!empty($complainProduct)) {
            Fpdf::Ln();
            Fpdf::SetFont('Verdana-Bold', 'B', 9);
            Fpdf::Cell(190, 5, 'COMPLAIN PRODUCT DETAIL', 0, 1, 'C');
            Fpdf::SetFont('Verdana-Bold', 'B', 9);
            Fpdf::Ln();

            Fpdf::SetWidths(array(10, 63, 20, 20, 20, 21, 27, 10));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('No', 'Product Name', 'Serial No.', 'Warranty', 'Pro. No', 'Invoice No', 'Invoice Date', 'Qty'), array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            $temp = 1;
            foreach ($complainProduct as $item) {
                Fpdf::Row(array($temp++, strtoupper($item->product_name), strtoupper($item->serial_no), $item->warranty, $item->production_no, $item->invoice_no, $item->invoice_date, $item->qty), array('L', 'L', 'C', 'C', 'C', 'L', 'L', 'C'), '', array(), true);
            }
        }
        if (!empty($spareDetail)) {
            Fpdf::Ln();
            Fpdf::SetFont('Verdana-Bold', 'B', 9);
            Fpdf::Cell(190, 5, 'TRAVELING PRODUCT OUT', 0, 1, 'C');
            Fpdf::SetFont('Verdana-Bold', 'B', 9);
        }
        $i = 1;

        foreach ($spareDetail as $row) {
            if (empty($row->party_name)) {
                Fpdf::SetWidths(array(15, 110, 35, 30));
                Fpdf::Row(array('Sr.', 'Spare Product Name', 'Serial No', 'Qty'), array('C', 'L', 'C', 'C'), '', array(),
                    true);
                Fpdf::SetFont('Verdana', '', 9);

                Fpdf::Row(array($i, $row->product_name, $row->sr_no, $row->qty), array('C', 'L', 'C', 'C'), '', array(),
                    true);
                $i++;

            } else {
                Fpdf::Ln();
                Fpdf::SetFont('Verdana-Bold', 'B', 9);
                Fpdf::Cell(50, 4, 'Party Name : ', 1, 0, 'L');
                Fpdf::SetFont('Verdana', '', 9);
                Fpdf::Cell(100, 4, $row->party_name, 1, 0, 'L');
                Fpdf::Ln();
                Fpdf::SetFont('Verdana-Bold', 'B', 9);
                Fpdf::Cell(50, 4, 'City Name : ', 1, 0, 'L');
                Fpdf::SetFont('Verdana', '', 9);
                Fpdf::Cell(100, 4, $row->city_name, 1, 0, 'L');
                Fpdf::Ln();
                Fpdf::SetFont('Verdana-Bold', 'B', 9);
                Fpdf::Cell(50, 4, 'Address : ', 1, 0, 'L');
                Fpdf::SetFont('Verdana', '', 9);
                Fpdf::MultiCell(100, 5, $row->address, 1, 'J', 0, 4);
                Fpdf::Ln();
                Fpdf::SetFont('Verdana-Bold', 'B', 9);
                Fpdf::Cell(50, 4, 'Mobile : ', 1, 0, 'L');
                Fpdf::SetFont('Verdana', '', 9);
                Fpdf::Cell(100, 4, $row->mobile_no, 1, 0, 'L');
                Fpdf::Ln();
                Fpdf::SetFont('Verdana-Bold', 'B', 9);
                Fpdf::Cell(50, 4, 'Product Name : ', 1, 0, 'L');
                Fpdf::SetFont('Verdana', '', 9);
                Fpdf::Cell(100, 4, $row->product_name, 1, 0, 'L');
                Fpdf::Ln();
                Fpdf::SetFont('Verdana-Bold', 'B', 9);
                Fpdf::Cell(50, 4, 'Sr No : ', 1, 0, 'L');
                Fpdf::SetFont('Verdana', '', 9);
                Fpdf::Cell(100, 4, $row->sr_no, 1, 0, 'L');
                Fpdf::Ln();
                Fpdf::SetFont('Verdana-Bold', 'B', 9);
                Fpdf::Cell(50, 4, 'Qty : ', 1, 0, 'L');
                Fpdf::SetFont('Verdana', '', 9);
                Fpdf::Cell(100, 4, $row->qty, 1, 0, 'L');
                Fpdf::Ln();
            }
        }

        $spareDetail = DB::table('replacement_expense_product_in')
            ->select('topland.product_master.product_name', 'replacement_expense_product_in.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_expense_product_in.spare_id')
            ->where('replacement_expense_product_in.expense_id', '=', $expense_id)
            ->get();

        if (!empty($spareDetail[0]->expense_id)) {

            Fpdf::Ln();
            Fpdf::SetFont('Verdana-Bold', 'B', 9);
            Fpdf::Cell(190, 5, 'TRAVELING PRODUCT IN', 0, 1, 'C');
            Fpdf::SetWidths(array(15, 145, 30));
            Fpdf::Row(array('Sr.', 'Spare Inward Product', 'Qty'), array('C', 'L', 'C'), '', array(),
                true);
            Fpdf::SetFont('Verdana', '', 9);
            $i = 1;

            foreach ($spareDetail as $spare) {
                Fpdf::Row(array($i, $spare->product_name, $spare->qty), array('C', 'L', 'C'), '', array(),
                    true);
                $i++;
            }
        }
        Fpdf::Ln();
        if (!empty($expense[0]->reason_for_callback && $expense[0]->remark)) {
            Fpdf::SetFont('Verdana-Bold', 'B', 9);
            Fpdf::Cell(190, 5, 'REASON FOR CALLBACK', 0, 1, 'C');
            Fpdf::Ln();
            Fpdf::SetWidths(array(95, 95));
            Fpdf::Row(array('Reason', 'Remark'), array('L', 'L'), '', array(),
                true);
            Fpdf::SetFont('Verdana', '', 9);
            Fpdf::Row(array($expense[0]->reason_for_callback, $expense[0]->remark), array('L', 'L'), '', array(),
                true);
        }
        Fpdf::Output();
    }
}
