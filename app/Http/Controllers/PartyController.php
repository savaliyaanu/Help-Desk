<?php

namespace App\Http\Controllers;

use App\FinancialYear;
use App\Party;
use App\ReplacementExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartyController extends Controller
{
    private $pageType;

    public function __construct()
    {

        $this->pageType = 'Party';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $expense_id = $request->session()->get('expense_id');
        $spare_detail = DB::table('topland.product_master')
            ->where('is_delete', '=', 'N')
            ->get();

        $spare_model_name = DB::table('topland.product_master')
            ->select('product_id','product_name','part_code')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();

        $party = DB::table('replacement_expense_item')
            ->select('topland.product_master.product_name', 'replacement_expense_item.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_expense_item.product_id')
            ->where('expense_id', '=', $expense_id)->get();
        return view('replacementexpense.party')->with('action', 'INSERT')->with('party', $party)->with('pageType', $this->pageType)->with('expense_id', $expense_id)->with('spare_detail', $spare_detail)->with('CURRENT_PAGE', 'PARTY')->with(compact('spare_model_name'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request ;
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $partyDetail = new Party();
        $partyDetail->expense_id = $request->session()->get('expense_id');
        $partyDetail->product_id = $request->input('product_id');
        $partyDetail->city_name = $request->input('city_name');
        $partyDetail->party_name = $request->input('party_name');
        $partyDetail->address = $request->input('address');
        $partyDetail->mobile_no = $request->input('mobile_no');
        $partyDetail->sr_no = $request->input('sr_no');
        $partyDetail->financial_id = $financialYear->financial_id;
        $partyDetail->qty = $request->input('qty');
        $partyDetail->created_id = Auth::user()->user_id;
        $partyDetail->branch_id = Auth::user()->branch_id;
        $partyDetail->created_at = date('Y-m-d H:i:s');
        $partyDetail->save();
        $request->session()->flash('create-status', 'Item Successfully Created...');
        return redirect('party/create');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Party $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $party)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Party $party
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $partyDetail = Party::find($id);
        $expense_id = $request->session()->get('expense_id');
        $spare_detail = DB::table('topland.product_master')
//            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();
        $party = DB::table('replacement_expense_item')
            ->select('topland.product_master.product_name', 'replacement_expense_item.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_expense_item.product_id')
            ->where('expense_id', '=', $expense_id)->get();
        return view('replacementexpense.party')->with('action', 'UPDATE')->with('pageType', $this->pageType)->with('expense_id', $expense_id)->with('spare_detail', $spare_detail)->with('partyDetail', $partyDetail)->with(compact('party'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Party $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $financialYear = FinancialYear::where('is_active', 'Y')->first();

        $partyDetail = Party::find($id);
        $partyDetail->financial_id = $financialYear->financial_id;
//        $partyDetail->expense_id = $request->session()->get('expense_id');
        $partyDetail->product_id = $request->input('product_id');
        $partyDetail->city_name = $request->input('city_name');
        $partyDetail->party_name = $request->input('party_name');
        $partyDetail->address = $request->input('address');
        $partyDetail->mobile_no = $request->input('mobile_no');
        $partyDetail->sr_no = $request->input('sr_no');
        $partyDetail->qty = $request->input('qty');
        $partyDetail->updated_id = Auth::user()->user_id;
        $partyDetail->created_at = date('Y-m-d H:i:s');
        $partyDetail->save();
        $request->session()->flash('update-status', 'Item Successfully Updated...');
        return redirect('party/create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Party $party
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        Party::destroy($id);
        $request->session()->flash('delete-status', 'Item Successfully Deleted...');
        return redirect('party/create');
    }
}
