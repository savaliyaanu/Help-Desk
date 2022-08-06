<?php

namespace App\Http\Controllers;

use App\DeliveryChallanOutProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryProductInwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($delivery_challan_out_id)
    {
        $product_list = DB::table('delivery_challan_out_product')
            ->select('delivery_challan_out_product.*', 'topland.product_master.product_name')
            ->join('challan_item_master', 'challan_item_master.challan_product_id', '=', 'delivery_challan_out_product.challan_product_id')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id')
            ->where('delivery_challan_out_id', '=', $delivery_challan_out_id)
            ->where('is_inward', '=', 'N')
            ->get();
        $list = DB::table('delivery_challan_out_product')
            ->select('delivery_challan_out_product.*', 'topland.product_master.product_name')
            ->join('challan_item_master', 'challan_item_master.challan_product_id', '=', 'delivery_challan_out_product.challan_product_id')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id')
            ->where('delivery_challan_out_id', '=', $delivery_challan_out_id)->where('is_inward', '=', 'Y')
            ->get();
        return view('deliverychallan.product_inward')->with('action', 'INSERT')->with(compact('product_list', 'list', 'delivery_challan_out_id'));
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
        $delivery_challan_out_id = $request->input('delivery_challan_out_id');
//print_r($delivery_challan_out_id);exit();
//        if (!empty($request->input('product_id'))) {
//            foreach ($request->input('product_id') as $row) {
                $product = DeliveryChallanOutProduct::find($delivery_challan_out_id);
                $product->is_inward = 'Y';
//                $product->qty =$request->input('qty');
//                $product->serial_no =$request->input('serial_no');
                $product->inward_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('inward_date-'))));
                $product->save();
                $request->session()->flash('create-status', 'Product  Inward Successfully Added..');
//            }
//        }
        $delivery_status = DeliveryChallanOutProduct::where('delivery_challan_out_id', $delivery_challan_out_id)->where('is_inward', '=', 'N')->first();
        if (!empty($delivery_status)) {
            DB::table('delivery_challan_out')->where('delivery_challan_out_id', '=', $delivery_challan_out_id)->update(['status' => 'Pending']);
        } else {
            DB::table('delivery_challan_out')->where('delivery_challan_out_id', '=', $delivery_challan_out_id)->update(['status' => 'Inward']);
        }

        return redirect('delivery-product-inward/' . $delivery_challan_out_id);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $delivery_challan = DeliveryChallanOutProduct::first();
        $delete = DeliveryChallanOutProduct::find($id);
        foreach ($delete as $row) {
            if ($row == 'Y') {
                $product = DeliveryChallanOutProduct::find($delete->delivery_challan_product_id);
                $product->is_inward = 'N';
                $product->inward_date = null;
                DB::table('delivery_challan_out')->where('delivery_challan_out_id', '=', $delivery_challan->delivery_challan_out_id)->update(['status' => 'Pending']);
            } else {
                DB::table('delivery_challan_out')->where('delivery_challan_out_id', '=', $delivery_challan->delivery_challan_out_id)->update(['status' => 'Inward']);
            }
            $product->save();
        }
        $request->session()->flash('delete-status', 'Product  Inward Successfully Removed..');
        return redirect('delivery-product-inward/' . $delivery_challan->delivery_challan_out_id);
    }
}
