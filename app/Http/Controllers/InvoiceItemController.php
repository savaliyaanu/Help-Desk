<?php

namespace App\Http\Controllers;

use App\ChallanOptional;
use App\InvoiceItem;
use App\ChallanProduct;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceItemController extends Controller
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
    public function index($invoice_id)
    {
        $invoiceDetails = Invoice::where('invoice_id', '=', $invoice_id)->first();
        $challanItems = DB::table('challan_item_master')
            ->select('topland.product_master.product_name','challan_item_master.*')
            ->leftJoin('complain_item_details','complain_item_details.cid_id','=','challan_item_master.complain_product_id')
            ->leftJoin('topland.product_master','topland.product_master.product_id','=','complain_item_details.product_id')
            ->where('challan_item_master.is_main', '=', 'Y')
            ->where('challan_item_master.is_used', '=', 'N')
            ->where('challan_item_master.challan_id', '=', $invoiceDetails['challan_id'])
            ->get();
//        echo "<pre>";
//        print_r($challanItems);exit();
        $spareItems = ChallanOptional::with('getProduct')
            ->where('challan_optional.is_used', '=', 'N')
            ->where('challan_optional.optional_status', '=', 'Spare')
            ->where('challan_id', '=', $invoiceDetails['challan_id'])
            ->get();

        $invoiceList = DB::select("SELECT topland.product_master.product_name,invoice_items.* FROM invoice_items
LEFT JOIN challan_item_master ON challan_item_master.challan_product_id = invoice_items.challan_product_id
LEFT JOIN complain_item_details ON complain_item_details.cid_id = challan_item_master.complain_product_id
LEFT JOIN topland.product_master ON topland.product_master.product_id = complain_item_details.product_id
WHERE invoice_id = $invoice_id");
        return view('invoice.product')->with('pageType', $this->pageType)->with('action', 'INSERT')->with(compact('challanItems','invoice_id', 'spareItems', 'invoiceList', 'invoice_id'));

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
     * @param $challan_optional_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_array($request->input('product_id'))) {
            foreach ($request->input('product_id') as $row) {
                $product_id = ChallanProduct::find($row);
                $product_id->is_used = 'Y';
                $product_id->save();
                $complainItem = DB::table('complain_item_details')
                    ->where('cid_id',$product_id->complain_product_id)->first();

                $invoiceItems = new InvoiceItem();
                $invoiceItems->invoice_id = $request->input('invoice_id');
                $invoiceItems->product_id = $complainItem->product_id;
                $invoiceItems->category_id = $complainItem->category_id;
                $invoiceItems->pro_qty = $request->input('pro_qty');
                $invoiceItems->challan_product_id = $row;
                $invoiceItems->type = 'Product';
                $invoiceItems->created_id = Auth::user()->user_id;
                $invoiceItems->branch_id = Auth::user()->branch_id;
                $invoiceItems->save();
                $request->session()->flash('create-status', 'Product Add Successfully..');
            }
        }
        if (is_array($request->input('challan_optional_id'))) {
            foreach ($request->input('challan_optional_id') as $row) {
                $spareItem = ChallanOptional::find($row);
                $spareItem->is_used = 'Y';
                $spareItem->save();

                $invoiceItems = new InvoiceItem();
                $invoiceItems->invoice_id = $request->input('invoice_id');
                $invoiceItems->product_id = $spareItem->product_id;
                $invoiceItems->challan_product_id = $row;
                $invoiceItems->type = 'Spare';
                $invoiceItems->created_id = Auth::user()->user_id;
                $invoiceItems->branch_id = Auth::user()->branch_id;
                $invoiceItems->save();
                $request->session()->flash('create-status', 'Spare Add Successfully..');
            }
        }

        return redirect('invoice-items-create/'.$request->input('invoice_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\InvoiceItem $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\InvoiceItem $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\InvoiceItem $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\InvoiceItem $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $findInvoiceItem = InvoiceItem::find($id);
        $type = $findInvoiceItem->type;
        if ($type == 'product') {
            $challanProduct = ChallanProduct::find($findInvoiceItem->challan_product_id);
            $challanProduct->is_used = 'N';
            $challanProduct->save();
            $request->session()->flash('delete-status', 'Product Successfully Deleted...');
        } else {
            $challanOptional = ChallanOptional::find($findInvoiceItem->challan_product_id);
            $challanOptional->is_used = 'N';
            $challanOptional->save();
            $request->session()->flash('delete-status', 'Spare Successfully Deleted...');
        }
        InvoiceItem::destroy($id);
        return redirect('invoice-items-create/'.$findInvoiceItem->invoice_id);
    }
}
