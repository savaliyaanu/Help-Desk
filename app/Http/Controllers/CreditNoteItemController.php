<?php

namespace App\Http\Controllers;

use App\ChallanOptional;
use App\ChallanProduct;
use App\CreditNote;
use App\CreditNoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreditNoteItemController extends Controller
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
    public function index($creditNoteID, Request $request)
    {
        $request->session()->put('credit_note_id', $creditNoteID);
        $creditNoteDetails = CreditNote::where('credit_note_id', '=', $creditNoteID)->get();

        $challanDetails = ChallanProduct::with('getProduct')
            ->where('is_main', '=', 'Y')
            ->where('is_used', '=', 'N')
            ->where('challan_id', '=', $creditNoteDetails[0]['challan_id'])
            ->get();

        $spareDetail = ChallanOptional::with('getProduct')
            ->where('challan_optional.is_used', '=', 'N')
            ->where('challan_optional.optional_status', '=', 'Spare')
            ->where('challan_id', '=', $creditNoteDetails[0]['challan_id'])
            ->get();

        $creditItemList = DB::select("SELECT topland.product_master.product_name,credit_note_item.* FROM credit_note_item
LEFT JOIN topland.product_master ON topland.product_master.product_id = credit_note_item.product_id
WHERE credit_note_id = $creditNoteID");

        return view('creditnote.product')->with('action', 'INSERT')->with('pageType', $this->pageType)->with('challanDetails', $challanDetails)->with('spareDetail', $spareDetail)->with('creditItemList', $creditItemList)->with('creditNoteDetails', $creditNoteDetails);
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
        $creditNoteID = $request->session()->get('credit_note_id');
        $challan_product = $request->input('product_id');
        if ($challan_product) {
            $product_id = ChallanProduct::find($challan_product);
            $product_id->is_used = 'Y';
            $product_id->save();
            $complainItem = DB::table('complain_item_details')
                ->where('cid_id', $product_id->complain_product_id)->first();

            $creditItem = new CreditNoteItem();
            $creditItem->credit_note_id = $creditNoteID;
            $creditItem->product_id = $complainItem->product_id;
            $creditItem->challan_id = $product_id->challan_id;
            $creditItem->category_id = $complainItem->category_id;
            $creditItem->challan_product_id = $challan_product;
            $creditItem->amount = $request->input('amount');
            $creditItem->type = 'Product';
            $creditItem->created_id = Auth::user()->user_id;
            $creditItem->branch_id = Auth::user()->branch_id;
            $creditItem->save();
            $request->session()->flash('create-status', 'Product Successfully Add...');
        }

        $challan_optional = $request->input('challan_optional_id');
        if ($challan_optional) {
            $spareItem = ChallanOptional::find($challan_optional);
            $spareItem->is_used = 'Y';
            $spareItem->save();

            $creditItem = new CreditNoteItem();
            $creditItem->credit_note_id = $creditNoteID;
            $creditItem->product_id = $spareItem->product_id;
            $creditItem->category_id = $spareItem->category_id;
            $creditItem->challan_id = $spareItem->challan_id;
            $creditItem->challan_product_id = $challan_optional;
            $creditItem->amount = $request->input('amount');
            $creditItem->type = 'Spare';
            $creditItem->created_id = Auth::user()->user_id;
            $creditItem->branch_id = Auth::user()->branch_id;
            $creditItem->save();
            $request->session()->flash('create-status', 'Spare Successfully Add...');
        }
        return redirect('credit-note-items/' . $creditNoteID);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\CreditNoteItem $creditNoteItem
     * @return \Illuminate\Http\Response
     */
    public function show(CreditNoteItem $creditNoteItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\CreditNoteItem $creditNoteItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditNoteItem $creditNoteItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\CreditNoteItem $creditNoteItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreditNoteItem $creditNoteItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CreditNoteItem $creditNoteItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $creditNoteID = $request->session()->get('credit_note_id');
        $creditNoteItemId = CreditNoteItem::find($id);
        $type = $creditNoteItemId->type;
        if ($type == 'product') {
            $challanProduct = ChallanProduct::find($creditNoteItemId->challan_product_id);
            $challanProduct->is_used = 'N';
            $challanProduct->save();
            $request->session()->flash('delete-status', 'Product Successfully Deleted...');
        } else {
            $challanOptional = ChallanOptional::find($creditNoteItemId->challan_product_id);
            $challanOptional->is_used = 'N';
            $challanOptional->save();
            $request->session()->flash('delete-status', 'Spare Successfully Deleted...');
        }
        CreditNoteItem::destroy($id);
        return redirect('credit-note-items/' . $creditNoteID);
    }
}
