<?php

namespace App\Http\Controllers;

use App\FinancialYear;
use App\Party;
use App\ReplacementExpenseProductIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReplacementExpenseImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $expense_id)
    {
        $productList = DB::table('topland.product_master')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();

        $inward_item = DB::table('replacement_expense_item')
            ->select('topland.product_master.product_name', 'replacement_expense_item.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_expense_item.product_id')
            ->where('expense_id', $expense_id)
            ->where('is_used_inward', '=', 'N')
            ->get();

        $expense_product_in = DB::table('replacement_expense_product_in')
            ->select('topland.product_master.product_name', 'replacement_expense_product_in.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_expense_product_in.spare_id')
            ->where('expense_id', $expense_id)->get();
        return view('expenseproduct.create')->with('action', 'INSERT')->with(compact('productList', 'inward_item', 'expense_product_in', 'expense_id'));
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
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $expense_id = $request->session()->get('expense_id');
        $expense_item_id = $request->input('expense_item_id');
        $product_id = DB::table('replacement_expense_item')->where('expense_item_id', $expense_item_id)->first();
        DB::table('replacement_expense_item')->where('expense_item_id', $expense_item_id)->update(['is_used_inward' => 'Y']);
        $spare_id = $request->input('spare_id');
        $replacement_in = new ReplacementExpenseProductIn();
        $replacement_in->expense_id = $expense_id;
        $replacement_in->category_id = 9;
        $replacement_in->financial_id = $financialYear->financial_id;
        if (!empty($spare_id)){
            $replacement_in->spare_id = $spare_id;
        }else{
            $replacement_in->spare_id = $product_id->product_id;
        }
        $replacement_in->expense_item_id = $expense_item_id;
        $replacement_in->qty = $request->input('qty');
        $replacement_in->created_id = Auth::user()->user_id;
        $replacement_in->branch_id = Auth::user()->branch_id;
        $replacement_in->save();
        $request->session()->flash('create-status', 'Product Inward Successfully Created...');
        return redirect('expense-product-in-image/' . $expense_id);
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
    public function edit($id, Request $request)
    {
        $expense_id = $request->session()->get('expense_id');
        $productList = DB::table('topland.product_master')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();
        $inward_item = DB::table('replacement_expense_item')
            ->select('topland.product_master.product_name', 'replacement_expense_item.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_expense_item.product_id')
            ->where('expense_id', $expense_id)
            ->where('is_used_inward', '=', 'N')
            ->get();
        $expense_product_in = DB::table('replacement_expense_product_in')
            ->select('topland.product_master.product_name', 'replacement_expense_product_in.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_expense_product_in.spare_id')
            ->where('expense_id', $expense_id)->get();
        $replacement_in = ReplacementExpenseProductIn::find($id);
        return view('expenseproduct.create')->with('action', 'UPDATE')->with(compact('productList', 'inward_item', 'expense_product_in', 'expense_id', 'replacement_in'));
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
        $expense_id = $request->session()->get('expense_id');
        $replacement_in = ReplacementExpenseProductIn::find($id);
        $replacement_in->expense_id = $expense_id;
        $replacement_in->spare_id = $request->input('spare_id');
        $replacement_in->qty = $request->input('qty');
        $replacement_in->updated_id = Auth::user()->user_id;
        $replacement_in->branch_id = Auth::user()->branch_id;
        $replacement_in->save();
        $request->session()->flash('update-status', 'Product Inward Successfully Updated...');
        return redirect('expense-product-in-image/' . $expense_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $expense_item = ReplacementExpenseProductIn::find($id);
        DB::table('replacement_expense_item')->where('expense_item_id', $expense_item->expense_item_id)->update(['is_used_inward' => 'N']);
        $expense_id = $request->session()->get('expense_id');
        ReplacementExpenseProductIn::destroy($id);
        $request->session()->flash('delete-status', 'Product Inward Successfully Deleted...');
        return redirect('expense-product-in-image/' . $expense_id);
    }

    public function getQty()
    {
        $expense_item_id = \request()->input('expense_item_id');
        $complainData = DB::table('replacement_expense_item')
            ->select('qty')
            ->where('expense_item_id', $expense_item_id)
            ->get();
        return json_encode($complainData[0]);
    }
}
