<?php

namespace App\Http\Controllers;

use App\ChallanOptional;
use App\ChallanProduct;
use App\Destroy;
use App\DestroyItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\PreInc;

class DestroyItemController extends Controller
{
    private $pageType;

    public function __construct()
    {
        $this->pageType = 'Product';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $destroyID)
    {
        $request->session()->put('destroy_id', $destroyID);
        $destroyDetail = Destroy::where('destroy_id', '=', $destroyID)->first();

        $challanDetails = ChallanProduct::with('getProduct')
            ->where('challan_item_master.is_main', '=', 'Y')
            ->where('is_used', '=', 'N')
            ->leftJoin('complain_item_details','complain_item_details.cid_id','=','challan_item_master.complain_product_id')
            ->leftJoin('topland.product_master','topland.product_master.product_id','=','complain_item_details.product_id')
            ->where('challan_id', '=', $destroyDetail->challan_id)
            ->get();
        $spareDetail = ChallanOptional::with('getProduct')
            ->where('challan_optional.is_used', '=', 'N')
            ->where('challan_optional.optional_status', '=', 'Spare')
            ->where('challan_id', '=', $destroyDetail->challan_id)
            ->get();

        $destroyList = DB::select("SELECT topland.product_master.product_name,destroy_item.* FROM destroy_item
LEFT JOIN topland.product_master ON topland.product_master.product_id = destroy_item.product_id
WHERE destroy_id = $destroyID");
        return view('destroy.product')->with('action', 'INSERT')->with('pageType', $this->pageType)->with('challanDetails', $challanDetails)->with('spareDetail', $spareDetail)->with('destroyList', $destroyList);
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
        $destroyID = $request->session()->get('destroy_id');

        $challan_product_id = $request->input('product_id');
        if ($challan_product_id) {
            $product_id = ChallanProduct::find($challan_product_id);
            $product_id->is_used = 'Y';
            $product_id->save();
            $complainItem = DB::table('complain_item_details')
                ->where('cid_id',$product_id->complain_product_id)->first();
            $destroyItem = new DestroyItem();
            $destroyItem->destroy_id = $destroyID;
            $destroyItem->challan_product_id = $challan_product_id;
            $destroyItem->product_id = $complainItem->product_id;
            $destroyItem->category_id = $complainItem->category_id;
            $destroyItem->remark = $request->input('remark');
            $destroyItem->created_id = Auth::user()->user_id;
            $destroyItem->branch_id = Auth::user()->branch_id;
            $destroyItem->type = 'Product';
            $destroyItem->save();
            $request->session()->flash('create-status', 'Product Successfully Created...');
        }

        $challan_optional_id = $request->input('challan_optional_id');
        if ($challan_optional_id) {
            $spareItem = ChallanOptional::find($challan_optional_id);
            $spareItem->is_used = 'Y';
            $spareItem->save();

            $destroyItem = new DestroyItem();
            $destroyItem->destroy_id = $request->session()->get('destroy_id');
            $destroyItem->product_id = $spareItem->product_id;
            $destroyItem->category_id = $spareItem->category_id;
            $destroyItem->challan_product_id = $challan_optional_id;
            $destroyItem->remark = $request->input('remark');
            $destroyItem->created_id = Auth::user()->user_id;
            $destroyItem->branch_id = Auth::user()->branch_id;
            $destroyItem->type = 'Spare';
            $destroyItem->save();
            $request->session()->flash('create-status', 'Spare Successfully Created...');
        }
        return redirect('destroy-items/' . $destroyID);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\DestroyItem $destroyItem
     * @return \Illuminate\Http\Response
     */
    public function show(DestroyItem $destroyItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\DestroyItem $destroyItem
     * @return \Illuminate\Http\Response
     */
    public function edit(DestroyItem $destroyItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\DestroyItem $destroyItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DestroyItem $destroyItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\DestroyItem $destroyItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $destroyID = $request->session()->get('destroy_id');
        $destroyItem = DestroyItem::find($id);

        $type = $destroyItem->type;
        if ($type == 'Product') {
            $challanProduct = ChallanProduct::find($destroyItem->challan_product_id);
            $challanProduct->is_used = 'N';
            $challanProduct->save();
            $request->session()->flash('delete-status', 'Product Successfully Deleted...');
        } else {
            $challanOptional = ChallanOptional::find($destroyItem->challan_product_id);
            $challanOptional->is_used = 'N';
            $challanOptional->save();
            $request->session()->flash('delete-status', 'Spare Successfully Deleted...');
        }
        DestroyItem::destroy($id);
        return redirect('destroy-items/' . $destroyID);
    }
}
