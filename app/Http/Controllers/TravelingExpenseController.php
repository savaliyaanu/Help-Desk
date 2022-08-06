<?php

namespace App\Http\Controllers;

use App\FinancialYear;
use App\ReplacementExpense;
use App\TravelingExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TravelingExpenseController extends Controller
{
    private $pageType;

    public function __construct()
    {

        $this->pageType = 'Traveling';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $expense_id = $request->session()->get('expense_id');
        $expenseDetail = TravelingExpense::where('expense_id', '=', $expense_id)->get();
        return view('replacementexpense.traveling')->with('action', 'INSERT')->with('pageType', $this->pageType)->with('expense_id', $expense_id)->with('expenseDetail', $expenseDetail)->with('CURRENT_PAGE', 'TRAVELING-EXPENSE');
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
            'travel_date.required' => 'Enter Date',
            'time_from.required' => 'Enter From Time.',
            'time_to.required' => 'Enter To Time',
            'traveling_detail.required' => 'Enter Detail',
//            'place.required' => 'Enter Place',
//            'hault.required' => 'Enter Hault',
            'journey.required' => 'Select Journey Reason',
            'amount.required' => 'Enter Amount',
        ];
        $rules = [
            'travel_date' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'traveling_detail' => 'required',
//            'place' => 'required',
//            'hault' => 'required',
            'journey' => 'required',
            'amount' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $financialYear =FinancialYear::where('is_active','Y')->first();
        $travelingExpense = new TravelingExpense();
        $travelingExpense->expense_id = $request->session()->get('expense_id');
        $travelingExpense->financial_id = $financialYear->financial_id;
        $travelingExpense->travel_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('travel_date'))));
        $travelingExpense->time_from = $request->input('time_from');
        $travelingExpense->time_to = $request->input('time_to');
        $travelingExpense->traveling_detail = $request->input('traveling_detail');
        $travelingExpense->place = $request->input('place');
        $travelingExpense->hault = $request->input('hault');
        $travelingExpense->journey = $request->input('journey');
        $travelingExpense->amount = $request->input('amount');
        $travelingExpense->created_id = Auth::user()->user_id;
        $travelingExpense->branch_id = Auth::user()->branch_id;
        $travelingExpense->created_at = date('Y-m-d H:i:s');
        $travelingExpense->save();
        $request->session()->flash('create-status', 'Traveling-Expense Successfully Created...');

        return redirect('traveling-expense/create');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\TravelingExpense $travelingExpense
     * @return \Illuminate\Http\Response
     */
    public function show(TravelingExpense $travelingExpense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\TravelingExpense $travelingExpense
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $travelingExpense = TravelingExpense::find($id);
        $expense_id = $request->session()->get('expense_id');
        $expenseDetail = TravelingExpense::where('expense_id', '=', $expense_id)->get();
        return view('replacementexpense.traveling')->with('action', 'UPDATE')->with('pageType', $this->pageType)->with('expense_id', $expense_id)->with('expenseDetail', $expenseDetail)->with('travelingExpense', $travelingExpense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\TravelingExpense $travelingExpense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'travel_date.required' => 'Enter Date',
            'time_from.required' => 'Enter From Time.',
            'time_to.required' => 'Enter To Time',
            'traveling_detail.required' => 'Enter Detail',
//            'place.required' => 'Enter Place',
//            'hault.required' => 'Enter Hault',
            'journey.required' => 'Select Journey Reason',
            'amount.required' => 'Enter Amount',
        ];
        $rules = [
            'travel_date' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'traveling_detail' => 'required',
//            'place' => 'required',
//            'hault' => 'required',
            'journey' => 'required',
            'amount' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $travelingExpense = TravelingExpense::find($id);
        $travelingExpense->expense_id = $request->session()->get('expense_id');
        $travelingExpense->travel_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('travel_date'))));
        $travelingExpense->time_from = $request->input('time_from');
        $travelingExpense->time_to = $request->input('time_to');
        $travelingExpense->traveling_detail = $request->input('traveling_detail');
        $travelingExpense->place = $request->input('place');
        $travelingExpense->hault = $request->input('hault');
        $travelingExpense->journey = $request->input('journey');
        $travelingExpense->amount = $request->input('amount');
        $travelingExpense->updated_id = Auth::user()->user_id;
        $travelingExpense->branch_id = Auth::user()->branch_id;
        $travelingExpense->created_at = date('Y-m-d H:i:s');
        $travelingExpense->save();
        $request->session()->flash('update-status', 'Traveling-Expense Successfully Updated...');
        return redirect('traveling-expense/create');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TravelingExpense $travelingExpense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        TravelingExpense::destroy($id);
        $request->session()->flash('delete-status', 'Traveling-Expense Successfully Deleted...');

        return redirect('traveling-expense/create');
    }
}
