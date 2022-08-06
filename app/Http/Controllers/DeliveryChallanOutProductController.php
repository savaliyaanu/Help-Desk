<?php

namespace App\Http\Controllers;

use App\ChallanProduct;
use App\DeliveryChallanOutProduct;
use App\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeliveryChallanOutProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $delivery_challan_out_id)
    {

        $branch_id = Auth::user()->branch_id;
        $challan_product = DB::select("SELECT
	challan_product_id,topland.product_master.product_name,serial_no
FROM
	multiple_complain_to_supplier
LEFT JOIN delivery_challan_out ON delivery_challan_out.delivery_challan_out_id = multiple_complain_to_supplier.delivery_challan_out_id
LEFT JOIN challan_item_master ON challan_item_master.challan_id = multiple_complain_to_supplier.challan_id
LEFT JOIN topland.product_master ON topland.product_master.product_id = challan_item_master.product_id
WHERE delivery_challan_out.delivery_challan_out_id = $delivery_challan_out_id
  AND challan_item_master.is_delivery_challan = 'N'
  AND delivery_challan_out.branch_id = $branch_id");

//echo "<pre>";
//print_r($challan_product);exit;
        $list = DB::table('delivery_challan_out_product')
            ->select('topland.product_master.product_name', 'delivery_challan_out_product.delivery_challan_product_id', 'challan_item_master.serial_no', 'delivery_challan_out_product.qty')
            ->join('challan_item_master', 'challan_item_master.challan_product_id', '=', 'delivery_challan_out_product.challan_product_id')
            ->join('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('delivery_challan_out_id', '=', $delivery_challan_out_id)
            ->where('delivery_challan_out_product.branch_id', '=', Auth::user()->branch_id)
            ->get();
        return view('deliverychallan.product')->with('action', 'INSERT')->with(compact('list', 'delivery_challan_out_id', 'challan_product'));
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
        $delivery_challan_out_id = $request->session()->get('delivery_challan_out_id');

        $challan_product_id = ChallanProduct::find($request->input('challan_product_id'));
        $challan_product_id->is_delivery_challan = 'Y';
        $challan_product_id->save();
        $financialYear = FinancialYear::where('is_active', 'Y')->first();

        $delivery_challan_out = new DeliveryChallanOutProduct();
        $delivery_challan_out->delivery_challan_out_id = $delivery_challan_out_id;
        $delivery_challan_out->financial_id = $financialYear->financial_id;
        $delivery_challan_out->challan_product_id = $challan_product_id->challan_product_id;
        $delivery_challan_out->qty = $request->input('qty');
        $delivery_challan_out->created_id = Auth::user()->user_id;
        $delivery_challan_out->branch_id = Auth::user()->branch_id;
        $delivery_challan_out->save();
        $request->session()->flash('create-status', 'Product Successfully Added..');

        return redirect('delivery-challan-product/' . $delivery_challan_out_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\DeliveryChallanOutProduct $deliveryChallanOutProduct
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryChallanOutProduct $deliveryChallanOutProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\DeliveryChallanOutProduct $deliveryChallanOutProduct
     * @return \Illuminate\Http\Response
     */
    public function edit($delivery_challan_product_id, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\DeliveryChallanOutProduct $deliveryChallanOutProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $delivery_challan_product_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\DeliveryChallanOutProduct $deliveryChallanOutProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $delivery_challan_out_id = $request->session()->get('delivery_challan_out_id');
        DeliveryChallanOutProduct::destroy($id);
        $request->session()->flash('delete-status', 'Product Successfully Removed..');
        return redirect('delivery-challan-product/' . $delivery_challan_out_id);
    }

    public function getChallanProudct($delivery_challan_out_id, Request $request)
    {
        $challan_detail = DB::table('delivery_challan_out')->select('challan_id')->where('delivery_challan_out_id', '=', $delivery_challan_out_id)->first();
        $challan_id = explode(',', $challan_detail->challan_id);
//        DB::enableQueryLog();
        $challan_product = DB::table('delivery_challan_out')
            ->select('challan_item_master.challan_product_id', 'topland.product_master.product_name', 'challan_item_master.serial_no')
            ->join('challan_item_master', 'challan_item_master.challan_id', '=', 'delivery_challan_out.challan_id')
            ->join('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id');
        foreach ($challan_id as $row) {
            $query = $challan_product->where('challan_item_master.challan_id', '=', $row);
//            print_r($challan_product);
            $query->get();
//            exit();
        }
        $query->get();
//        dd(DB::getQueryLog());
        echo "<pre>";
        print_r($query);
        exit();
////            ->where('challan_item_master.challan_id', '=', $challan_id)
//        ->whereNOTIn('challan_product_id', function ($query) {
//            $query->select('challan_product_id')->from('delivery_challan_out_product');
//        })
//            ->get();
//        echo "<pre>";

    }
}
