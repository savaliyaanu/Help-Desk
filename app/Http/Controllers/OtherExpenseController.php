<?php

namespace App\Http\Controllers;

use App\FinancialYear;
use App\OtherExpense;
use App\ReplacementExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OtherExpenseController extends Controller
{
    private $pageType;

    public function __construct()
    {

        $this->pageType = 'Other Expense';
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
        $replacementItem = OtherExpense::where('expense_id', $expense_id)->get();
        return view('replacementexpense.otherexpense')->with('action', 'INSERT')->with('pageType', $this->pageType)->with('expense_id', $expense_id)->with('replacementItem', $replacementItem)->with('CURRENT_PAGE', 'OTHER-EXPENSE');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'detail.required' => 'Enter Detail',
            'amount.required' => 'Enter Amount.',
        ];
        $rules = [
            'detail' => 'required',
            'amount' => 'required',

        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $financialYear =FinancialYear::where('is_active','Y')->first();
        $other_expense = new OtherExpense();
        $other_expense->expense_id = $request->session()->get('expense_id');
        $other_expense->detail = $request->input('detail');
        $other_expense->financial_id = $financialYear->financial_id;
        $other_expense->amount = $request->input('amount');
        $other_expense->created_id = Auth::user()->user_id;
        $other_expense->created_at = date('Y-m-d H:i:s');
        $other_expense->save();
        $request->session()->flash('create-status', 'Other-Expense Successfully Created...');

        return redirect('other-expense/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OtherExpense $otherExpense
     * @return \Illuminate\Http\Response
     */
    public function show(OtherExpense $otherExpense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OtherExpense $otherExpense
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $other_expense = OtherExpense::Find($id);
        $expense_id = $request->session()->get('expense_id');
        $replacementItem = OtherExpense::where('expense_id', $expense_id)->get();
        return view('replacementexpense.otherexpense')->with('action', 'UPDATE')->with('pageType', $this->pageType)->with('expense_id', $expense_id)->with('replacementItem', $replacementItem)->with('other_expense', $other_expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\OtherExpense $otherExpense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'detail.required' => 'Enter Detail',
            'amount.required' => 'Enter Amount.',
        ];
        $rules = [
            'detail' => 'required',
            'amount' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $other_expense = OtherExpense::find($id);
        $other_expense->expense_id = $request->session()->get('expense_id');
        $other_expense->detail = $request->input('detail');
        $other_expense->amount = $request->input('amount');
        $other_expense->created_id = Auth::user()->user_id;
        $other_expense->created_at = date('Y-m-d H:i:s');
        $other_expense->save();
        $request->session()->flash('update-status', 'Other-Expense Successfully Updated...');
        return redirect('other-expense/create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OtherExpense $otherExpense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        OtherExpense::destroy($id);
        $request->session()->flash('delete-status', 'Other-Expense Successfully Deleted...');
        return redirect('other-expense/create');
    }
}
