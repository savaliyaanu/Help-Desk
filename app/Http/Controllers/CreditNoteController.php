<?php

namespace App\Http\Controllers;

use App\Brands;
use App\Challan;
use App\ChallanOptional;
use App\ChallanProduct;
use App\CreditNote;
use App\CreditNoteItem;
use App\FinancialYear;
use App\Helpers\Helper;
use App\Products;
use Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @property
 */
class CreditNoteController extends Controller
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
        $creditIndex = DB::table('credit_note')
            ->select('complain.complain_no', 'complain.client_name', 'challan.*',
                DB::raw("(select SUM(credit_note_item.amount) from credit_note_item  WHERE credit_note_item.credit_note_id = credit_note.credit_note_id) as amount"), 'credit_note.*',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = credit_note.financial_id) as fyear"))
            ->leftJoin('challan', 'challan.challan_id', '=', 'credit_note.challan_id')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->where('credit_note.branch_id', '=', Auth::user()->branch_id)
            ->orderByDesc('credit_note.credit_note_id')
            ->get();
        return view('creditnote.index')->with(compact('creditIndex'));
//        return view('creditnote.index')->with('AJAX_PATH', 'get-credit-note');
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'credit_note_view';

        /** Table's primary key */
        $primaryKey = 'credit_note_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'complain_no', 'dt' => 0),
            array('db' => 'date', 'dt' => 1),
            array('db' => 'client_name', 'dt' => 2),
            array('db' => 'amount', 'dt' => 3),
            array('db' => 'print', 'dt' => 4),
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
            ->select('complain.complain_no', 'challan.challan_id','complain.client_id','complain.client_name',
                DB::raw("(select CONCAT(RIGHT (YEAR(date_from), 2),'-',RIGHT (YEAR(date_to), 2))from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"),
            'challan.branch_id')
            ->leftjoin('billty', 'billty.billty_id', 'challan.billty_id')
            ->leftjoin('complain', 'complain.complain_id', 'billty.complain_id')
//            ->whereNOTIn('challan_id', function ($query) {
//                $query->select('challan_id')->from('credit_note');
//            })
            ->where('challan.branch_id', '=', Auth::user()->branch_id)
            ->get();
//        echo "<pre>";
//        print_r($challanDetail);exit();

        return view('creditnote.create')->with('action', 'INSERT')->with('pageType', $this->pageType)->with('challanDetail', $challanDetail)->with('CURRENT_PAGE', 'CREDIT NOTE');
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
        $credit_note_no = DB::table('helpdesk.credit_note')
            ->select('credit_note_no')
            ->where('branch_id', '=', Auth::user()->branch_id)
            ->where('financial_id', '=', $financialID)
            ->orderBy('credit_note_no', 'desc')
            ->get()
            ->take(1)
            ->toArray();
        $credit_note_no = json_decode(json_encode($credit_note_no), true);
        $credit_note_no = (!empty($credit_note_no[0]['credit_note_no'])) ? $credit_note_no[0]['credit_note_no'] + 1 : 1;


        $credit_note = new CreditNote();
        $credit_note->financial_id = $financialYear->financial_id;
        $credit_note->challan_id = $request->input('challan_id');
        $credit_note->client_id = $request->input('client_id');
        $credit_note->client_name = $request->input('client_name');
        $credit_note->credit_note_no = $credit_note_no;
        $credit_note->remark = $request->input('remark');
        $credit_note->created_id = Auth::user()->user_id;
        $credit_note->branch_id = Auth::user()->branch_id;
        $credit_note->created_at = date('Y-m-d H:i:s');
        $credit_note->save();
        $request->session()->put('id', $credit_note->credit_note_id);
        $request->session()->flash('create-status', 'Credit Note Create Successful..');
        return redirect('credit-note-items/' . $credit_note->credit_note_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\CreditNote $creditNote
     * @return \Illuminate\Http\Response
     */
    public function show(CreditNote $creditNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\CreditNote $creditNote
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $creditDetail = CreditNote::find($id);

        $challanDetail = DB::table('helpdesk.challan')
            ->select('complain.complain_no', 'challan.challan_id','complain.client_id','complain.client_name')
            ->leftjoin('billty', 'billty.billty_id', 'challan.billty_id')
            ->leftjoin('complain', 'complain.complain_id', 'billty.complain_id')
            ->where('challan.branch_id', '=', Auth::user()->branch_id)
            ->get();
        $request->session()->put('credit_note_id', $id);
        return view('creditnote.create')->with('action', 'UPDATE')->with('pageType', $this->pageType)->with('challanDetail', $challanDetail)->with('creditDetail', $creditDetail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\CreditNote $creditNote
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

        $credit_note = CreditNote::find($id);
        $credit_note->remark = $request->input('remark');
        $credit_note->client_id = $request->input('client_id');
        $credit_note->client_name = $request->input('client_name');
        $credit_note->updated_id = Auth::user()->user_id;
        $credit_note->created_at = date('Y-m-d H:i:s');
        $credit_note->save();
        $request->session()->put('credit_note_id', $credit_note->credit_note_id);
        $request->session()->flash('update-status', 'Credit Note Successful Update...');
        return redirect('credit-note-items/' . $credit_note->credit_note_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CreditNote $creditNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $creditNoteID = CreditNoteItem::where('credit_note_id', '=', $id)->get();
        foreach ($creditNoteID as $row) {
            $type = $row->type;
            if ($type == 'product') {
                $challanProduct = ChallanProduct::find($row->challan_product_id);
                $challanProduct->is_used = 'N';
                $challanProduct->save();
            } else {
                $challanOptional = ChallanOptional::find($row->challan_product_id);
                $challanOptional->is_used = 'N';
                $challanOptional->save();
            }
            CreditNoteItem::destroy($row->credit_note_item_id);
        }
        CreditNote::destroy($id);
        $request->session()->flash('delete-status', 'Credit Note Successful Deleted.....!');
        return redirect('credit-note');
    }

    public function creditNoteFpdf($credit_note_id, Request $request)
    {
        $creditNote = Helper::creditNoteReport($credit_note_id);
        Fpdf::Output();
        echo $creditNote;
    }

}
