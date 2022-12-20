<?php

namespace App\Http\Controllers;

use App\Billty;
use App\BorewellTesting;
use App\Challan;
use App\ChallanProduct;
use App\ChallanOptional;
use App\ChallanTestingMaster;
use App\ComplainItemDetail;
use App\EngineTesting;
use App\GeneratorTesting;
use App\Image;
use App\WeldingGeneratorTesting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ChallanProductController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($challan_id)
    {
        $complainProductData = DB::select("SELECT
	topland.product_master.product_name,
	billty_product_details.product_id,
	billty_product_details.serial_no,
	billty_product_details.cid_id
FROM
	challan
LEFT JOIN billty ON billty.billty_id = challan.billty_id
LEFT JOIN billty_product_details ON billty_product_details.billty_id = billty.billty_id
LEFT JOIN complain ON complain.complain_id = billty_product_details.complain_id
LEFT JOIN topland.product_master ON topland.product_master.product_id = billty_product_details.product_id
WHERE
	challan.challan_id = $challan_id
AND is_product_used = 'N'");
        $complainProductData = isset($complainProductData) ? $complainProductData : '';

        $challanItem = ChallanProduct::with('getOptional.getProduct')->with('getOptionalSpare.getProduct')
            ->with('getShortageList.getShortageName')->with('getBrand')->with('getProduct')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('challan_id', $challan_id)
            ->get();

        $category_master = DB::table('topland.category_master')
            ->where('is_delete', '=', 'N')
            ->get()
            ->toArray();
        $category_master = json_decode(json_encode($category_master), true);

        $brand_master = DB::table('topland.brand_master')
            ->where('is_delete', '=', 'N')
            ->get()
            ->toArray();
        $brand_master = json_decode(json_encode($brand_master), true);

        $optional = DB::table('topland.product_master')
            ->where('category_id', '=', '10')
            ->where('is_delete', '=', 'N')
            ->get()
            ->toArray();
        $optional = json_decode(json_encode($optional), true);

        $spare = DB::table('topland.product_master')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();
        $ChallanProduct = '';
        $spare = DB::table('topland.product_master')->where('category_id', '=', 9)->get();
        $unitMaster = DB::table('unit_master')->get();
        $mechanicMaster = DB::table('topland.mechanic_master')->get();
        return view('challan.product')->with('pageType', $this->pageType)->with('action', 'INSERT')->with(compact('challan_id', 'unitMaster', 'ChallanProduct', 'complainProductData', 'challanItem', 'category_master', 'optional', 'brand_master', 'spare', 'mechanicMaster'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'brand_id' => 'Select Brand Name',
            'packing_type' => 'Select Packing Type',
            'warranty' => 'Enter Warranty',
            'serial_no' => 'Enter Serial No',
            'production_no' => 'Enter Production No',
        ];
        $rules = [
            'brand_id' => 'required',
            'packing_type' => 'required',
            'warranty' => 'required',
            'production_no' => 'required',
            'serial_no' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $complain_product_id = $request->input('complain_product_id');

        DB::table('billty_product_details')
            ->where('cid_id', $complain_product_id)
            ->where('serial_no', $request->input('serial_no'))
            ->update(['is_product_used' => 'Y']);
        $complainItem = DB::table('billty_product_details')->where('cid_id', $complain_product_id)->first();
        $challan = new ChallanProduct();

        $challan_id = DB::select("SELECT challan_id FROM billty_product_details
LEFT JOIN challan ON challan.billty_id = billty_product_details.billty_id
WHERE billty_product_details.cid_id = $complain_product_id");

        $challan->challan_id = $challan_id[0]->challan_id;
        $challan->category_id = $request->input('category_id');
        $challan->product_id = $complainItem->product_id;
        $challan->complain_product_id = $request->input('complain_product_id');
        $challan->brand_id = $request->input('brand_id');
        $challan->packing_type = $request->input('packing_type');
        $challan->warranty = $request->input('warranty');
        $challan->serial_no = $request->input('serial_no');
        $challan->bill_no = $request->input('bill_no');
        $challan->bill_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('bill_date'))));
        $challan->application = $request->input('application');
        $challan->hour_run = $request->input('hour_run');
        $challan->production_no = $request->input('production_no');
        $challan->product_charge = $request->input('product_charge');
        $challan->product_qty = $request->input('product_qty');
        $challan->quantity = $request->input('quantity');
        $challan->mechanic_id = $request->input('mechanic_id');
        $challan->created_id = Auth::user()->user_id;
        $challan->branch_id = Auth::user()->branch_id;
        $challan->created_at = date('Y-m-d H:i:s');
        $challan->save();
        $request->session()->put('challan_product_id', $challan->challan_product_id);
        $request->session()->flash('create-status', ' Product Successfully Created...');

        return redirect('challan-product-create/' . $challan->challan_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ChallanProduct $challanProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ChallanProduct $challanProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ChallanProduct $challanProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(ChallanProduct $challanProduct)
    {
        $challan_id = $challanProduct->challan_id;
        $complainProductData = DB::select("SELECT
	topland.product_master.product_name,
	billty_product_details.product_id,
	billty_product_details.serial_no,
	billty_product_details.cid_id
FROM
	challan
LEFT JOIN billty ON billty.billty_id = challan.billty_id
LEFT JOIN billty_product_details ON billty_product_details.billty_id = billty.billty_id
LEFT JOIN complain ON complain.complain_id = billty_product_details.complain_id
LEFT JOIN topland.product_master ON topland.product_master.product_id = billty_product_details.product_id
WHERE
	challan.challan_id = $challan_id
  AND billty_product_details.cid_id = $challanProduct->complain_product_id");
        $challanItem = ChallanProduct::with('getOptional.getProduct')->with('getOptionalSpare.getProduct')
            ->with('getShortageList.getShortageName')->with('getBrand')->with('getProduct')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('challan_id', $challan_id)
            ->get();

        $category_master = DB::table('topland.category_master')
            ->where('is_delete', '=', 'N')
            ->get()
            ->toArray();
        $category_master = json_decode(json_encode($category_master), true);

        $brand_master = DB::table('topland.brand_master')
            ->where('is_delete', '=', 'N')
            ->get()
            ->toArray();
        $brand_master = json_decode(json_encode($brand_master), true);

        $optional = DB::table('topland.product_master')
            ->where('category_id', '=', '10')
            ->where('is_delete', '=', 'N')
            ->get()
            ->toArray();
        $optional = json_decode(json_encode($optional), true);

        $spare = DB::table('topland.product_master')
            ->where('category_id', '=', '9')
            ->where('is_delete', '=', 'N')
            ->get();
        $unitMaster = DB::table('unit_master')->get();
        $mechanicMaster = DB::table('topland.mechanic_master')->get();
        return view('challan.product')->with('action', 'UPDATE')->with('pageType', $this->pageType)->with(compact('optional', 'unitMaster', 'complainProductData', 'spare', 'mechanicMaster', 'challanProduct'))->with('challanItem', $challanItem)->with('category_master', $category_master)->with('brand_master', $brand_master)->with('challan_id', $challan_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ChallanProduct $challanProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChallanProduct $challanProduct)
    {
        $messages = [
            'brand_id' => 'Select Brand Name',
            'packing_type' => 'Select Packing Type',
            'warranty' => 'Enter Warranty',
            'serial_no' => 'Enter Serial No',
            'production_no' => 'Enter Production No',
        ];
        $rules = [
            'brand_id' => 'required',
            'packing_type' => 'required',
            'warranty' => 'required',
            'serial_no' => 'required',
            'production_no' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $columnArray = [
            'category_id' => $request->post('category_id'),
            'complain_product_id' => $request->post('complain_product_id'),
            'brand_id' => $request->post('brand_id'),
            'packing_type' => $request->post('packing_type'),
            'warranty' => $request->post('warranty'),
            'product_charge' => $request->post('product_charge'),
            'serial_no' => $request->post('serial_no'),
            'bill_no' => $request->post('bill_no'),
            'bill_date' => date('Y-m-d', strtotime(str_replace('/', '-', $request->input('bill_date')))),
            'application' => $request->post('application'),
            'hour_run' => $request->post('hour_run'),
            'production_no' => $request->post('production_no'),
            'product_qty' => $request->post('product_qty'),
            'quantity' => $request->post('quantity'),
            'mechanic_id' => $request->post('mechanic_id'),
            'updated_id' => Auth::user()->user_id,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
//        echo "<pre>";
//        print_r($challanProduct->challan_id);exit();
        DB::table('challan_item_master')
            ->where('challan_product_id', $request->input('challan_product_id'))
            ->update($columnArray);
        $request->session()->flash('update-status', ' Product Successfully Updated...');

        return redirect('challan-product-create/' . $challanProduct->challan_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ChallanProduct $challanProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChallanProduct $challanProduct, Request $request)
    {
        $challanProduct = ChallanProduct::find($_POST['challan_product_id']);
        $complain_product_id = $challanProduct->complain_product_id;
        $serial_no = $challanProduct->serial_no;
        if ($challanProduct->is_used == 'N') {
            DB::table('billty_product_details')->where('cid_id', $complain_product_id)->where('serial_no', $serial_no)->update(['is_product_used' => 'N']);
            ChallanProduct::destroy($_POST['challan_product_id']);
            Image::where('challan_product_id', $challanProduct->challan_product_id)->delete();
            ChallanTestingMaster::where('challan_product_id', $challanProduct->challan_product_id)->delete();
            BorewellTesting::where('challan_product_id', $challanProduct->challan_product_id)->delete();
            EngineTesting::where('challan_product_id', $challanProduct->challan_product_id)->delete();
            GeneratorTesting::where('challan_product_id', $challanProduct->challan_product_id)->delete();
            WeldingGeneratorTesting::where('challan_product_id', $challanProduct->challan_product_id)->delete();
            $request->session()->flash('delete-status', ' Product Successfully Deleted...');
        } else {
            $request->session()->flash('delete-status', 'Invoice or Credit Note or Destroy is created......!');
        }
        return redirect('challan-product-create/' . $challanProduct->challan_id);
    }

    public function getBillDetails()
    {
        $sr_no = $_POST['sr_no'];
        $product_id = $_POST['product_id'];
        $productHistory = DB::table('topland.invoice_serial_info')
            ->select('topland.invoice_serial_info.invoice_no', 'topland.invoice_serial_info.invoice_date', 'topland.invoice_serial_info.production_no')
            ->where('topland.invoice_serial_info.product_id', '=', $product_id)
            ->where('topland.invoice_serial_info.serial_no', '=', $sr_no)
            ->get();
        return json_encode(array('bill_no' => $productHistory[0]->invoice_no, 'bill_date' => date('d/m/Y', strtotime($productHistory[0]->invoice_date))));

    }

    public function getProduct(Request $request)
    {
        $category_id = $request->input('category_id');
        $productList =
            DB::table('topland.product_master')
                ->select('product_id', 'product_name')
                ->where('category_id', '=', $category_id)
                ->get()
                ->toArray();
        $productList = json_decode(json_encode($productList), true);
        $option = "<option value=''>Select Product Name</option>";
        foreach ($productList as $row) {
            $option .= "<option value='" . $row['product_id'] . "'>" . $row['product_name'] . "</option>";
        }
        echo $option;
    }

    public function saveOptional(Request $request)
    {
        $product_id = $request->input('product_id');
        $type = $request->input('type');
        $item_id = $request->input('item_id');

        $challanItem = ChallanProduct::find($item_id);
//        $challanItem->is_main = 'N';
        $challanId = $challanItem->challan_id;
//        $challanItem->save();

        DB::table('challan_optional')
            ->insert(['challan_product_id' => $item_id, 'product_id' => $product_id, 'optional_status' => $type, 'qty' => 1, 'challan_id' => $challanId]);
        $request->session()->flash('create-status', 'Optional Product successful Added..');
    }

    public function saveSpare(Request $request)
    {
        $product_id = $request->input('product_id');
        $type = 'Spare';
        $item_id = $request->input('item_ids');
        $spareQty = $request->input('spareQty');
        $unit_name = $request->input('unit_name');

        $challanItem = ChallanProduct::find($item_id);
        $challanItem->is_main = 'N';
        $challanId = $challanItem->challan_id;
        $challanItem->save();
        $request->session()->flash('create-status', 'Spare Product Successful Added...');

        DB::table('challan_optional')
            ->insert(['challan_product_id' => $item_id, 'branch_id' => Auth::user()->branchyy_id, 'created_id' => Auth::user()->user_id, 'product_id' => $product_id, 'optional_status' => $type, 'unit_name' => $unit_name, 'qty' => $spareQty, 'challan_id' => $challanId]);

        return redirect('challan-product-create/' . $challanItem->challan_id);
    }

    public function deleteOptional($id, Request $request)
    {

        $checkChallanMain = ChallanOptional::where('challan_optional_id', '=', $id)->first();
        $challan_product_id = $checkChallanMain['challan_product_id'];
        ChallanOptional::destroy($id);
        $checkMain = ChallanOptional::where('challan_product_id', '=', $checkChallanMain['challan_product_id'])->where('optional_status', '=', 'Spare')->first();
        if (empty($checkMain)) {
            $challanItem = ChallanProduct::find($challan_product_id);
            $challanItem->is_main = 'Y';
            $challanItem->save();
        }
        $request->session()->flash('delete-status', 'Optional Product Successful Deleted...');

        return redirect('challan-product-create/' . $checkChallanMain->challan_id);
    }

    public function getPendingItem()
    {
        DB::raw("
        select ((select ifnull(count(challan_item_master.challan_id), 0)
        from challan_item_master
        where challan_item_master.challan_id = challan.challan_id
        and challan_item_master.is_main = 'Y'
        and challan_item_master.is_used = 'N')+
        (select ifnull(count(challan_optional.challan_id), 0)
        from challan_optional
        where challan_optional.challan_id = challan.challan_id
        and challan_optional.is_used = 'N'
       ))
as pending_item
from challan
group by challan_id having pending_item > 0
");
    }

    public function getComplainDetail()
    {
        $cid_id = \request()->post('cid_id');
        $challan_id = \request()->post('challan_id');
        $complainProductData = DB::select("SELECT
	billty_product_details.product_id,
	billty_product_details.serial_no,
	billty_product_details.category_id,
    topland.category_master.category_name,
	billty_product_details.complain,
	billty_product_details.application,
	billty_product_details.warranty,
	billty_product_details.quantity,
	billty_product_details.production_no,
	billty_product_details.invoice_date as bill_date,
	billty_product_details.invoice_no as bill_no
FROM
	challan
LEFT JOIN billty ON billty.billty_id = challan.billty_id
LEFT JOIN billty_product_details ON billty_product_details.billty_id = billty.billty_id
LEFT JOIN complain ON complain.complain_id = billty_product_details.complain_id
LEFT JOIN topland.category_master ON topland.category_master.category_id = billty_product_details.category_id
WHERE
	billty_product_details.cid_id = $cid_id
AND challan.challan_id = $challan_id");
        return json_encode($complainProductData[0]);
    }

    public function getCategoryName(Request $request)
    {
        $cid_id = $request->post('complain_product_id');
        $category_name = DB::select("SELECT
	topland.category_master.category_name,billty_product_details.category_id
FROM
	billty_product_details
LEFT JOIN topland.category_master ON topland.category_master.category_id = billty_product_details.category_id
WHERE billty_product_details.cid_id = $cid_id");

        return json_encode($category_name[0]);
    }

    public function getComplainDetailHistory(Request $request)
    {
        $complain_product_id = $_POST['complain_product_id'];

        $complainLogDetail = DB::table('complain_item_details')
            ->select('product_id','serial_no')
            ->where('cid_id', '=', $complain_product_id)
            ->first();

        $sr_no = $complainLogDetail->serial_no;
        $product_id = $complainLogDetail->product_id;

        $productHistory = DB::table('topland.invoice_serial_info')
            ->select('topland.product_master.product_name', 'topland.client_master.client_name', 'topland.invoice_serial_info.invoice_no', 'topland.invoice_serial_info.invoice_date', 'topland.invoice_serial_info.production_no')
            ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'topland.invoice_serial_info.product_id')
            ->leftjoin('topland.client_master', 'topland.client_master.client_id', '=', 'topland.invoice_serial_info.party_id')
            ->where('topland.invoice_serial_info.product_id', '=', $product_id)
            ->where('topland.invoice_serial_info.serial_no', '=', $sr_no)
            ->get()
            ->toArray();
        $productHistory = json_decode(json_encode($productHistory), true);

        if (!empty($productHistory)) {
            echo $table = '
<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                    <thead>
                    <tr>
                        <th class="text-center" colspan="6">INVOICE DETAIL</th>
                    </tr><tr>
                        <th>Client Name</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Production No</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($productHistory as $row) {
                echo '<tr>
                        <td>' . $row['client_name'] . '</td>
                        <td>' . $row['invoice_no'] . '</td>
                        <td>' . date('d-m-Y', strtotime($row['invoice_date'])) . '</td>
                        <td>' . $row['production_no'] . '</td>
                    </tr>';
            }
            echo '</tbody></table>';
        }

        $complainLog = DB::table('complain_item_details')
            ->select('topland.product_master.product_name', 'complain.complain_no', 'complain_item_details.complain_id', 'complain.created_at', 'complain_item_details.complain', 'complain_item_details.solution', 'complain_item_details.solution_by')
            ->leftjoin('topland.product_master', 'product_master.product_id', '=', 'complain_item_details.product_id')
            ->leftjoin('complain', 'complain.complain_id', '=', 'complain_item_details.complain_id')
            ->where('complain_item_details.product_id', '=', $product_id)
            ->where('serial_no', '=', $sr_no)
            ->get()
            ->toArray();
        $complainLog = json_decode(json_encode($complainLog), true);
        if (!empty($complainLog)) {
            echo $table = '
<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                    <thead>
                    <tr>
                        <th class="text-center" colspan="6">COMPLAIN HISTORY</th>
                    </tr><tr>
                        <th>TKT. No</th>
                        <th>TKT. Date</th>
                        <th>Product Name</th>
                        <th>Problem</th>
                        <th>Solution</th>
                        <th>Solution By</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($complainLog as $row) {
                echo '<tr>
                        <td><a target="_blank" href="' . url('/complain-progress') . '/' . $row['complain_id'] . '">' . $row['complain_no'] . '</a></td>
                        <td>' . date('d-m-Y h:i:s', strtotime($row['created_at'])) . '</td>
                        <td>' . $row['product_name'] . '</td>
                        <td>' . $row['complain'] . '</td>
                        <td>' . $row['solution'] . '</td>
                        <td>' . $row['solution_by'] . '</td>
                    </tr>';
            }
            echo '</tbody></table>';
        }


    }
}

