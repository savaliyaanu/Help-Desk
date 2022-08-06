<?php

namespace App\Http\Controllers;

use App\Challan;
use App\ChallanProduct;
use App\ChallanShortageItem;
use App\ShortageItemMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChallanShortageItemController extends Controller
{

private $pageType;

public function __construct()
{

    $this->pageType = 'Shortage Item';
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
public function create(Request $request, $challan_product_id)
{
    $category_id = ChallanProduct::select('category_id', 'challan_id')->where('challan_product_id', $challan_product_id)
        ->first();

    $shortageList = DB::table('shortage_item_master')
        ->where('category_id', '=', $category_id->category_id)
        ->get();
    $shortage_item = ChallanShortageItem::where('challan_product_id', $challan_product_id)->get();

    $shortageListTable = DB::table('challan_shortage_item')
        ->select('shortage_item_master.shortage_name', 'challan_shortage_item.shortage_qty', 'challan_shortage_item.challan_shortage_item_id')
        ->leftJoin('shortage_item_master', 'shortage_item_master.shortage_item_master_id', '=', 'challan_shortage_item.shortage_item_master_id')
        ->where('challan_product_id', $challan_product_id)->get();
    return view('challan.shortage_item')->with(compact('shortageList', 'shortageListTable', 'category_id', 'shortage_item', 'challan_product_id'))->with('action', 'INSERT')->with('pageType', $this->pageType)->with('CURRENT_PAGE', 'ACCESSORIES');
}

/**
 * Store a newly created resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
    $challan_product_id = $request->input('challan_product_id');
    $challan_id = ChallanProduct::find($challan_product_id);
//        ChallanShortageItem::where('challan_product_id', $challan_product_id)->delete();
//        if (!empty($request->input('shortage_item_master_id'))) {
//            foreach ($request->input('shortage_item_master_id') as $row) {
    $shortage_item = new ChallanShortageItem();
    $shortage_item->shortage_item_master_id = $request->input('shortage_item_master_id');
    $shortage_item->shortage_qty = $request->input('shortage_qty');
    $shortage_item->challan_id = $challan_id->challan_id;
    $shortage_item->challan_product_id = $challan_product_id;
    $shortage_item->created_id = Auth::user()->user_id;
    $shortage_item->branch_id = Auth::user()->branch_id;
    $shortage_item->save();
//            }
//        }
    return redirect('challan-shortage-item/' . $challan_product_id);
}

/**
 * Display the specified resource.
 *
 * @param \App\ChallanAccessories $challanAccessories
 * @return \Illuminate\Http\Response
 */
public function show()
{
    //
}

/**
 * Show the form for editing the specified resource.
 *
 * @param \App\ChallanAccessories $challanAccessories
 * @return \Illuminate\Http\Response
 */
public function edit($id, Request $request)
{
    $shortage_item = ChallanShortageItem::where('challan_shortage_item_id', $id)->first();
    $category_id = ChallanProduct::select('category_id', 'challan_id')->where('challan_product_id', $shortage_item->challan_product_id)
        ->first();
    $challan_product_id = $shortage_item->challan_product_id;
    $shortageList = DB::table('shortage_item_master')
        ->where('category_id', '=', $category_id->category_id)
        ->get();
    $shortageListTable = DB::table('challan_shortage_item')
        ->select('shortage_item_master.shortage_name', 'challan_shortage_item.shortage_qty', 'challan_shortage_item.challan_shortage_item_id')
        ->leftJoin('shortage_item_master', 'shortage_item_master.shortage_item_master_id', '=', 'challan_shortage_item.shortage_item_master_id')
        ->where('challan_product_id', $challan_product_id)->get();
//        echo "<pre>";
//        print_r($shortage_item->challan_product_id);exit;
    return view('challan.shortage_item')->with(compact('shortage_item', 'shortageListTable', 'category_id', 'shortageList', 'challan_product_id'))->with('action', 'UPDATE')->with('pageType', $this->pageType)->with('CURRENT_PAGE', 'ACCESSORIES');
}

/**
 * Update the specified resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @param \App\ChallanAccessories $challanAccessories
 * @param $challanAccessories
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    $challan_product_id = $request->input('challan_product_id');
    $shortage_item = ChallanShortageItem::find($id);
    $shortage_item->shortage_item_master_id = $request->input('shortage_item_master_id');
    $shortage_item->shortage_qty = $request->input('shortage_qty');
    $shortage_item->created_id = Auth::user()->user_id;
    $shortage_item->branch_id = Auth::user()->branch_id;
    $shortage_item->save();
    return redirect('challan-shortage-item/' . $challan_product_id);
}

/**
 * Remove the specified resource from storage.
 *
 * @param \App\ChallanAccessories $challanAccessories
 * @param $challanAccessories
 * @return \Illuminate\Http\Response
 */
public function destroy($id, Request $request)
{
    $challan_product_id = ChallanShortageItem::where('challan_shortage_item_id', '=', $id)->first();
    ChallanShortageItem::destroy($id);
    return redirect('challan-shortage-item/' . $challan_product_id->challan_product_id);
}
}
