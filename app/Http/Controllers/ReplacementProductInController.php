<?php

namespace App\Http\Controllers;

use App\FinancialYear;
use App\Image;
use App\ReplacementProductIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReplacementProductInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $replacement_in_id = $request->session()->get('replacement_in_id');

        $spare_product = DB::table('advance_replacement_in')
            ->select('company_name', 'order_id', 'financial_year')
            ->leftJoin('advance_replacement_out', 'advance_replacement_out.replacement_out_id', '=', 'advance_replacement_in.replacement_out_id')
            ->where('advance_replacement_in.replacement_in_id', '=', $replacement_in_id)->first();

        $financial_year = $spare_product->financial_year;
        $order_id = $spare_product->order_id;
        $company_name = $spare_product->company_name;
        $financial_year = DB::table('topland.financial_year')->where('financial_id', $financial_year)->first();
        $year_heading = $financial_year->year_heading;

        if ($company_name === 'PFMA') {
            $order_master = DB::table($year_heading . '.order_master')
                ->select($year_heading . '.order_master.product_id', $year_heading . '.order_master.order_quantity', $year_heading . '.order_master.item_name')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get();
        } elseif ($company_name === 'TEPL') {
            $order_master = DB::table($year_heading . '.engine_order_master')
                ->select($year_heading . '.engine_order_master.product_id', $year_heading . '.engine_order_master.item_name', $year_heading . '.engine_order_master.order_quantity')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get();
        } else {
            $order_master = DB::table($year_heading . '.tppl_order_master')
                ->select($year_heading . '.tppl_order_master.order_auto_id', $year_heading . '.tppl_order_master.item_name', $year_heading . '.tppl_order_master.order_quantity')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get();
        }
        $productList = DB::table('topland.product_master')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();
        $replacementProductList = DB::table('replacement_product_in')
            ->select('topland.product_master.product_name', 'replacement_product_in.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_product_in.product_id')
            ->where('replacement_in_id', $replacement_in_id)->get();
        return view('advancereplacement.product_in')->with('action', 'INSERT')->with(compact('productList', 'company_name', 'year_heading', 'order_master', 'order_id', 'financial_year', 'replacementProductList', 'replacement_in_id'));
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
        $replacement_in_id = $request->session()->get('replacement_in_id');

        $financialYear = FinancialYear::where('is_active', 'Y')->first();

        $spare_id = $request->input('spare_id');
        $product_id = $request->input('product_id');
        $replacement_out_id = DB::table('advance_replacement_in')->where('replacement_in_id', $replacement_in_id)->first();
        $replacementProduct = new ReplacementProductIn();
        $replacementProduct->replacement_in_id = $replacement_in_id;
        $replacementProduct->financial_id = $financialYear->financial_id;
        if (!empty($product_id)) {
            $replacementProduct->product_id = $product_id;
        } else {
            $replacementProduct->product_id = $spare_id;
        }
        DB::table('advance_replacement_out')->where('replacement_out_id', $replacement_out_id->replacement_out_id)->update(['status' => 'receive']);
        $replacementProduct->qty = $request->input('qty');
        $replacementProduct->created_id = Auth::user()->user_id;
        $replacementProduct->branch_id = Auth::user()->branch_id;
        $replacementProduct->save();
        $request->session()->flash('create-status', 'Product Successfully Inward..');
        return redirect('replacement-product/');
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
    public function edit(Request $request, $id)
    {
        $replacement_in_id = $request->session()->get('replacement_in_id');

        $spare_product = DB::table('advance_replacement_in')
            ->select('company_name', 'order_id', 'financial_year')
            ->leftJoin('advance_replacement_out', 'advance_replacement_out.replacement_out_id', '=', 'advance_replacement_in.replacement_out_id')
            ->where('advance_replacement_in.replacement_in_id', '=', $replacement_in_id)->first();

        $financial_year = $spare_product->financial_year;
        $order_id = $spare_product->order_id;
        $company_name = $spare_product->company_name;
        $financial_year = DB::table('topland.financial_year')->where('financial_id', $financial_year)->first();
        $year_heading = $financial_year->year_heading;

        if ($company_name === 'PFMA') {
            $order_master = DB::table($year_heading . '.order_master')
                ->select($year_heading . '.order_master.product_id', $year_heading . '.order_master.order_quantity', $year_heading . '.order_master.item_name')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get();
        } elseif ($company_name === 'TEPL') {
            $order_master = DB::table($year_heading . '.engine_order_master')
                ->select($year_heading . '.engine_order_master.product_id', $year_heading . '.engine_order_master.item_name', $year_heading . '.engine_order_master.order_quantity')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get();
        } else {
            $order_master = DB::table($year_heading . '.tppl_order_master')
                ->select($year_heading . '.tppl_order_master.order_auto_id', $year_heading . '.tppl_order_master.item_name', $year_heading . '.tppl_order_master.order_quantity')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get();
        }

        $productList = DB::table('topland.product_master')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();
        $replacementProductList = DB::table('replacement_product_in')
            ->select('topland.product_master.product_name', 'replacement_product_in.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_product_in.product_id')
            ->where('replacement_in_id', $replacement_in_id)->get();
        $replacementProduct = ReplacementProductIn::find($id);
        return view('advancereplacement.product_in')->with('action', 'UPDATE')->with(compact('productList', 'financial_year', 'order_master', 'order_id', 'company_name', 'year_heading', 'replacementProductList', 'replacement_in_id', 'replacementProduct'));
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
        $replacement_in_id = $request->session()->get('replacement_in_id');

        $replacementProduct = ReplacementProductIn::find($id);
        $replacementProduct->replacement_in_id = $replacement_in_id;
        $replacementProduct->product_id = $request->input('product_id');
        $replacementProduct->qty = $request->input('qty');
        $replacementProduct->created_id = Auth::user()->user_id;
        $replacementProduct->branch_id = Auth::user()->branch_id;
        $replacementProduct->save();
        $request->session()->flash('update-status', 'Product Successfully Updated..');
        return redirect('replacement-product/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        ReplacementProductIn::destroy($id);
        $request->session()->flash('delete-status', 'Product Inward Successfully Deleted..');
        return redirect('replacement-product');
    }

    public function getItemQty()
    {
        $spare_id = \request()->input('spare_id');
    }
}
