<?php

namespace App\Http\Controllers;

use App\Challan;
use App\ChangeSpare;
use App\ChallanProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChangeSpareController extends Controller
{
    private $pageType;

    public function __construct()
    {

        $this->pageType = 'ChangeSpare';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($challan_id)
    {
        $spare = DB::table('topland.product_master')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();
        $unitMaster = DB::table('unit_master')->get();
        $challanItem = ChallanProduct::with('getChangeSpareInfo.getProduct')->with('getProduct')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('challan_id', $challan_id)
            ->get();
        return view('challan.change_spare')->with('pageType', $this->pageType)->with('action', 'INSERT')->with(compact('spare', 'unitMaster', 'challan_id', 'challanItem'));
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
        $challan_item_ids = $request->input('challan_item_ids');
        $product_id = $request->input('product_id');
        $item_id = $request->input('item_ids');
        $id = isset($item_id) ? $item_id : $challan_item_ids;
        $challan_id = DB::table('challan_item_master')->where('challan_product_id','=',$id)->first();
        $challan_product_ids = $request->input('challan_product_ids');
        if ($challan_product_ids) {
            $charge = ChallanProduct::find($challan_product_ids);
            $charge->product_charge = $request->input('product_charge');
            $charge->save();
            return redirect('change-spare-create/'.$charge->challan_id);
        }

        $changeSpare = new ChangeSpare();
        $changeSpare->challan_product_id = isset($item_id) ? $item_id : $challan_item_ids;
        $changeSpare->product_id = $product_id;
        $changeSpare->unit_name = $request->input('unit_name');
        $changeSpare->missing_spare = $request->input('missing_spare');
        $changeSpare->challan_id = $challan_id->challan_id;
        $changeSpare->qty = $request->input('spareQty');
        $getData = DB::table('topland.new_single_price_list')->where('product_id',
            $request->input('product_id'))->where('price_date', '2017-07-01')->first();
        $changeSpare->rate = (isset($getData->loose_price)) ? $getData->loose_price : $request->input('price');
        $changeSpare->created_id = Auth::user()->user_id;
        $changeSpare->branch_id = Auth::user()->branch_id;
        $changeSpare->save();
        $request->session()->flash('create-status', 'Spare Successful Add...');
        return redirect('change-spare-create/'.$changeSpare->challan_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ChangeSpare $changeSpare
     * @return \Illuminate\Http\Response
     */
    public function show(ChangeSpare $changeSpare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ChangeSpare $changeSpare
     * @return \Illuminate\Http\Response
     */
    public function edit(ChangeSpare $changeSpare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ChangeSpare $changeSpare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChangeSpare $changeSpare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ChangeSpare $changeSpare
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $challan_id = ChangeSpare::where('challan_change_spare_id',$id)->first();
        ChangeSpare::destroy($id);
        $request->session()->flash('delete-status', 'Spare Successfully Deleted...');
        return redirect('change-spare-create/'.$challan_id->challan_id);
    }
}
