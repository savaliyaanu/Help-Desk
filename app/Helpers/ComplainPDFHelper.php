<?php

namespace App\Helpers;

use App\AdvanceReplacement;
use App\Billty;
use App\Brands;
use App\Challan;
use App\ChallanAccessories;
use App\ChallanOptional;
use App\ChallanPanel;
use App\ChallanProduct;
use App\InspectionReport;
use App\Invoice;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;
use phpDocumentor\Reflection\Types\Null_;
use PHPUnit\TextUI\Help;

class Helper
{
    public static function complainDetail($complain_id)
    {
        $complains = DB::table('complain')
            ->select('complain_medium_details.*', 'complain.medium_id', 'complain.*', 'complain.complain_no', 'medium.medium_name', 'complain.complain_type', 'complain.mobile2', 'complain.email_address', 'complain.medium_id', 'topland.user_master.user_fname', 'complain.created_at', 'complain.client_name', 'complain.address', 'complain.district', 'complain.state', 'topland.city_master.city_name', 'topland.client_master.pincode', 'complain.mobile',
                DB::raw("CONCAT(topland.user_master.user_fname,' ',topland.user_master.user_lname) as assign_name"), 'company_master.company_name',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->leftJoin('topland.client_master', 'topland.client_master.client_id', '=', 'complain.client_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('medium', 'medium.medium_id', '=', 'complain.medium_id')
            ->leftJoin('complain_medium_details', 'complain_medium_details.complain_id', '=', 'complain.complain_id')
            ->leftJoin('topland.user_master', 'topland.user_master.user_id', '=', 'complain.assign_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'complain.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('complain.complain_id', '=', $complain_id)
            ->get();


        $complainItem = DB::table('complain_item_details')
            ->select('topland.category_master.category_name', 'topland.product_master.product_name', 'complain.complain_type', 'complain_item_details.*')
            ->join('topland.category_master', 'topland.category_master.category_id', '=', 'complain_item_details.category_id')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->join('complain', 'complain.complain_id', '=', 'complain_item_details.complain_id')
            ->where('complain.complain_id', '=', $complain_id)
            ->get();

        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 15);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Ln();
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

        $mediumData = '';
        if ($complains[0]->medium_id == 1) {
            $mediumData = 'Mobile No : ' . $complains[0]->mobile_no;
        }
        if ($complains[0]->medium_id == 2) {
            $mediumData = 'Voucher No : ' . $complains[0]->voucher_no;
        }
        if ($complains[0]->medium_id == 3) {
            $mediumData = 'WhatsApp No : ' . $complains[0]->whatsapp_no;
        }
        if ($complains[0]->medium_id == 4) {
            $mediumData = 'Email : ' . $complains[0]->email;
        }
        if ($complains[0]->medium_id == 5) {
            $mediumData = 'Vehicle No : ' . $complains[0]->vehicle_no;
        }
        if ($complains[0]->medium_id == 6) {
            $mediumData = 'Staff Name : ' . $complains[0]->staff_name;
        }

        Fpdf::Ln();
        Fpdf::SetFont('Verdana', '', 10);
        Fpdf::Cell(190, 5, $complains[0]->company_name, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Courier', 'B', 15);
        Fpdf::Cell(190, 5, 'Complain', 0, 0, 'C');
        Fpdf::Ln(5);
        Fpdf::SetWidths(array(95, 95));
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Ln();
        if ($complains[0]->branch_id == 1) {
            $complains_no = 'PF-TKT/' . $complains[0]->fyear . '/' . $complains[0]->complain_no;
        } elseif ($complains[0]->branch_id == 3) {
            $complains_no = 'TE-TKT/' . $complains[0]->fyear . '/' . $complains[0]->complain_no;
        } elseif ($complains[0]->branch_id == 4) {
            $complains_no = 'TP-TKT/' . $complains[0]->fyear . '/' . $complains[0]->complain_no;
        }
        $field1 = (trim($complains[0]->client_name) . "\n" . trim($complains[0]->address)) . "\n" . 'City : ' . $complains[0]->city_name . "\n" . 'District : ' . $complains[0]->district . "\n" . 'State :' . $complains[0]->state . "\n" . 'PinCode :' . $complains[0]->pincode . "\n" . 'Mobile No. :' . $complains[0]->mobile . '/' . $complains[0]->mobile2 . "\n" . 'Email :' . $complains[0]->email_address;
        $field2 = 'Complain No : ' . $complains_no . "\n" . 'Complain Date : ' . date('d-m-Y', strtotime($complains[0]->created_at)) . "\n" . 'Complain Type : ' . strtoupper($complains[0]->complain_type) . "\n" . strtoupper($mediumData) . "\n" . 'Assign Name : ' . strtoupper($complains[0]->assign_name) . "\n" . 'Complain Status : ' . strtoupper($complains[0]->complain_status);
        if ($complains[0]->complain_status == 'Resolved') {
            $field2 .= "\n" . 'Resolve Date : ' . date('d-m-Y h:i:s', strtotime($complains[0]->resolve_date));
        }

        /** print address */
        Fpdf::Row(array(strtoupper($field1), strtoupper($field2)), array('L', 'L'), '', '', true, 4);
        Fpdf::Ln();

        $temp = 1;
        $total_QTy = 0;
        if (!empty($complainItem[0]->complain_type)) {
            Fpdf::SetFont('Courier', 'B', 10);
            Fpdf::SetWidths(array(95, 95));
            Fpdf::Cell(190, 5, 'PRODUCT DETAIL', 0, 0, 'C');
            Fpdf::Ln();
            Fpdf::Ln();

            Fpdf::SetWidths(array(10, 25, 45, 20, 17, 20, 19, 27, 8));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('No', 'Category', 'Product Name', 'Serial No.', 'Warranty', 'Pro. No', 'Invoice No', 'Invoice Date', 'Qty'), array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            foreach ($complainItem as $value) {
                Fpdf::Row(array($temp++, strtoupper($value->category_name), strtoupper($value->product_name), strtoupper($value->serial_no), $value->warranty, $value->production_no, $value->invoice_no, $value->invoice_date, $value->qty), array('C', 'L', 'L', 'C', 'C', 'C', 'L', 'L', 'C'), '', array(), true);
                $total_QTy += $value->qty;
            }
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('', '', 'Total Qty', '', '', '', '', '', $total_QTy), array('C', 'C', 'L', 'L', 'L', 'L', 'L', 'L', 'L'), '', array(), true, 4);
        }
        $complain_problem = DB::table('complain_item_details')
            ->select('complain.complain_type', 'complain_item_details.complain', 'complain_item_details.application',
                'complain_item_details.solution', 'complain_item_details.solution_by', 'topland.product_master.product_name',
                DB::raw("(select group_concat(complain_in_word) from multiple_product_complain as p WHERE p.complain_product_id = complain_item_details.cid_id) as product_complain"))
            ->join('complain', 'complain.complain_id', '=', 'complain_item_details.complain_id')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('complain_item_details.complain_id', '=', $complain_id)
            ->get();
//        echo "<pre>";
//        print_r($complain_problem);exit;
        $test = 1;
        if (!empty($complain_problem[0]->complain_type)) {
            Fpdf::Ln();
            Fpdf::Ln();
            Fpdf::SetFont('Courier', 'B', 10);
            Fpdf::SetWidths(array(95, 95));
            Fpdf::Cell(190, 5, 'PROBLEM DETAIL', 0, 0, 'C');
            Fpdf::Ln();
            Fpdf::Ln();

            Fpdf::SetWidths(array(10, 49, 33, 33, 35, 32));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('No', 'Product Name', 'Complain', 'Application', 'Solution', 'Solution By'), array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            foreach ($complain_problem as $value) {
                Fpdf::Row(array($test++, strtoupper($value->product_name), strtoupper($value->product_complain), strtoupper($value->application), strtoupper($value->solution), strtoupper($value->solution_by)), array('L', 'L', 'L', 'L', 'L', 'L'), '', array(), true);
            }
        }
        $problem = DB::table('complain')
            ->select('complain.*')
            ->leftJoin('complain_item_details', 'complain_item_details.complain_id', '=', 'complain.complain_id')
            ->where('complain.complain_id', '=', $complain_id)
            ->get();
        if (!empty($problem[0]->complain_type == 'Marketing Complain' || $problem[0]->complain_type == 'Account Complain')) {
            Fpdf::Ln();
            Fpdf::Ln();
            Fpdf::SetFont('Courier', 'B', 10);
            Fpdf::SetWidths(array(95, 95));
            Fpdf::Cell(190, 5, 'PROBLEM DETAIL', 0, 0, 'C');
            Fpdf::Ln();
            Fpdf::Ln();

            Fpdf::SetWidths(array(63, 64, 63));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('Problem', 'Solution', 'Solution By'), array('C', 'C', 'C'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            foreach ($problem as $value) {
                Fpdf::Row(array(strtoupper($value->problem), strtoupper($value->solution), strtoupper($value->solution_by)), array('L', 'L', 'L'), '', array(), true);
            }
        }
        Fpdf::SetWidths(array(20, 170));
        Fpdf::Ln(20);
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Ln();
    }

    public static function billtyPDF($billty_id)
    {
        $complain_list = DB::select("SELECT
	billty.created_at AS billty_date,
	complain.complain_no,
	complain.created_at AS complain_date,
	complain.client_name,
	complain.address,
	topland.city_master.city_name,
	complain.district,
	complain.state,
	complain.mobile,
	complain.mobile2,
	billty.other,
	billty.billty_no,
	billty.branch_id,
	billty.lr_date,
	billty.lr_no,
	topland.transport_master.transport_name,
	billty.freight_rs,
	billty.freight_rs_by,
	billty.remark,
	billty.entry_by,
	billty_handover_date.handover_date,
company_master.company_name,
(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = billty.financial_id) as fyear
FROM
	billty
LEFT JOIN complain ON complain.complain_id = billty.complain_id
LEFT JOIN topland.city_master ON topland.city_master.city_id = complain.city_id
LEFT JOIN topland.transport_master ON topland.transport_master.transport_id = billty.transport_id
LEFT JOIN branch_master ON branch_master.branch_name = billty.branch_id
LEFT JOIN company_master ON company_master.company_id = branch_master.company_id
LEFT JOIN billty_handover_date ON billty_handover_date.billty_id = billty.billty_id
WHERE
	billty.billty_id = $billty_id
");

        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 15);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Ln();
        Fpdf::Cell(190, 5, 'Billty', 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Cell(190, 5, $complain_list[0]->company_name, 0, 0, 'C');
        Fpdf::SetWidths(array(40, 150));
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

        Fpdf::SetFont('Verdana', '', 9);
        Fpdf::Ln(8);
        /** print address */
        if ($complain_list[0]->branch_id == 1) {
            $complains_no = 'PF-TKT/' . $complain_list[0]->fyear . '/' . $complain_list[0]->complain_no;
        } elseif ($complain_list[0]->branch_id == 3) {
            $complains_no = 'TE-TKT/' . $complain_list[0]->fyear . '/' . $complain_list[0]->complain_no;
        } elseif ($complain_list[0]->branch_id == 4) {
            $complains_no = 'TP-TKT/' . $complain_list[0]->fyear . '/' . $complain_list[0]->complain_no;
        }
        Fpdf::Cell(190, 5, 'PARTY DETAIL', 0, 1, 'C');
        Fpdf::Row(array('Complain No', $complains_no), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Complain Date', date('d-m-Y', strtotime($complain_list[0]->complain_date))), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Party Name', $complain_list[0]->client_name), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Address', $complain_list[0]->address), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('City', $complain_list[0]->city_name), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('District', $complain_list[0]->district), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('State', $complain_list[0]->state), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Mobile', $complain_list[0]->mobile . '/' . $complain_list[0]->mobile2), array('L', 'L'), '', '', true, 7);
        Fpdf::Ln();
        Fpdf::Cell(190, 5, 'BILLTY INFORMATION', 0, 1, 'C');

        if ($complain_list[0]->branch_id == 1) {
            $billty_no = 'PF-BI/' . $complain_list[0]->fyear . '/' . $complain_list[0]->billty_no;
        } elseif ($complain_list[0]->branch_id == 3) {
            $billty_no = 'TE-BI/' . $complain_list[0]->fyear . '/' . $complain_list[0]->billty_no;
        } elseif ($complain_list[0]->branch_id == 4) {
            $billty_no = 'TP-BI/' . $complain_list[0]->fyear . '/' . $complain_list[0]->billty_no;
        }
        Fpdf::Row(array('Billty No.', $billty_no), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Challan Type', $complain_list[0]->other), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Billty Date', date('d-m-Y', strtotime($complain_list[0]->billty_date))), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('LR No', $complain_list[0]->lr_no), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('LR Date', date('d-m-Y', strtotime($complain_list[0]->lr_date))), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Transport Name', $complain_list[0]->transport_name), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Transport Charges By', $complain_list[0]->freight_rs_by), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Transport Amount', $complain_list[0]->freight_rs), array('L', 'L'), '', '', true, 7);
        if (!empty($complain_list[0]->handover_date)) {
            Fpdf::Row(array('Handover Date', ($complain_list[0]->handover_date != NULL) ? date('d-m-Y', strtotime($complain_list[0]->handover_date)) : ''), array('L', 'L'), '', '', true, 7);
        }
        Fpdf::Row(array('Remark ', $complain_list[0]->remark), array('L', 'L'), '', '', true, 7);
        Fpdf::Row(array('Entry By ', $complain_list[0]->entry_by), array('L', 'L'), '', '', true, 7);

        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Ln();
    }

    public static function challanPDF($challan_id)
    {
        $orderList = DB::table('challan')
            ->select('challan.created_at as challan_date', 'billty.*', 'topland.transport_master.transport_name', 'complain.*', 'complain.mobile as contact_no'
                , 'topland.city_master.city_name', 'topland.district_master.district_name',
                'topland.state_master.state_name', 'challan.*', 'topland.client_master.mobile', 'topland.client_master.pincode', 'topland.client_master.email as email_address',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'billty.transport_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.client_master', 'topland.client_master.client_id', '=', 'complain.client_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('challan.branch_id', Auth::user()->branch_id)
            ->where('challan.challan_id', $challan_id)
            ->first();

        $complain = DB::table('challan')
            ->select('complain.created_at as complain_date', 'complain.complain_no', 'complain.branch_id', 'company_master.company_name',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = challan.financial_id) as fyear"))
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'billty.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('challan_id', $challan_id)
            ->first();

        $challanItem = ChallanProduct::with('getOptional.getProduct')->with('getShortageList.getShortageName')
            ->with('getOptional')
            ->with('getBrand')
            ->with('getProduct')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('challan_id', $challan_id)->get();

        if (empty($challanItem[0]->complain_product_id)) {
            return redirect('challan');
        }
        $client_name = $address1 = $address2 = $address3 = $city = $district = $state = '';
        if ($orderList->change_bill_address == 'Y') {
            $client_name = strtoupper($orderList->billing_name);
            $address = strtoupper($orderList->address1) . "\n" . strtoupper($orderList->address2) . "\n" . strtoupper($orderList->address3);
            $city = strtoupper($orderList->city_name);
            $district = strtoupper($orderList->district_name);
            $state = strtoupper($orderList->state_name);
            $mobile = $orderList->contact_no . ' / ' . $orderList->mobile;
            $pincode = 'PinCode : ' . $orderList->pincode;
            $email_add = 'E-mail : ' . $orderList->email_address;
        } else {
            $client_name = strtoupper($orderList->client_name);
            $address = strtoupper($orderList->address);
            $city = strtoupper($orderList->city_name);
            $district = strtoupper($orderList->district_name);
            $state = strtoupper($orderList->state_name);
            $mobile = $orderList->contact_no . ' / ' . $orderList->mobile2;
            $pincode = 'PinCode : ' . $orderList->pincode;
            $email_add = 'E-mail : ' . $orderList->email_address;
        }
        if ($complain->branch_id == 1) {
            $complains_no = 'PF-TKT/' . $complain->fyear . '/' . $complain->complain_no;
        } elseif ($complain->branch_id == 3) {
            $complains_no = 'TE-TKT/' . $complain->fyear . '/' . $complain->complain_no;
        } elseif ($complain->branch_id == 4) {
            $complains_no = 'TP-TKT/' . $complain->fyear . '/' . $complain->complain_no;
        }
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 14);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::Cell(190, 5, 'Challan', 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Cell(190, 5, $complain->company_name, 0, 0, 'C');
        Fpdf::Ln(8);
        if ($orderList->branch_id == 1) {
            $challan_no = 'PF-CH/' . $orderList->fyear . '/' . $orderList->challan_no;
        } elseif ($orderList->branch_id == 3) {
            $challan_no = 'TE-CH/' . $orderList->fyear . '/' . $orderList->challan_no;
        } elseif ($orderList->branch_id == 4) {
            $challan_no = 'TP-CH/' . $orderList->fyear . '/' . $orderList->challan_no;
        }
        Fpdf::Cell(146, 5, '', 0, 0);
        Fpdf::Cell(62, 5, 'Challan No : ' . $challan_no, 0, 0);
        Fpdf::Ln();
        Fpdf::Cell(150, 5, '', 0, 0);
        Fpdf::Cell(62, 5, 'Challan Date : ' . date('d/m/Y', strtotime($orderList->challan_date)), 0, 0);
        Fpdf::Ln(8);
        Fpdf::SetFont('Verdana', '', 9);
        Fpdf::SetWidths(array(90, 100));
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

        Fpdf::SetFont('Verdana', '', 8);
        /** print address */
        Fpdf::Row(array(
            (trim($client_name) . "\n" . trim($address) . "\n" .
                trim($city) . "\n" . trim($district) . "\n" .
                trim($state) . "\n" . trim($mobile) . "\n" .
                trim($pincode) . "\n" . trim($email_add)),
            'Complain No : ' . $complains_no . "\n" .
            'Complain Date : ' . date('d/m/Y', strtotime($complain->complain_date)) . "\n" .
//            'Challan Date : ' . date('d/m/Y', strtotime($orderList->challan_date)) . "\n" .
            'Transport : ' . $orderList->transport_name . "\n" .
            'LR No. :' . $orderList->lr_no . "\n" .
            'LR Date. :' . date('d/m/Y', strtotime($orderList->lr_date)) . "\n" .
            'Freight By : ' . $orderList->freight_rs_by . "\n" .
            'Freight Rs. : ' . $orderList->freight_rs
        ), array('L', 'L'), '', '', true, 4);
        Fpdf::Ln();
        Fpdf::SetWidths(array(10, 15, 74, 49, 21, 21));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array('No.', 'Qty.', "Item Description", 'Shortage Item', 'Serial No.', 'Pro. No.'), array('C', 'C', 'L', 'L', 'C', 'C'), '', array(), true);
        Fpdf::SetFont('Verdana', '', 8);
        if (!empty($challanItem)) {
            $temp = 1;
            $itm_grand_total = 0;
            $heading_string = strtoupper(Helper::HeadingString($challanItem[0]['brand_id'], $challanItem[0]['category_id'],
                $challanItem[0]['packing_type'], $challanItem[0]["challan_product_id"]));
            Fpdf::SetFont('Verdana-Bold', 'B', 7);
            Fpdf::Cell(190, 5, $heading_string, 'LR', 0, 'C');
            Fpdf::Ln();
            Fpdf::SetFont('Verdana', '', 8);
            $grand_total = 0;
            foreach ($challanItem as $key => $value) {
                $opt_item = '';
                $new_heading_string = strtoupper(Helper::HeadingString($value['brand_id'], $value['category_id'],
                    $value['packing_type'], $value["challan_product_id"]));

                if ($heading_string != $new_heading_string) {
                    $heading_string = $new_heading_string;
                    Fpdf::SetFont('Verdana-Bold', 'B', 7);
                    Fpdf::Cell(190, 5, $new_heading_string, 'LR', 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana', '', 8);

                }
                $sp_qry = empty($value->is_main == 'N') ? 1 : '';
                if (!empty($value->getoptional)) {
                    $unit_name = '';

                    foreach ($value->getoptional as $sp) {
                        $opt_item .= "\n";
                        if ($sp->optional_status == 'Remove') {
                            $opt_item .= '(-)';
                        } elseif ($sp->optional_status == 'ADD') {
                            $opt_item .= '(+)';
                        }
                        $opt_item .= $sp->getProduct->product_name;

                        $sp_qry .= "\n " . $sp['qty'];
                        $itm_grand_total += $sp['qty'];
                        $unit_name = $sp->unit_name;
                    }
                } else {
                    $sp_qry = $value['qty'];
                }
                $shortageName = '';
                if (!empty($value->getShortageList)) {
                    foreach ($value->getShortageList as $sp) {
                        $shortageName .= $sp->getShortageName->shortage_name;
                        $shortageName .= "\n";
                    }
                }
                $itm_grand_total += $value->quantity;
                Fpdf::Row(array(
                    $temp,
                    $sp_qry . ' ' . $unit_name . !empty($value->quantity) ? $value->quantity : '',
                    $value->getProduct->product_name . " - " . strtoupper(Helper::ProductString($value['product_id'], $value['category_id'])) . $opt_item . " - " . 'Weight : ' . $value->getProduct->n_wt,
                    $shortageName,
                    rtrim($value['serial_no']),
                    $value->production_no
                ), array('C', 'L', 'L', 'L', 'C', 'C', 'C'), '', array(), true, 5);
                $temp++;
            }
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('', $itm_grand_total, 'Total Qty', '', '', ''), array('C', 'C', 'L', 'L', 'L', 'L'), '', array(), true, 4);
            Fpdf::Ln();
        }

        $accesories = ChallanAccessories::with('getAccessory')
            ->where('challan_id', '=', $challan_id)
            ->get();

        if (!empty($accesories[0])) {
            $ac_grand_total = 0;
            Fpdf::SetWidths(array(10, 20, 160));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(20, 5, 'Accessories', 0);
            Fpdf::Ln();
            Fpdf::Row(array('No.', 'Qty.', "Item Description"), array('C', 'C', 'L'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            $temp = 0;
            foreach ($accesories as $accesory) {
                $temp++;
                Fpdf::Row(array($temp, $accesory['accessories_qty'] . ' ' . $accesory['accessories_unit_name'], $accesory->getAccessory->accessories_name), array('C', 'C', 'L'), '',
                    array(), true);
                $ac_grand_total += $accesory['accessories_qty'];
            }
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('', $ac_grand_total, 'Total Qty'), array('C', 'C', 'L', 'L'), '', array(), true, 4);
            Fpdf::Ln();
        }
        $panelList = ChallanPanel::with('getProduct')
            ->where('challan_id', '=', $challan_id)->get();

        if (!empty($panelList[0])) {
            $panel_grand_total = 0;
            Fpdf::SetWidths(array(10, 20, 160));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(20, 5, 'Panel', 0);
            Fpdf::Ln();
            Fpdf::Row(array('No.', 'Qty.', "Item Description"), array('C', 'C', 'L'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            $temp = 0;
            foreach ($panelList as $panel) {
                $temp++;
                Fpdf::Row(array($temp, $panel['panel_qty'] . ' ' . $panel['panel_unit_name'], $panel->getProduct->product_name), array('C', 'C', 'L'), '', array(), true);
                $panel_grand_total += $panel['panel_qty'];
            }
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('', $panel_grand_total, 'Total Qty'), array('C', 'C', 'L', 'L'), '', array(), true, 4);
            Fpdf::Ln();
        }
        $shortage_item = DB::table('challan_shortage_item')
            ->select('shortage_item_master.shortage_name', 'challan.other_shortage_item')
            ->join('shortage_item_master', 'shortage_item_master.shortage_item_master_id', '=', 'challan_shortage_item.shortage_item_master_id')
            ->join('challan', 'challan.challan_id', '=', 'challan_shortage_item.challan_id')
            ->where('challan_shortage_item.challan_id', '=', $challan_id)
            ->get();
        if (empty($shortage_item)) {
            Fpdf::SetWidths(array(15, 175));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(20, 5, 'Shortage Item List', 0);
            Fpdf::Ln();
            Fpdf::Row(array('No.', 'Shortage Item Name'), array('C', 'L'), '', array(), true);
            Fpdf::SetFont('Verdana', '', 8);
            $temp = 0;
            foreach ($shortage_item as $value) {
                $temp++;
                Fpdf::Row(array($temp, $value->shortage_name), array('C', 'L', 'L'), '',
                    array(), true);
            }
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(190, 5, 'Other Shortage List :' . (!empty($shortage_item[0]->other_shortage_item)) ? $shortage_item[0]->other_shortage_item : '', 0, 0, 'L');
            Fpdf::Ln();
        }
        Fpdf::Ln();

        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetWidths(array(20, 170));
        Fpdf::Row(array('Remark .:', strtoupper($orderList->remark)), array('L', 'L'), '', array('B', ''), true);
        Fpdf::Ln(20);
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(155);
        Fpdf::Cell(35, 5, 'Authorised Signature', 'T', 0, 'R');
        Fpdf::Ln();
    }


    public static function changeSparePdf($challan_id)
    {
        $orderList = DB::table('challan')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'billty.transport_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('challan.branch_id', Auth::user()->branch_id)
            ->where('challan.challan_id', $challan_id)
            ->first();
        $complain = DB::table('challan')
            ->select('complain.created_at as complain_date', 'complain.complain_no', 'company_master.company_name', 'complain.branch_id',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'billty.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('challan_id', $challan_id)
            ->first();

        $changeSpareItem = ChallanProduct::with('getChangeSpareInfo.getProduct')->with('getProduct')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')->where('challan_id', $challan_id)->get();
        if (empty($changeSpareItem[0]->product_id)) {
            return redirect('challan');
        }
        if ($orderList->change_bill_address == 'Y') {
            $client_name = strtoupper($orderList->billing_name);
            $address = strtoupper($orderList->address1) . "\n" . strtoupper($orderList->address2) . "\n" . strtoupper($orderList->address3);
            $city = strtoupper($orderList->city_name);
            $district = strtoupper($orderList->district_name);
            $state = strtoupper($orderList->state_name);
            $mobile = $orderList->phone . ' / ' . $orderList->mobile;
        } else {
            $client_name = strtoupper($orderList->client_name);
            $address = strtoupper($orderList->address);
            $city = strtoupper($orderList->city_name);
            $district = strtoupper($orderList->district_name);
            $state = strtoupper($orderList->state_name);
            $mobile = $orderList->mobile . ' / ' . $orderList->mobile2;
        }
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 14);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);
        Fpdf::Ln();
        Fpdf::Cell(190, 5, 'Change Spare', 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::Ln();
        Fpdf::SetFont('Verdana', '', 9);
        Fpdf::SetWidths(array(90, 100));

        Fpdf::SetFont('Verdana', '', 8);
        if ($complain->branch_id == 1) {
            $complains_no = 'PF-TKT/' . $complain->fyear . '/' . $complain->complain_no;
        } elseif ($complain->branch_id == 3) {
            $complains_no = 'TE-TKT/' . $complain->fyear . '/' . $complain->complain_no;
        } elseif ($complain->branch_id == 4) {
            $complains_no = 'TP-TKT/' . $complain->fyear . '/' . $complain->complain_no;
        }
        /** print address */
        Fpdf::Row(array(
            (trim($client_name) . "\n" . trim($address) . "\n" . trim($city) . "\n" . trim($district) . "\n" . trim($state) . "\n" . trim($mobile)),
            'Complain No : ' . $complains_no . "\n" . 'Complain Date : ' . date('d/m/Y', strtotime($complain->complain_date)) . "\n" . 'Challan Date : ' . date('d/m/Y', strtotime($orderList->created_at)) . "\n" . 'Transport : ' . $orderList->transport_name . "\n" . 'LR No. :' . $orderList->lr_no . "\n" . 'LR Date. :' . date('d/m/Y',
                strtotime($orderList->lr_date)) . "\n" . 'Freight By : ' . $orderList->freight_rs_by . "\n" . 'Freight Rs. : ' . $orderList->freight_rs
        ), array('L', 'L'), '', '', true, 4);
        Fpdf::Ln();
        Fpdf::SetWidths(array(10, 100, 16, 20, 20, 24));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::CellFitScale(10, 6, 'No', 'TL', 0, 'C');
        Fpdf::CellFitScale(100, 6, "Item Description", 'TL', 0, 'L');
        Fpdf::CellFitScale(16, 6, "Charge", 'TL', 0, 'L');
        Fpdf::CellFitScale(20, 6, 'Qty.', 'TL', 0, 'C');
        Fpdf::CellFitScale(20, 6, 'Price', 'TL', 0, 'C');
        Fpdf::CellFitScale(24, 6, 'Amount', 'TLR', 0, 'C');
        Fpdf::Ln();
        Fpdf::SetWidths(array(10, 100, 16, 20, 20, 24));
        Fpdf::SetFont('Verdana', '', 8);
        $sp_qry = 0;
        $mainTotal = 0;
        $totalCharge = 0;
        if (!empty($changeSpareItem)) {
            $temp = 1;
            $itm_grand_total = 0;
            $grand_total = 0;
            foreach ($changeSpareItem as $key => $value) {
                $sp_qry = '';
                $rate = '';
                if (!empty($value->getChangeSpareInfo)) {
                    Fpdf::Row(array(
                        $temp,
                        $value->getProduct->product_name . ' (' . $value->serial_no . ')',
                        $value->product_charge,
                        $sp_qry,
                        $rate,
                        ''),
                        array('C', 'L', 'C', 'C', 'C', 'C'), '', array(), true, 5);
                    foreach ($value->getChangeSpareInfo as $sp) {
                        Fpdf::CellFitScale(10, 6, '', 'L', 0, 'C');
                        Fpdf::CellFitScale(100, 6, isset($sp->getProduct->product_name) ? $sp->getProduct->product_name : '' . ' ' . $sp->missing_spare, 'TL', 0, 'L');
                        Fpdf::CellFitScale(16, 6, '', 'TL', 0, 'L');
                        Fpdf::CellFitScale(20, 6, $sp['qty'] . '  ' . $sp['unit_name'], 'TL', 0, 'C');
                        Fpdf::CellFitScale(20, 6, $sp['rate'], 'TL', 0, 'C');
                        Fpdf::CellFitScale(24, 6, $sp['qty'] * $sp['rate'], 'TLR', 1, 'C');

                        $itm_grand_total += $sp['qty'];
                        $grand_total += $sp['qty'] * $sp['rate'];

                    }
                    $totalCharge += $value->product_charge;
                    $mainTotal = $grand_total + $totalCharge;
                } else {
                    $sp_qry = '';
                }

                $temp++;

            }
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('', 'Total Qty', $totalCharge, $itm_grand_total, '', 'Rs.' . $mainTotal), array('C', 'L', 'C', 'C', 'L', 'C'), '', array(), true, 4);

            Fpdf::Ln();
        }
    }

    public static function HeadingString($brand_id, $categoryId, $packType, $challan_detail_id)
    {
        $challan_detail_id = empty($challan_detail_id) ? 0 : $challan_detail_id;
        $spare_data = ChallanOptional::where('challan_product_id', $challan_detail_id)->where('optional_status', 'Spare');
        $category_data = DB::table('topland.category_master')->select('category_name')->where('category_id', '=', $categoryId)->first();
        if (empty($category_data->category_name) == null) {
            $categoryName = $category_data->category_name;
        }
        $brand_data = Brands::find($brand_id);
        $brandName = $brand_data->brand_name;
        $strHeading = $brandName . " ";
        switch ($categoryId) {
            case 1:
                $strHeading .= $categoryName . " ";
                break;
            case 2:
            case 3:
                $strHeading .= $categoryName . " ";
                break;
            case 4:
                $strHeading .= $categoryName . " ";
                break;
            case 5:
                $strHeading .= $categoryName . " ";
                break;
            case 6:
            case 11:
                $strHeading .= $categoryName . " ";
                break;
            case 8:
                $strHeading .= $categoryName . " ";
                break;
            case 12:
            case 7:
                $strHeading .= $categoryName . " * ";
                break;
            default:
                $strHeading .= " ";
        }
        if (!empty($spare_data)) {
            $strHeading .= " Parts ";
        }
        return $strHeading;
    }

    public static function ProductString($product_id, $categoryId)
    {
        $product_data = Products::where('product_id', $product_id)->first();
        $strHeading = '';
        switch ($categoryId) {
            case 1:
                $strHeading .= " H.P. :" . $product_data->h_p . " RPM :" . $product_data->rpm;
                break;
            case 2:
            case 3:
                $strHeading .= " H.P. :" . $product_data->h_p . " RPM :" . $product_data->rpm . ' Size (' . $product_data->sucation_size_inch . " X " . $product_data->delivery_size_inch . ") ";
                break;
            case 4:
                $strHeading .= " Size :" . $product_data->sucation_size_inch . " X " . $product_data->delivery_size_inch;
                break;
            case 5:
                $strHeading .= "KVA :" . $product_data->kva . " Phase :" . $product_data->phase;
                break;
            case 6:
            case 11:
                $strHeading .= "H.P :" . $product_data->h_p . " Size :" . $product_data->sucation_size_inch . " X " . $product_data->delivery_size_inch;
                break;
            case 8:
                $strHeading .= "H.P. :" . $product_data->h_p . " RPM :" . $product_data->rpm . " KVA :" . $product_data->kva . " Phase :" . $product_data->phase;
                break;
            case 12:
            case 7:
                $strHeading .= " * ";
                break;
            default:
                $strHeading .= " ";
        }

        return $strHeading;
    }

    public static function productInspectionReport($challan_id)
    {

        $result = DB::table('challan')
            ->select(DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"), 'billty.*',
                'topland.transport_master.*', 'complain.*', 'topland.city_master.city_name', 'topland.district_master.district_name', 'topland.state_master.state_name', 'challan.*',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"))
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'billty.transport_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('challan.branch_id', Auth::user()->branch_id)
            ->where('challan.challan_id', $challan_id)
            ->first();

        $company_name = DB::table('challan')
            ->select('company_master.company_name')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'challan.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('challan_id', $challan_id)
            ->first();

        $item_list = ChallanProduct::with('getProduct')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->with('getBrand')->with('getProduct')->with('getInspectionReport')
            ->where('challan_id', $challan_id)->get();

        $client_name = $address1 = $address2 = $address3 = $city = $district = $state = '';
        if ($result->change_bill_address == 'Y') {
//            $challanBillingInfo = $this->data_model->getresult("SELECT replacement_challan_master.billing_name, replacement_challan_master.billing_address1, replacement_challan_master.billing_address2, replacement_challan_master.billing_address3, city_master.city_name, district_master.district_name, state_master.state_name FROM replacement_challan_master LEFT JOIN(city_master LEFT JOIN (district_master LEFT JOIN state_master ON state_master.state_id = district_master.state_id) ON district_master.district_id = city_master.district_id) ON replacement_challan_master.billing_city_id = city_master.city_id where replacement_challan_master.challan_id=$challan_id");
            $client_name = strtoupper($result->billing_name);
            $city = strtoupper($result->city_name);
            $district = strtoupper($result->district_name);
            $state = strtoupper($result->state_name);
        } else {
            $client_name = strtoupper($result->client_name);
            $city = strtoupper($result->city_name);
            $district = strtoupper($result->district_name);
            $state = strtoupper($result->state_name);
        }
        $spare_item = [];
        $other_item = [];
        $cnt = count($item_list);
        for ($i = 0; $i < $cnt; $i++) {
            if ($item_list[$i]->category_id == 9) {
                $spare_item[] = $item_list[$i];

            } else {
                $other_item[] = $item_list[$i];
            }
        }

        foreach ($other_item as $row) {

            $inspectionDetail = InspectionReport::where('challan_product_id', $row->challan_product_id)->first();
            $hp_rpm = '';
            $kva_phase = '';
            if (!empty($row->getProduct->h_p) && !empty($row->getProduct->rpm)) {
                $hp_rpm = $row->getProduct->h_p . " / " . $row->getProduct->rpm;
            } else {
                if (!empty($row->getProduct->h_p) && empty($row->getProduct->rpm)) {
                    $hp_rpm = $row->getProduct->h_p . " / 0";
                } else {
                    if (empty($row->getProduct->h_p) && !empty($row->getProduct->rpm)) {
                        $hp_rpm = "0 / " . $row->getProduct->rpm;
                    } else {
                        $hp_rpm = '';
                    }
                }
            }
            if (!empty($row->getProduct->kva) && !empty($row->getProduct->phase)) {
                $kva_phase = $row->getProduct->kva . " / " . $row->getProduct->phase;
            } else {
                if (!empty($row->getProduct->kva) && empty($row->getProduct->phase)) {
                    $kva_phase = $row->getProduct->kva . " / 0";
                } else {
                    if (empty($row->getProduct->kva) && !empty($row->getProduct->phase)) {
                        $kva_phase = "0 / " . $row->getProduct->phase;
                    } else {
                        $kva_phase = '';
                    }
                }
            }
            Fpdf::AddPage();
            Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
            Fpdf::AddFont('Verdana', '', 'Verdana.php');
            Fpdf::SetFont('Verdana-Bold', 'B', 10);
            Fpdf::SetAutoPageBreak(true);

            if ($result->branch_id == 1) {
                $complains_no = 'PF-TKT/' . $result->fyear . '/' . $result->complain_no;
            } elseif ($result->branch_id == 3) {
                $complains_no = 'TE-TKT/' . $result->fyear . '/' . $result->complain_no;
            } elseif ($result->branch_id == 4) {
                $complains_no = 'TP-TKT/' . $result->fyear . '/' . $result->complain_no;
            }
            if ($result->branch_id == 1) {
                $challan_no = 'PF-CH/' . $result->fyear . '/' . $result->challan_no;
            } elseif ($result->branch_id == 3) {
                $challan_no = 'TE-CH/' . $result->fyear . '/' . $result->challan_no;
            } elseif ($result->branch_id == 4) {
                $challan_no = 'TP-CH/' . $result->fyear . '/' . $result->challan_no;
            }
            Fpdf::Cell(190, 5, $company_name->company_name, 0, 1, 'C');
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(190, 5, 'INSPECTION REPORT', 0, 0, 'C');
            Fpdf::Ln();
            Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

            Fpdf::SetWidths(array(95, 95));
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::SetWidths(array(121, 44));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(18, 5, 'REF. NO :-', '', 0, 'L');
            Fpdf::Cell(46, 5, $complains_no, 'B', 0, 'L');
            Fpdf::Cell(17, 5, 'CH. NO :-', '', 0, 'L');
            Fpdf::Cell(45, 5, $challan_no, 'B', 0, 'L');
            Fpdf::Cell(20, 5, 'CH. DATE :-', '', 0, 'L');
            Fpdf::Cell(45, 5, date("d-m-Y", strtotime($result->created_at)), 'B', 0, 'L');
            if (!in_array($row->category_id, array(6, 7, 11, 12, 4))) {
                Fpdf::Ln(7);
                Fpdf::Cell(26, 5, 'PARTY NAME :-', '', 0, 'L');
                Fpdf::Cell(171, 5, $client_name, 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(12, 5, 'CITY :-', '', 0, 'L');
                Fpdf::Cell(55, 5, $city, 'B', 0, 'L');
                Fpdf::Cell(21, 5, 'DISTRICT :-', '', 0, 'L');
                Fpdf::Cell(48, 5, $district, 'B', 0, 'L');
                Fpdf::Cell(15, 5, 'STATE :-', '', 0, 'L');
                Fpdf::Cell(45, 5, $state, 'B', 0, 'L');
            }
            if (empty($sp_check)) {
                Fpdf::Ln(7);
                Fpdf::Cell(21, 5, 'MODEL NO :-', '', 0, 'L');
                Fpdf::Cell(49, 5, $row->getProduct->product_name, 'B', 0, 'L');
                Fpdf::Cell(23, 5, 'SERIAL NO :-', '', 0, 'L');
                Fpdf::Cell(43, 5, $row->serial_no, 'B', 0, 'L');
                Fpdf::Cell(21, 5, 'HP / RPM  :-', '', 0, 'L');
                Fpdf::Cell(38, 5, $hp_rpm, 'B', 0, 'L');
            }
            if (empty($sp_check)) {
                Fpdf::Ln(7);
                Fpdf::Cell(27, 5, 'KVA / PHASE :- ', '', 0, 'L');
                Fpdf::Cell(42, 5, $kva_phase, 'B', 0, 'L');
                Fpdf::Cell(18, 5, 'BRAND :- ', '', 0, 'L');
                Fpdf::Cell(40, 5, $row->getBrand->brand_name, 'B', 0, 'L');
                Fpdf::Cell(38, 5, 'WARRANTY PERIOD  :- ', '', 0, 'L');
                Fpdf::Cell(31, 5, $row->warranty, 'B', 0, 'L');
//                Fpdf::Cell(16, 5, 'P.No :- ', '', 0, 'L');
//                Fpdf::Cell(45, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(32, 5, 'MECHANIC NAME :- ', '', 0, 'L');
                Fpdf::Cell(164, 5, (!empty($inspectionDetail->mechanic_name)) ? $inspectionDetail->mechanic_name : '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(36, 5, 'PARTY COMPLAINT :- ', '', 0, 'L');
                Fpdf::Cell(160, 5, (!empty($inspectionDetail->problem)) ? $inspectionDetail->problem : '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');

            }
            Fpdf::Ln(7);
            if (in_array($row->category_id, array(6, 7, 11, 12, 4))) {
                Fpdf::Ln();
                Fpdf::Cell(36, 5, 'PARTS REPLACED :- ', '', 0, 'L');
                Fpdf::CellFitScale(160, 5, (!empty($inspectionDetail->parts_replaced)) ? $inspectionDetail->parts_replaced : '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                Fpdf::Ln(7);
                Fpdf::Cell(196, 5, '', 'B', 0, 'L');

            } else {
                if ($row->category_id == 5) {
                    Fpdf::Ln(6);
                    Fpdf::Cell(36, 5, 'VISUAL OBSERVATION :- ', '', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(15);
                    Fpdf::Cell(23, 5, 'EXTERNAL :- ', '', 0, 'L');
                    Fpdf::CellFitScale(158, 5, (!empty($inspectionDetail->external)) ? $inspectionDetail->external : '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(15);
                    Fpdf::Cell(23, 5, 'INTERNAL :- ', '', 0, 'L');
                    Fpdf::CellFitScale(158, 5, (!empty($inspectionDetail->internal)) ? $inspectionDetail->internal : '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(58, 5, 'COMPONENT CHANGED / FITTED :- ', '', 0, 'L');
                    Fpdf::CellFitScale(138, 5, (!empty($inspectionDetail->component_changed_fitted)) ? $inspectionDetail->component_changed_fitted : '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(6);
                    Fpdf::Cell(196, 5, '', 'B', 0, 'L');
                    Fpdf::Ln(10);

                } else {

                    if (in_array($row->category_id, array(1, 2, 3))) {
                        Fpdf::SetWidths(array(15, 45, 137));
                        Fpdf::SetFont('Verdana-Bold', 'B', 8);
                        Fpdf::Row(array('SR.NO.', 'NAME OF COMPONENTS', "INSPECTION CRITERIA"),
                            array('C', 'C', 'C'), '', array(), true);

                        Fpdf::Cell(15, 8, '1', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'CRANK SHAFT', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'PIN DIA.', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'BEARING DIA', true, 0, 'C');
                        Fpdf::Cell(32, 4, 'FW RUNOUT', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->crank_shaft1)) ? $inspectionDetail->crank_shaft1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->crank_shaft2)) ? $inspectionDetail->crank_shaft2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->crank_shaft3)) ? $inspectionDetail->crank_shaft3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, (!empty($inspectionDetail->crank_shaft4)) ? $inspectionDetail->crank_shaft4 : '', true, 0, 'C');
                        Fpdf::ln();


                        Fpdf::Cell(15, 8, '2', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'TRB / BB', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'BORE', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'NOISE', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->trb_bb1)) ? $inspectionDetail->trb_bb1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->trb_bb2)) ? $inspectionDetail->trb_bb2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->trb_bb3)) ? $inspectionDetail->trb_bb3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();

                        Fpdf::Cell(15, 8, '3', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'C.R.BEARING', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'WALL THICKNESS', true, 0, 'C');
                        Fpdf::Cell(37, 4, '', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->cr_bearing1)) ? $inspectionDetail->cr_bearing1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->cr_bearing2)) ? $inspectionDetail->cr_bearing2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();

                        Fpdf::Cell(15, 8, '4', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'CYL.LINER', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'BORE', true, 0, 'C');
                        Fpdf::Cell(37, 4, '', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->cyl_liner1)) ? $inspectionDetail->cyl_liner1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->cyl_liner2)) ? $inspectionDetail->cyl_liner2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '5', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'PISTON', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'ING GROOVE WIDT', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'G.P BORE', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->piston1)) ? $inspectionDetail->piston1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->piston2)) ? $inspectionDetail->piston2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->piston3)) ? $inspectionDetail->piston3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '6', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'GUDGEON PIN', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'OUTER DIA', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'HARDNESS', true, 0, 'C');
                        Fpdf::Cell(32, 4, 'CRACK', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->gudgeon_pin1)) ? $inspectionDetail->gudgeon_pin1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->gudgeon_pin2)) ? $inspectionDetail->gudgeon_pin2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->gudgeon_pin3)) ? $inspectionDetail->gudgeon_pin3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, (!empty($inspectionDetail->gudgeon_pin4)) ? $inspectionDetail->gudgeon_pin4 : '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '7', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'RING SET', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'CLOSED GAP', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'AXIAL THICKNESS', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->ring_set1)) ? $inspectionDetail->ring_set1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->ring_set2)) ? $inspectionDetail->ring_set2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->ring_set3)) ? $inspectionDetail->ring_set3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, (!empty($inspectionDetail->ring_set4)) ? $inspectionDetail->ring_set4 : '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '8', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'CON. ROD.', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'BUSH BORE', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'BENDING', true, 0, 'C');
                        Fpdf::Cell(32, 4, 'TWISTING', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->con_rod1)) ? $inspectionDetail->con_rod1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->con_rod2)) ? $inspectionDetail->con_rod2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->con_rod3)) ? $inspectionDetail->con_rod3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, (!empty($inspectionDetail->con_rod4)) ? $inspectionDetail->con_rod4 : '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '9', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'CAM SHAFT', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'HARDNESS', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'RUN OUT', true, 0, 'C');
                        Fpdf::Cell(32, 4, 'SHAFT DIA', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->cam_shaft1)) ? $inspectionDetail->cam_shaft1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->cam_shaft2)) ? $inspectionDetail->cam_shaft2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->cam_shaft3)) ? $inspectionDetail->cam_shaft3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, (!empty($inspectionDetail->cam_shaft4)) ? $inspectionDetail->cam_shaft4 : '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '10', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'VALVE', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'DIA', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'HARDNESS', true, 0, 'C');
                        Fpdf::Cell(32, 4, 'VALVE SET', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->valve1)) ? $inspectionDetail->valve1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->valve2)) ? $inspectionDetail->valve2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->valve3)) ? $inspectionDetail->valve3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, (!empty($inspectionDetail->valve4)) ? $inspectionDetail->valve4 : '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '11', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'RAM ROLLER', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'HARDNESS', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'OUTER DIA', true, 0, 'C');
                        Fpdf::Cell(32, 4, 'PLAY', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->ram_roller1)) ? $inspectionDetail->ram_roller1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->ram_roller2)) ? $inspectionDetail->ram_roller2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->ram_roller3)) ? $inspectionDetail->ram_roller3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, (!empty($inspectionDetail->ram_roller4)) ? $inspectionDetail->ram_roller4 : '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '12', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'CYL.HEAD', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'HARDNESS', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'VALVE SEAT', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->cyl_head1)) ? $inspectionDetail->cyl_head1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->cyl_head2)) ? $inspectionDetail->cyl_head2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->cyl_head3)) ? $inspectionDetail->cyl_head3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '13', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'VALVE GUIDE', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'BORE', true, 0, 'C');
                        Fpdf::Cell(37, 4, '', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->valve_guide1)) ? $inspectionDetail->valve_guide1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->valve_guide2)) ? $inspectionDetail->valve_guide2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '14', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'SIDE COVER', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'CAM BORE', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'TAPPET BORE', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->side_cover1)) ? $inspectionDetail->side_cover1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover2)) ? $inspectionDetail->side_cover2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover3)) ? $inspectionDetail->side_cover3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '15', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'CRANK CASE', true, 0, 'C');
                        Fpdf::CellFitScale(31, 8, (!empty($inspectionDetail->crank_case1)) ? $inspectionDetail->crank_case1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->crank_case2)) ? $inspectionDetail->crank_case2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->crank_case3)) ? $inspectionDetail->crank_case3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 8, (!empty($inspectionDetail->crank_case4)) ? $inspectionDetail->crank_case4 : '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '16', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'FUEL PUMP LEAVER', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'INTERDIAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'HARDNESS', true, 0, 'C');
                        Fpdf::Cell(32, 4, 'PLAY', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->side_cover1)) ? $inspectionDetail->side_cover1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover2)) ? $inspectionDetail->side_cover2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover3)) ? $inspectionDetail->side_cover3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '17', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'IDEL GEAR', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'OUTER DIA', true, 0, 'C');
                        Fpdf::Cell(37, 4, '', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->side_cover1)) ? $inspectionDetail->side_cover1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover2)) ? $inspectionDetail->side_cover2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover3)) ? $inspectionDetail->side_cover3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '18', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'VALVE TAPPET', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'DIA', true, 0, 'C');
                        Fpdf::Cell(37, 4, '', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->side_cover1)) ? $inspectionDetail->side_cover1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover2)) ? $inspectionDetail->side_cover2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover3)) ? $inspectionDetail->side_cover3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '19', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'OIL PUMP', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'INTER DIA', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'HARDNESS', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->side_cover1)) ? $inspectionDetail->side_cover1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover2)) ? $inspectionDetail->side_cover2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover3)) ? $inspectionDetail->side_cover3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '20', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'HOUSING (SMALL/BIG)', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'INTER DIA', true, 0, 'C');
                        Fpdf::Cell(37, 4, '', true, 0, 'C');
                        Fpdf::Cell(32, 4, '', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->side_cover1)) ? $inspectionDetail->side_cover1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover2)) ? $inspectionDetail->side_cover2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover3)) ? $inspectionDetail->side_cover3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
                        Fpdf::ln();
                        Fpdf::Cell(15, 8, '21', true, 0, 'C');
                        Fpdf::Cell(45, 8, 'PUMP CASING', true, 0, 'C');
                        Fpdf::Cell(31, 4, 'VISUAL', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'OUTER DIA', true, 0, 'C');
                        Fpdf::Cell(37, 4, 'ROTTER DIA', true, 0, 'C');
                        Fpdf::Cell(32, 4, 'IMPLER DIA', true, 1, 'C');
                        Fpdf::Cell(60);
                        Fpdf::CellFitScale(31, 4, (!empty($inspectionDetail->side_cover1)) ? $inspectionDetail->side_cover1 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover2)) ? $inspectionDetail->side_cover2 : '', true, 0, 'C');
                        Fpdf::CellFitScale(37, 4, (!empty($inspectionDetail->side_cover3)) ? $inspectionDetail->side_cover3 : '', true, 0, 'C');
                        Fpdf::CellFitScale(32, 4, '', true, 0, 'C');
//                        Fpdf::Cell(15, 8, '16', true, 0, 'C');
//                        Fpdf::Cell(45, 8, (!empty($inspectionDetail->componentsA1)) ? $inspectionDetail->componentsA1 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(31, 8, (!empty($inspectionDetail->componentsA2)) ? $inspectionDetail->componentsA2 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->componentsA3)) ? $inspectionDetail->componentsA3 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->componentsA4)) ? $inspectionDetail->componentsA4 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(32, 8, (!empty($inspectionDetail->componentsA5)) ? $inspectionDetail->componentsA5 : '', true, 0, 'C');
//                        Fpdf::ln();
//                        Fpdf::Cell(15, 8, '17', true, 0, 'C');
//                        Fpdf::Cell(45, 8, (!empty($inspectionDetail->componentsB1)) ? $inspectionDetail->componentsB1 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(31, 8, (!empty($inspectionDetail->componentsB2)) ? $inspectionDetail->componentsB2 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->componentsB3)) ? $inspectionDetail->componentsB3 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->componentsB4)) ? $inspectionDetail->componentsB4 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(32, 8, (!empty($inspectionDetail->componentsB5)) ? $inspectionDetail->componentsB5 : '', true, 0, 'C');
//                        Fpdf::ln();
//                        Fpdf::Cell(15, 8, '18', true, 0, 'C');
//                        Fpdf::Cell(45, 8, (!empty($inspectionDetail->componentsC1)) ? $inspectionDetail->componentsC1 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(31, 8, (!empty($inspectionDetail->componentsC2)) ? $inspectionDetail->componentsC2 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->componentsC3)) ? $inspectionDetail->componentsC3 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->componentsC4)) ? $inspectionDetail->componentsC4 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(32, 8, (!empty($inspectionDetail->componentsC5)) ? $inspectionDetail->componentsC4 : '', true, 0, 'C');
//                        Fpdf::ln();
//                        Fpdf::Cell(15, 8, '19', true, 0, 'C');
//                        Fpdf::Cell(45, 8, (!empty($inspectionDetail->componentsD1)) ? $inspectionDetail->componentsD1 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(31, 8, (!empty($inspectionDetail->componentsD2)) ? $inspectionDetail->componentsD2 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->componentsD3)) ? $inspectionDetail->componentsD3 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(37, 8, (!empty($inspectionDetail->componentsD4)) ? $inspectionDetail->componentsD4 : '', true, 0, 'C');
//                        Fpdf::CellFitScale(32, 8, (!empty($inspectionDetail->componentsD5)) ? $inspectionDetail->componentsD5 : '', true, 0, 'C');
//                        Fpdf::Ln(10);

                    }
                }
            }
            Fpdf::Ln(10);
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::SetWidths(array(95, 95));
            Fpdf::Cell(18, 5, 'FAULT :-', '', 0, 'L');
            Fpdf::Cell(49, 5, (!empty($inspectionDetail->fault)) ? $inspectionDetail->fault : '', 'B', 0, 'L');
            Fpdf::Cell(85, 5, 'CHECKED BY :-', '', 0, 'R');
            Fpdf::Cell(45, 5, (!empty($inspectionDetail->checked_by)) ? $inspectionDetail->checked_by : '', 'B', 0, 'L');
            Fpdf::Ln(8);
            Fpdf::Cell(45, 5, 'COMPANY OBSERVATION :- ', '', 0, 'L');
            Fpdf::CellFitScale(151, 5, (!empty($inspectionDetail->company_observation)) ? $inspectionDetail->company_observation : '', 'B', 0, 'L');
            Fpdf::Ln(7);
            Fpdf::Cell(196, 5, '', 'B', 0, 'L');
            Fpdf::Ln(25);
            if (in_array($row->category_id, array(6, 7, 11, 12))) {

                Fpdf::Cell(5);
                Fpdf::Cell(25, 5, 'PRAKASH BHAI. ', '', 0, 'C');
                Fpdf::Cell(14);
                Fpdf::Cell(25, 5, 'CHAVDA BHAI. ', '', 0, 'C');
                Fpdf::Cell(14);
                Fpdf::Cell(24, 5, 'HASHMUKH BHAI. ', '', 0, 'C');
                Fpdf::Cell(14);
                Fpdf::Cell(25, 5, 'DHAVAL BHAI. ', '', 0, 'C');
                Fpdf::Cell(14);
                Fpdf::Cell(25, 5, 'NILESH BHAI. ', '', 0, 'C');
                Fpdf::Ln();

            } else {
                if ($row->category_id == 4) {
                    Fpdf::Cell(14);
                    Fpdf::Cell(25, 5, 'CHHAGAN BHAI. ', '', 0, 'C');
                    Fpdf::Cell(14);
                    Fpdf::Cell(24, 5, 'BIREN BHAI. ', '', 0, 'C');
                    Fpdf::Cell(14);
                    Fpdf::Cell(25, 5, 'NILESH BHAI. ', '', 0, 'C');
                    Fpdf::Ln();
                } else {
                    if ($row->category_id == 5) {
                        Fpdf::Cell(40);
                        Fpdf::Cell(25, 5, 'PARESH BHAI. ', '', 0, 'C');
                        Fpdf::Cell(10);
                        Fpdf::Cell(25, 5, 'MOHIT BHAI. ', '', 0, 'C');
                        Fpdf::Cell(14);
                        Fpdf::Cell(25, 5, 'NILESH BHAI. ', '', 0, 'C');
                    } else {
                        Fpdf::Cell(25, 5, 'GAUTAM BHAI ', '', 0, 'C');
                        Fpdf::Cell(5);
                        Fpdf::Cell(25, 5, 'PRIYANK BHAI ', '', 0, 'C');
                        Fpdf::Cell(14);
                        Fpdf::Cell(25, 5, 'MOHAN BHAI. ', '', 0, 'C');
                        Fpdf::Cell(14);
                        Fpdf::Cell(25, 5, 'SAVJI BHAI. ', '', 0, 'C');
                        Fpdf::Cell(14);
                        Fpdf::Cell(25, 5, 'NILESH BHAI. ', '', 0, 'C');
                    }
                }
            }
        }
        if (!empty($spare_item[0]->category_id) == 9) {
            Fpdf::AliasNbPages();
            Fpdf::AddPage();
            Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
            Fpdf::AddFont('Verdana', '', 'Verdana.php');
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::SetAutoPageBreak(true);

            Fpdf::Cell(190, 5, $company_name->company_name, 0, 1, 'C');
            Fpdf::Cell(190, 5, 'INSPECTION REPORT', 0, 0, 'C');
            Fpdf::Ln();
            Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

            if ($result->branch_id == 1) {
                $complains_no = 'PF-TKT/' . $result->fyear . '/' . $result->complain_no;
            } elseif ($result->branch_id == 3) {
                $complains_no = 'TE-TKT/' . $result->fyear . '/' . $result->complain_no;
            } elseif ($result->branch_id == 4) {
                $complains_no = 'TP-TKT/' . $result->fyear . '/' . $result->complain_no;
            }
            Fpdf::SetWidths(array(95, 95));
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::SetWidths(array(121, 44));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Cell(17, 5, 'REF. NO :- ', '', 0, 'L');
            Fpdf::Cell(180, 5, $complains_no, 'B', 0, 'L');
            Fpdf::Ln(7);
            Fpdf::Cell(26, 5, 'PARTY NAME :-', '', 0, 'L');
            Fpdf::Cell(171, 5, $client_name, 'B', 0, 'L');
            Fpdf::Ln(7);
            Fpdf::Cell(12, 5, 'CITY :-', '', 0, 'L');
            Fpdf::Cell(55, 5, $city, 'B', 0, 'L');
            Fpdf::Cell(21, 5, 'DISTRICT :-', '', 0, 'L');
            Fpdf::Cell(48, 5, $district, 'B', 0, 'L');
            Fpdf::Cell(15, 5, 'STATE :-', '', 0, 'L');
            Fpdf::Cell(45, 5, $state, 'B', 0, 'L');

            if ($result->branch_id == 1) {
                $challan_no = 'PF-CH/' . $result->fyear . '/' . $result->challan_no;
            } elseif ($result->branch_id == 3) {
                $challan_no = 'TE-CH/' . $result->fyear . '/' . $result->challan_no;
            } elseif ($result->branch_id == 4) {
                $challan_no = 'TP-CH/' . $result->fyear . '/' . $result->challan_no;
            }
            Fpdf::Ln(7);
            Fpdf::Cell(26, 5, 'CHALLAN NO :- ', '', 0, 'L');
            Fpdf::Cell(41, 5, $challan_no, 'B', 0, 'L');
            Fpdf::Cell(30, 5, 'CHALLAN DATE :- ', '', 0, 'L');
            Fpdf::Cell(39, 5, date("d-m-Y", strtotime($result->created_at)), 'B', 0, 'L');
            Fpdf::Cell(32, 5, 'REPAIRED DATE :- ', '', 0, 'L');
            Fpdf::Cell(28, 5, '', 'B', 0, 'L');
            Fpdf::Ln(7);
            Fpdf::Cell(33, 5, 'MECHANIC NAME :-', '', 0, 'L');
            Fpdf::Cell(165, 5, '', 'B', 0, 'L');
            Fpdf::Ln(7);
            Fpdf::Cell(35, 5, 'PARTY COMPLAINT :- ', '', 0, 'L');
            Fpdf::Cell(163, 5, '', 'B', 0, 'L');
            Fpdf::Ln(6);
            Fpdf::Cell(198, 5, '', 'B', 0, 'L');
            Fpdf::Ln(6);
            Fpdf::Cell(198, 5, '', 'B', 0, 'L');
            Fpdf::Ln(6);
            Fpdf::Cell(198, 5, '', 'B', 0, 'L');


            Fpdf::Ln(10);
            Fpdf::SetWidths(array(33, 30, 30, 36, 50, 20));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('MODEL', 'SERIAL NO', "PARTS", 'COMPLAIN', 'CO.OBSERVATION', 'CHANGE (Y/N)'),
                array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
            $sp_count = 1;

            foreach ($spare_item as $row) {
                Fpdf::Row(array(
                    $row->getProduct->product_name,
                    $row->serial_no,
//                        ($ss['product_id'] == 27869) ? $ss['description'] : $ss['spare_name'],
                    '',
//                        $row->getInspectionReport[0]->complain,
//                        $row->getInspectionReport[0]->observation,
//                        $row->getInspectionReport[0]->part_change,
                    '', '', ''
                ), array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true, 7);
                $sp_count++;
            }
            for ($k = $sp_count; $k <= 22; $k++) {
                Fpdf::Row(array('', '', '', '', '', ''), array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true, 7);
            }
            Fpdf::Ln(5);
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::SetWidths(array(95, 95));
            Fpdf::Cell(18, 5, 'FAULT :-', '', 0, 'L');
            Fpdf::Cell(49, 5, '', 'B', 0, 'L');
            Fpdf::Cell(85, 5, 'CHECKED BY :-', '', 0, 'R');
            Fpdf::Cell(45, 5, '', 'B', 0, 'L');
            Fpdf::Ln(10);
            Fpdf::Cell(45, 5, 'COMPANY OBSERVATION :- ', '', 0, 'L');
            Fpdf::CellFitScale(151, 5, '', 'B', 0, 'L');
            Fpdf::Ln(18);


            Fpdf::Cell(5);
            Fpdf::Cell(25, 5, 'GAUTAM BHAI. ', '', 0, 'C');
            Fpdf::Cell(5);
            Fpdf::Cell(25, 5, 'PRIYANK BHAI. ', '', 0, 'C');
            Fpdf::Cell(14);
            Fpdf::Cell(25, 5, 'MOHAN BHAI. ', '', 0, 'C');
            Fpdf::Cell(14);
            Fpdf::Cell(25, 5, 'SAVJI BHAI. ', '', 0, 'C');
            Fpdf::Cell(14);
            Fpdf::Cell(25, 5, 'NILESH BHAI. ', '', 0, 'C');
            Fpdf::Ln();
        }
    }

    public static function engineTestingReport($challan_id)
    {
        $Challan_testing = DB::table('challan_testing_master')
            ->select('topland.product_master.product_name', 'challan_item_master.*', 'engine_testing.*', 'challan_testing_master.*', 'generator_testing.*', 'welding_generator_testing.*', 'borewell_testing.*', 'company_master.company_name')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'challan_testing_master.challan_product_id')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->leftJoin('engine_testing', 'engine_testing.challan_testing_id', '=', 'challan_testing_master.challan_testing_id')
            ->leftJoin('generator_testing', 'generator_testing.challan_testing_id', '=', 'challan_testing_master.challan_testing_id')
            ->leftJoin('welding_generator_testing', 'welding_generator_testing.challan_testing_id', '=', 'challan_testing_master.challan_testing_id')
            ->leftJoin('borewell_testing', 'borewell_testing.challan_testing_id', '=', 'challan_testing_master.challan_testing_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'challan_testing_master.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('challan_testing_master.challan_id', '=', $challan_id)
            ->get();
        if (empty($Challan_testing[0]->complain_product_id)) {
            return redirect('challan');
        }

        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 14);
        Fpdf::SetAutoPageBreak(true);

        Fpdf::SetFont('Verdana', '', 10);
        Fpdf::Cell(190, 5, $Challan_testing[0]->company_name, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::Cell(190, 5, 'TESTING REPORT', 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana', '', 9);
        Fpdf::SetWidths(array(90, 100));
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);
        foreach ($Challan_testing as $engine) {
            if (!empty($engine)) {
                if ($engine->category_id === 1 || $engine->category_id === 3) {
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(30, 5, 'PRODUCT NAME :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(160, 5, $engine->product_name, 'B', 0, 'L');
                    Fpdf::Ln(7);
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(31, 5, 'CHECKING DATE :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(31, 5, date("d-m-Y", strtotime($engine->checking_date)), 'B', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(25, 5, 'SERIAL NO :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(25, 5, $engine->serial_no, 'B', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(31, 5, 'TESTING BY :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(47, 5, strtoupper($engine->testing_by), 'B', 0, 'L');
                    Fpdf::Ln(5);
                    Fpdf::SetFont('Verdana-Bold', 'B', 10);
                    Fpdf::SetWidths(array(31, 32, 31, 32, 32, 32));
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);

                    Fpdf::Row(array('Reading', 'S.F.C', "Temp.RPM", 'Temp%', 'Perm RPM', 'Perm%'), array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Row(array($engine->reading, $engine->sfc, $engine->temp_rpm, $engine->temp_percentage, $engine->perm_rpm, $engine->perm_percentage),
                        array('C', 'C', 'C', 'C', 'C', 'C'), '',
                        array(), true);
                    Fpdf::Ln();
                } elseif ($engine->category_id === 8) {
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(30, 5, 'PRODUCT NAME :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(160, 5, $engine->product_name, 'B', 0, 'L');
                    Fpdf::Ln(7);
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(31, 5, 'CHECKING DATE :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(31, 5, date("d-m-Y", strtotime($engine->checking_date)), 'B', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(25, 5, 'SERIAL NO :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(25, 5, $engine->serial_no, 'B', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(31, 5, 'TESTING BY :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(47, 5, strtoupper($engine->testing_by), 'B', 0, 'L');
                    Fpdf::Ln(10);

                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array('AC Voltage(N.L)', 'DC Voltage(N.L) ', "DC Amp(N.L)", 'RPM(N.L) ', 'AC Voltage(I.F.L)', 'AC Voltage(R.F.L)'),
                        array('L', 'L', 'L', 'L', 'L', 'L'), '', array(), true);
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Row(array($engine->ac_voltage, $engine->dc_voltage_nl, $engine->dc_amp_nl, $engine->rpm_nl, $engine->ac_voltage_ifl, $engine->ac_voltage_rfl),
                        array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array('AC Voltage(0.8PF 10%OL)', 'AC Amp(0.8 P.F.L)', 'Watts(0.8 P.F.L)', 'DC Voltage(0.8 P.F.L) ', 'DC Amp(0.8 P.F.L)', 'RPM(0.8 P.F.L)'),
                        array('L', 'L', 'L', 'L', 'L', 'L'), '', array(), true);
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Row(array($engine->ac_voltage_pf, $engine->ac_amp_pfl, $engine->watts, $engine->dc_voltage_fl, $engine->dc_amp_fl, $engine->rpm_fl),
                        array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array('Amount Temp. C', 'Stator Main Winding', 'Stator Aux Winding ', 'Ex Fld/C Wng Resistance in', 'Ex Arm/L Wng Resistance in', 'AC Voltage(0.8 P.F.L)'),
                        array('L', 'L', 'L', 'L', 'L', 'L'), '', array(), true);
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Row(array($engine->amount_temp, $engine->stator_main_winding, $engine->stator_aux_winding, $engine->ex_fld_wnd_regi, $engine->ex_arm_wnd_regi, $engine->ac_voltage_pfl),
                        array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array('AC Amp(10% OL)AVR "O" Pot Set', 'R.F.L', 'V.R.%(I.F.L)', 'Rotor Winding Resistance in ', 'Brand ', ''),
                        array('L', 'L', 'L', 'L', 'L', 'L'), '', array(), true);
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Row(array($engine->ac_amp_ol, $engine->rfl, $engine->vr_ifl, $engine->regi, $engine->kbl, ''),
                        array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
                    Fpdf::Ln();
                } elseif ($engine->category_id === 5) {
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(30, 5, 'PRODUCT NAME :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(160, 5, $engine->product_name, 'B', 0, 'L');
                    Fpdf::Ln(7);
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(31, 5, 'CHECKING DATE :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(31, 5, date("d-m-Y", strtotime($engine->checking_date)), 'B', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(25, 5, 'SERIAL NO :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(25, 5, $engine->serial_no, 'B', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(31, 5, 'TESTING BY :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(47, 5, strtoupper($engine->testing_by), 'B', 0, 'L');
                    Fpdf::Ln(10);
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);

                    Fpdf::SetWidths(array(60, 137));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array('NAME OF COMPONENTS', "TESTING CRITERIA"),
                        array('C', 'C'), '', array(), true);
                    Fpdf::Cell(60, 8, 'TEMPERATURE', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(137, 8, $engine->temperature, true, 0, 'L');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 8, 'VOLTAGE', true, 0, 'C');
                    Fpdf::Cell(42, 4, 'LOW', true, 0, 'C');
                    Fpdf::Cell(47, 4, 'HIGH', true, 0, 'C');
                    Fpdf::Cell(48, 4, 'LIGHTING', true, 1, 'C');
                    Fpdf::Cell(60);
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(42, 4, $engine->voltage_low, true, 0, 'C');
                    Fpdf::CellFitScale(47, 4, $engine->voltage_high, true, 0, 'C');
                    Fpdf::CellFitScale(48, 4, $engine->voltage_lighting, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'NO LOAD', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(19, 5, $engine->no_load1, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->no_load2, true, 0, 'C');
                    Fpdf::CellFitScale(19, 5, $engine->no_load3, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->no_load4, true, 0, 'C');
                    Fpdf::CellFitScale(19, 5, $engine->no_load5, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->no_load6, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->no_load7, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'RESISTIVE LOAD', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(19, 5, $engine->resistive_load1, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->resistive_load2, true, 0, 'C');
                    Fpdf::CellFitScale(19, 5, $engine->resistive_load3, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->resistive_load4, true, 0, 'C');
                    Fpdf::CellFitScale(19, 5, $engine->resistive_load5, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->resistive_load6, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->resistive_load7, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'WELDING LOW', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(19, 5, $engine->welding_low1, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->welding_low2, true, 0, 'C');
                    Fpdf::CellFitScale(19, 5, $engine->welding_low3, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->welding_low4, true, 0, 'C');
                    Fpdf::CellFitScale(19, 5, $engine->welding_low5, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->welding_low6, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->welding_low7, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'WELDING HIGH', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(19, 5, $engine->welding_high1, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->welding_high2, true, 0, 'C');
                    Fpdf::CellFitScale(19, 5, $engine->welding_high3, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->welding_high4, true, 0, 'C');
                    Fpdf::CellFitScale(19, 5, $engine->welding_high5, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->welding_high6, true, 0, 'C');
                    Fpdf::CellFitScale(20, 5, $engine->welding_high7, true, 0, 'C');
                    Fpdf::Ln(10);
                } else {
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(30, 5, 'PRODUCT NAME :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(160, 5, $engine->product_name, 'B', 0, 'L');
                    Fpdf::Ln(7);
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(31, 5, 'CHECKING DATE :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(31, 5, date("d-m-Y", strtotime($engine->checking_date)), 'B', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(25, 5, 'SERIAL NO :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(25, 5, $engine->serial_no, 'B', 0, 'L');
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(31, 5, 'TESTING BY :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(47, 5, strtoupper($engine->testing_by), 'B', 0, 'L');
                    Fpdf::Ln(10);

                    Fpdf::SetWidths(array(60, 137));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array('NAME OF COMPONENTS', "TESTING CRITERIA"),
                        array('C', 'C'), '', array(), true);
                    Fpdf::Cell(60, 5, 'VOLTAGE', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->voltage1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->voltage2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->voltage3, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'N.L AMP', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->nl_amp1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->nl_amp2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->nl_amp3, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'S/0 HEAD', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->so_head1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->so_head2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->so_head3, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'Max. Amp', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->max_amp1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->max_amp2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->max_amp3, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'HZ', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->hz1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->hz2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->hz3, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'PF', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->pf1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->pf2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->pf3, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'KW', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->kw1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->kw2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->kw3, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'D.P AMP', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->dp_amp1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->dp_amp2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->dp_amp3, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'D.P HEAD', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->dp_head1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->dp_head2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->dp_head3, true, 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(60, 5, 'DISCH', true, 0, 'C');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::CellFitScale(45, 5, $engine->disch1, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->disch2, true, 0, 'C');
                    Fpdf::CellFitScale(46, 5, $engine->disch3, true, 0, 'C');
                    Fpdf::Ln(7);
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Cell(20, 5, 'REMARK :-', '', 0, 'L');
                    Fpdf::SetFont('Verdana', '', 8);
                    Fpdf::Cell(160, 5, $engine->remark, 'B', 0, 'L');
                    Fpdf::Ln(10);
                }
            }
        }
    }

    public static function CGSTReport($invoice_id)
    {
        $order_list = DB::table('invoice')
            ->select('invoice.*', 'challan.challan_id', 'challan.challan_no as challan_rno', 'complain.complain_no', 'complain.created_at as date', 'challan.created_at', 'challan.change_bill_address as billing_change', 'invoice.lr_no', 'invoice.lr_date', 'billty.client_id', 'topland.transport_master.transport_name',
                DB::raw('ifnull((select sum(accessories_qty) from challan_accessories
                WHERE challan_accessories.challan_id = invoice.challan_id),0) as acce_qunt'), 'users.name', 'users.company_id', 'invoice_items.challan_product_id', 'challan.change_bill_address', 'challan.created_at as challan_date',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = invoice.financial_id) as fyear"),
                'billty.lr_no as billty_lr_no', 'billty.lr_date as billty_lr_date',
                DB::raw("(select transport_name from topland.transport_master as p WHERE p.transport_id = billty.transport_id) as billty_transport_nme"))
            ->leftJoin('challan', 'challan.challan_id', '=', 'invoice.challan_id')
            ->leftJoin('billty', 'challan.billty_id', '=', 'billty.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'invoice.transport_id')
            ->leftJoin('users', 'users.user_id', '=', 'invoice.created_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'users.company_id')
            ->leftJoin('invoice_items', 'invoice_items.invoice_id', '=', 'invoice.invoice_id')
            ->where('invoice.invoice_id', '=', $invoice_id)
            ->get();

        $company = DB::table('company_master')
            ->select('company_master.*', 'topland.city_master.city_name', 'topland.district_master.district_name', 'branch_master.*', 'topland.state_master.state_name', 'topland.godown_master.gst')
            ->leftJoin('topland.city_master', 'company_master.city_id', '=', 'topland.city_master.city_id')
            ->leftJoin('topland.district_master', 'company_master.district_id', '=', 'topland.district_master.district_id')
            ->leftJoin('topland.state_master', 'company_master.state_id', '=', 'topland.state_master.state_id')
            ->leftJoin('topland.godown_master', 'company_master.company_id', '=', 'topland.godown_master.company_id')
            ->join('branch_master', 'branch_master.company_id', '=', 'company_master.company_id')
            ->where('company_master.company_id', '=', $order_list[0]->company_id)
            ->get();
        $item_lis = DB::table('invoice_items')
            ->select('challan_item_master.challan_product_id', DB::raw("(select product_name from topland.product_master as p WHERE p.product_id = complain_item_details.product_id) as challan_product_name"),
                'topland.category_master.category_name', 'topland.brand_master.brand_name', DB::raw('challan_item_master.quantity as quantity'),
                'challan_item_master.packing_type', 'challan_item_master.serial_no as from_sr', 'topland.product_master.*',
                'challan_item_master.product_charge', 'challan_item_master.complain_product_id', 'topland.product_master.cetsh_hsn as cetsh_hsn')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'invoice_items.challan_product_id')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'challan_item_master.category_id')
            ->leftJoin('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('invoice_items.invoice_id', '=', $invoice_id)
            ->where('invoice_items.type', '=', 'product');

        $sp_item_lis = DB::table('invoice_items')
            ->select('challan_item_master.challan_product_id', DB::raw("(select product_name from topland.product_master as p WHERE p.product_id = complain_item_details.product_id) as challan_product_name"),
                'topland.category_master.category_name', 'topland.brand_master.brand_name', 'challan_optional.qty as quantity',
                'challan_item_master.packing_type', 'challan_item_master.serial_no as from_sr', 'topland.product_master.*',
                'challan_item_master.product_charge', 'challan_item_master.complain_product_id', 'topland.product_master.cetsh_hsn as cetsh_hsn')
            ->leftJoin('challan_optional', 'challan_optional.challan_optional_id', '=', 'invoice_items.challan_product_id')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'challan_optional.challan_product_id')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'challan_item_master.category_id')
            ->leftJoin('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_optional.product_id')
            ->where('invoice_items.invoice_id', '=', $invoice_id)
            ->where('invoice_items.type', '=', 'spare');

        $final = $item_lis->union($sp_item_lis)->orderBY('brand_name')->orderBY('category_name')->orderBY('packing_type')->get();
        $item_lis = json_decode(json_encode($final), true);

        if (empty($final[0]->product_id)) {
            return redirect('invoice');
        }

        $orderLists = DB::table('challan')
            ->select('invoice.client_name as name_of_client', 'invoice.*', 'challan.*', 'complain.*', 'topland.client_master.pincode',
                'topland.client_master.email as e_address', 'complain.mobile as contact_no', 'topland.client_master.gst_no', 'complain.complain_gst as gst_a',
                'topland.transport_master.*', 'topland.city_master.city_name', 'topland.district_master.district_name', 'topland.state_master.state_name')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('invoice', 'invoice.challan_id', '=', 'challan.challan_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'billty.transport_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.client_master', 'topland.client_master.client_id', '=', 'complain.client_id')
            ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('invoice.challan_id', $order_list[0]->challan_id)
            ->first();

        $client_name = $address1 = $address2 = $address3 = $city = $district = $state = $gst = '';
        if ($orderLists->change_bill_address == 'Y') {
            $client_name = strtoupper($orderLists->billing_name);
            $address = strtoupper($orderLists->address1) . "\n" . strtoupper($orderLists->address2) . "\n" . strtoupper($orderLists->address3);
            $city = strtoupper($orderLists->city_name);
            $district = strtoupper($orderLists->district_name);
            $state = strtoupper($orderLists->state_name);
            $gst = strtoupper(isset($orderLists->gst_a) ? $orderLists->gst_a : '');
            $pincode = strtoupper(isset($orderLists->pincode) ? $orderLists->pincode : '');
            $mobile = strtoupper(isset($orderLists->contact_no) ? $orderLists->contact_no : '');
            $e_address = strtoupper(isset($orderLists->e_address) ? $orderLists->e_address : '');
        } else {
            $client_name = strtoupper($orderLists->name_of_client);
            $address = strtoupper($orderLists->address);
            $city = strtoupper($orderLists->city_name);
            $district = strtoupper($orderLists->district_name);
            $state = strtoupper($orderLists->state_name);
            $gst = strtoupper(isset($orderLists->gst_a) ? $orderLists->gst_a : '');
            $pincode = strtoupper(isset($orderLists->pincode) ? $orderLists->pincode : '');
            $mobile = strtoupper(isset($orderLists->contact_no) ? $orderLists->contact_no : '');
            $e_address = strtoupper(isset($orderLists->e_address) ? $orderLists->e_address : '');

        }

        $total_rows = 21;

        $pdf = new FPDF('P', 'mm', 'A4');
        $quantity = 0;
        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana-Bold', 'B', 12);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

        Fpdf::Ln();

        Fpdf::SetWidths(array(10, 10, 10));
        Fpdf::SetFont('Verdana', '', 10);
        Fpdf::Cell(190, 5, $company[0]->company_name, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::Cell(190, 5, 'DELIVERY CHALLAN OUT', 0, 0, 'C');
        Fpdf::SetFont('Verdana', '', 8);

        if ($order_list[0]->branch_id == 1) {
            $invoice_no = 'PF-INV/' . $order_list[0]->fyear . '/' . $order_list[0]->invoice_no;
        } elseif ($order_list[0]->branch_id == 3) {
            $invoice_no = 'TE-INV/' . $order_list[0]->fyear . '/' . $order_list[0]->invoice_no;
        } elseif ($order_list[0]->branch_id == 4) {
            $invoice_no = 'TP-INV/' . $order_list[0]->fyear . '/' . $order_list[0]->invoice_no;
        }
        Fpdf::Ln();
        Fpdf::Cell(130, 5, 'Subject to RAJKOT Jurisdiction', 0, 0);
        Fpdf::Cell(62, 5, 'ORIGINAL DUPLICATE TRIPLICATE EXTRA', 0, 0);
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(97, 4, 'Consigner', 'TRL', 0);
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Cell(50, 4, 'Inv No : ' . $invoice_no, 1, 0, 'L');
        Fpdf::Cell(47, 4, 'Date : ' . date("d-m-Y", strtotime($order_list[0]->invoice_date)), 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, trim($company[0]->company_name), 'RL', 0);
        Fpdf::Cell(50, 4, 'Transport : ', 1, 0, 'L');
        Fpdf::Cell(47, 4, $order_list[0]->transport_name, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company[0]->address1, 'RL', 0);

        Fpdf::Cell(50, 4, 'LR No : ' . $order_list[0]->lr_no, 1, 0, 'L');
        Fpdf::Cell(47, 4, 'LR Date : ' . date("d-m-Y", strtotime($order_list[0]->lr_date)), 1, 0, 'L');

        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company[0]->address2 . ' ' . $company[0]->address3, 'RL', 0);

        Fpdf::Cell(50, 4, '', 1, 0, 'L');
        Fpdf::Cell(47, 4, '', 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4,
            $company[0]->city_name . '-' . $company[0]->pincode . ' Dist:' . $company[0]->district_name . ' State.' . $company[0]->state_name,
            'RL', 0);
        Fpdf::Cell(50, 4, 'Lorry No :', 1, 0, 'L');
        Fpdf::Cell(47, 4, strtoupper($order_list[0]->lory_no), 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, 'Ph.:' . $company[0]->phone, 'RL', 0);
        if ($order_list[0]->branch_id == 1) {
            $challan_rno = 'PF-CH/' . $order_list[0]->fyear . '/' . $order_list[0]->challan_rno;
        } elseif ($order_list[0]->branch_id == 3) {
            $challan_rno = 'TE-CH/' . $order_list[0]->fyear . '/' . $order_list[0]->challan_rno;
        } elseif ($order_list[0]->branch_id == 4) {
            $challan_rno = 'TP-CH/' . $order_list[0]->fyear . '/' . $order_list[0]->challan_rno;
        }
        Fpdf::Cell(50, 4, 'Ch No : ' . $challan_rno, 1, 0, 'L');
        Fpdf::Cell(47, 4, 'Ch Date : ' . date("d-m-Y", strtotime($order_list[0]->created_at)), 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, 'GSTN .:' . $company[0]->gst_no, 'RL', 0);
        Fpdf::Cell(50, 4, '', 1, 0, 'L');
        Fpdf::Cell(47, 4, '', 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, '', 'RLB', 0);
        Fpdf::Cell(50, 4, '', 1, 0, 'L');
        Fpdf::Cell(47, 4, '', 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(97, 4, 'Billing Address', 'TRL', 0);
        Fpdf::Cell(97, 4, 'Remarks:', 'TRL', 0, 'L');
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Ln();

        Fpdf::SetWidths(array(97, 97));
        Fpdf::SetFont('Verdana-Bold', 'B', 9);

        /** print address */
        $part1 = strtoupper($client_name) . "\n" . strtoupper($address) . "\n" . 'GSTN: ' . $gst . "\n" . 'City: ' . trim($city) . "\n"
            . 'District: ' . trim($district) . "\n" . 'State: ' . trim($state) . "\n" . 'PinCode: ' . trim($pincode) . "\n" . 'Contact No: ' . trim($mobile) . "\n" . 'E-Mail: ' . trim($e_address);
        $part2 = (empty($order_list[0]->remark) ? '' : $order_list[0]->remark . '') . "\n" . "*** RETURN AFTER REPAIRING NOT FOR SALE HAVING NO. COMM. VALUE ***";


        Fpdf::Row(array($part1, $part2), array('L', 'L'), '', array('', 'B'), true);

        if ($order_list[0]->change_develiry_address == 'Y') {

            $client_address_data_change_delivery = DB::table('invoice')
                ->select('invoice.billing_name as client_name', 'invoice.address1', 'invoice.address2', 'invoice.address3', 'topland.city_master.city_name', 'topland.district_master.district_name', 'topland.state_master.state_name', 'invoice.gst_no')
                ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'invoice.city_id')
                ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'city_master.district_id')
                ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'district_master.state_id')
                ->where('invoice.invoice_id', '=', $invoice_id)
                ->get();
            Fpdf::SetWidths(array(194));
            Fpdf::Row(array('DELIVERY AT : ' . strtoupper($client_address_data_change_delivery[0]->client_name) . "\n" . 'ADDRESS : ' . strtoupper($client_address_data_change_delivery[0]->address1) . " " . strtoupper($client_address_data_change_delivery[0]->address2) . " " . strtoupper($client_address_data_change_delivery[0]->address3) . " " . 'CITY: ' . strtoupper($client_address_data_change_delivery[0]->city_name) . " " . 'DISTRICT: ' . strtoupper($client_address_data_change_delivery[0]->district_name) . " " . 'STATE: ' . strtoupper($client_address_data_change_delivery[0]->state_name . "\n" . 'GSTIN : ' . strtoupper($client_address_data_change_delivery[0]->gst_no))),
                array('L'), '', array(''), true);
        }

        Fpdf::SetWidths(array(80, 114));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array(
            'GOODS RECEIVED FOR REPAIRING THROUGH ',
            $order_list[0]->billty_transport_nme . ' / LR No.' . $order_list[0]->billty_lr_no . ' LR Date. : ' . date("d-m-Y",
                strtotime($order_list[0]->billty_lr_date))
        ), array('C', 'C'), '', array(), true);

        $temp = 0;
        Fpdf::SetFont('Verdana-Bold', 'B', 8);

        Fpdf::SetWidths(array(15, 76, 50, 15));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetFont('Verdana', '', 8);

        Fpdf::SetWidths(array(10, 50, 20, 10));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetWidths(array(5, 7, 50, 15, 20, 26));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(10, 6, 'No', 'TL', 0, 'C');
        Fpdf::Cell(74, 6, 'Description of Goods / Services', 'TL', 0, 'C');
        Fpdf::Cell(20, 6, 'HSN', 'TL', 0, 'C');
        Fpdf::Cell(10, 6, 'Qty', 'TL', 0, 'C');
        Fpdf::Cell(20, 6, 'Rate', 'TL', 0, 'C');
        Fpdf::Cell(19, 6, 'SGST (%)', 'TLR', 0, 'C');
        Fpdf::Cell(19, 6, 'CGST (%)', 'TLR', 0, 'C');
        Fpdf::Cell(22, 6, 'Total', 'TLR', 0, 'C');
        Fpdf::Ln();
        Fpdf::SetWidths(array(10, 74, 20, 10, 20, 19, 19, 22));
        Fpdf::SetFont('Verdana', '', 9);
        $lasttotal_qty = 0;

        if (!empty($item_lis)) {
            $temp = 1;
//            $charge = 0;
            $header_string = "";
            $lasttotal_total = 0;
            $lasttotal_sgst = 0;
            $lasttotal_cgst = 0;
            $lasttotal_finaltotal = 0;
            $allArray = array();
            foreach ($item_lis as $row) {
                $category_id = $row['category_id'];
                $complain_product_id = $row['complain_product_id'];
                $product_data = DB::table('challan_item_master')
                    ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
                    ->leftJoin('topland.new_single_price_list', 'topland.new_single_price_list.product_id', '=', 'complain_item_details.product_id')
                    ->where('complain_item_details.cid_id', '=', $complain_product_id)
                    ->where('topland.new_single_price_list.price_date', '=', '2017-07-01')
                    ->get();
                $new_header_string = strtoupper($row['brand_name'] . " " . $row['category_name'] . " " . $row['packing_type']);

                if ($header_string != $new_header_string) {
                    Fpdf::SetWidths(array(194));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array($new_header_string), array('C'), '', '', true);
                    $header_string = $new_header_string;
                    Fpdf::SetWidths(array(10, 74, 20, 10, 20, 19, 19, 22));
                    $total_rows -= 1;
                }

                $opt_item = '';
                $challan_product_id = $row['challan_product_id'];
                $optional = DB::table('challan_optional')
                    ->select('topland.product_master.product_name', 'challan_optional.optional_status')
                    ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_optional.product_id')
                    ->where('challan_optional.challan_product_id', '=', $challan_product_id)
                    ->where('challan_optional.optional_status', '!=', 'Spare')
                    ->get();

                foreach ($optional as $add) {
                    if ($add->optional_status == 'Add') {
                        $opt_item .= "\n(+)" . $add->product_name;
                    } elseif ($add->optional_status == 'Remove') {
                        $opt_item .= "\n(-)" . $add->product_name;
                    }
                    $total_rows -= 1;
                }
                if ($row['packing_type'] == 'loose') {
                    $product_price = $product_data[0]->loose_price;
                } elseif ($row['packing_type'] == 'packing') {
                    $product_price = $product_data[0]->packing_price;
                } else {
                    $product_price = $product_data[0]->skd_price;
                }
                Fpdf::SetFont('Verdana', '', 8);
                $total = $product_price * $row['quantity'];
                $sgst = $row['sgst_rate'];
                $sgst_total = $product_price * $sgst / 100;
                $cgst = $row['cgst_rate'];
                $cgst_total = $product_price * $cgst / 100;
                $finaltotal = $total;
                $lasttotal_qty = $lasttotal_qty + $row['quantity'];
                $lasttotal_total = $lasttotal_total + $total;
                $lasttotal_sgst = $lasttotal_sgst + $sgst_total;
                $lasttotal_cgst = $lasttotal_cgst + $cgst_total;
                $lasttotal_finaltotal = $lasttotal_finaltotal + $finaltotal;
//                $product_charges = $row['product_charge'];
//                $charge += $product_charges;
                if (!empty($row['from_sr'])) {
                    $ser = ' (' . $row['from_sr'] . ')';
                } else {
                    $ser = '';
                }
                if (!empty($row['challan_product_name'])) {
                    $product_name = '(' . $row['challan_product_name'] . ')';
                } else {
                    $product_name = '';
                }
                Fpdf::Row(array(
                    $temp,
                    $row['product_name'] . $product_name . $ser . $opt_item,
                    $row['cetsh_hsn'],
                    $row['quantity'],
                    $product_price,
                    $row['sgst_rate'] . '%',
                    $row['cgst_rate'] . '%',
//                    $row['product_charge'],
                    number_format($finaltotal, 2)
                ),
                    array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
                array_push($allArray, array('hsn' => $row['cetsh_hsn'], 'qty' => $row['quantity'], 'price' => $finaltotal, 'cgst' => $row['cgst_rate'], 'sgst' => $row['sgst_rate']));
                $temp++;
                $quantity += $row['quantity'];
                $total_rows -= 1;
            }


            $price = array();
            foreach ($allArray as $key => $r) {
                $price[$key] = $r['hsn'];
            }
            array_multisort($price, SORT_ASC, $allArray);
            $arrayLength = sizeof($allArray);
            $newArray = [];
            array_push($newArray, array('hsn' => $allArray[0]['hsn'], 'qty' => $allArray[0]['qty'], 'price' => $allArray[0]['price'], 'cgst' => $allArray[0]['cgst'], 'sgst' => $allArray[0]['sgst']));

            for ($i = 1; $i < $arrayLength; $i++) {
                $lastValue = end($newArray);
                if ($allArray[$i]['hsn'] == $lastValue['hsn']) {
                    if ($allArray[$i]['cgst'] == $lastValue['cgst']) {
                        $priceWithQty = $allArray[$i]['price'];
                        $newPrice = $priceWithQty + $lastValue['price'];
                        $newQty = $allArray[$i]['qty'] + $lastValue['qty'];
                        array_pop($newArray);
                        if ($allArray[$i]['qty'] > 1) {
                            array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $newQty, 'price' => $newPrice, 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                        } else {
                            array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $newQty, 'price' => $newPrice, 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                        }
                    } else {
                        array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $allArray[$i]['qty'], 'price' => $allArray[$i]['price'], 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                    }
                } else {
                    array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $allArray[$i]['qty'], 'price' => $allArray[$i]['price'], 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                }
            }

            $noto = $quantity + $order_list[0]->acce_qunt;
        }
        if ($order_list[0]->view_accessories == 'Y') {
            $dagina = DB::table('challan_accessories')
                ->select(DB::raw("SUM(accessories_qty) as total_dagina"))
                ->where('challan_accessories.challan_id', '=', $order_list[0]->challan_id)
                ->get();
        } else {
            $dagina[0]['total_dagina'] = 0;
        }

//       Fpdf::SetFont('Verdana-Bold', 'B', 9);
        for ($s = 1; $s <= $total_rows; $s++) {
            Fpdf::Cell(10, 5, '', 'L', 0, 'C');
            Fpdf::Cell(74, 5, '', 'L', 0, 'C');
            Fpdf::Cell(20, 5, '', 'L', 0, 'C');
            Fpdf::Cell(10, 5, '', 'L', 0, 'C');
            Fpdf::Cell(20, 5, '', 'L', 0, 'C');
            Fpdf::Cell(19, 5, '', 'L', 0, 'C');
            Fpdf::Cell(19, 5, '', 'L', 0, 'C');
//            Fpdf::Cell(17, 5, '', 'L', 0, 'C');
            Fpdf::Cell(22, 5, '', 'LR', 1, 'C');

        }
        Fpdf::Row(array(
            '',
            'Total',
            '',
            $lasttotal_qty,
            '',
            '',
            '',
            number_format($lasttotal_finaltotal, 2)
        ),
            array('C', 'L', 'C', 'C', 'C', 'C', 'L', 'C'), '', '', true);
        $round_off = abs(round($lasttotal_finaltotal) - $lasttotal_finaltotal);
        Fpdf::SetWidths(array(30, 44, 25, 35, 25, 35));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array(
            'HSN',
            'Taxable Value',
            'SGST (%)',
            'SGST Value',
            'CGST (%)',
            'CGST Value '
        ),
            array('C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
        Fpdf::SetFont('Verdana', '', 9);
        $taxTotal = 0;
        $sgstTotal = 0;
        $cgstTotal = 0;
        foreach ($newArray as $key => $value) {
            $totalGst = $value['cgst'] + $value['sgst'];
            $price = $value['price'];
            $lastTotal = round($price / (1 + ($totalGst / 100)));
            $cgstPrice = ($lastTotal * $value['cgst']) / 100;
            $sgstPrice = ($lastTotal * $value['sgst']) / 100;

            Fpdf::Row(array(
                $value['hsn'],
                $lastTotal,
                $value['sgst'] . '%',
                round($sgstPrice),
                $value['cgst'] . '%',
                round($cgstPrice)
            ),
                array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
            $taxTotal += $lastTotal;
            $sgstTotal += round($sgstPrice);
            $cgstTotal += round($cgstPrice);
        }

        Fpdf::Row(array(
            'Total',
            $taxTotal,
            '',
            $sgstTotal,
            '',
            $cgstTotal
        ),
            array('R', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);

        Fpdf::SetWidths(array(39, 10, 34, 37, 34, 40));
        Fpdf::Row(array(
            'Dagina',
            $dagina[0]['total_dagina'],
            'Round off (+/-)',
            number_format($round_off, 2),
            'Invoice Total INR',
            number_format(round($lasttotal_finaltotal), 2)
        ), array('L', 'C', 'R', 'R', 'R', 'R'), false, '', true);
        Fpdf::SetWidths(array(194));
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Row(array('TOTAL AMOUNT IN WORDS INR: ' . strtoupper(Helper::conver_num_text_money(round($lasttotal_finaltotal)))),
            array('L'), false, '', true);

        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(194, 5, 'For, ' . $company[0]->company_name, 'LTR', 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(194, 5, 'Autho. Sign .', 'LR', 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(194, 5, '', 'LR', 0, 'R');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(194, 5, 'E.& O.E NOTE : ' . 'We Are Not Responsible For Any Sort Of Breakage Shortage ', 'LR', 0);
        Fpdf::Ln();
        Fpdf::Cell(194, 5, '          Or Damage Of Good In Transit.', 'LBR', 0);
    }

    public static function conver_num_text_money($number)
    {
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            '0' => '',
            '1' => 'one',
            '2' => 'two',
            '3' => 'three',
            '4' => 'four',
            '5' => 'five',
            '6' => 'six',
            '7' => 'seven',
            '8' => 'eight',
            '9' => 'nine',
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fourteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'nineteen',
            '20' => 'twenty',
            '30' => 'thirty',
            '40' => 'forty',
            '50' => 'fifty',
            '60' => 'sixty',
            '70' => 'seventy',
            '80' => 'eighty',
            '90' => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
            } else {
                $str[] = null;
            }
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
        return $result . "  ";
    }

    public static function IGSTReport($invoice_id)
    {
        $order_list = DB::table('invoice')
            ->select('invoice.*', 'challan.challan_id', 'challan.challan_no as challan_rno', 'complain.complain_no', 'complain.created_at as date', 'challan.created_at', 'challan.change_bill_address as billing_change', 'invoice.lr_no', 'invoice.lr_date', 'billty.client_id', 'topland.transport_master.transport_name',
                DB::raw('ifnull((select sum(accessories_qty) from challan_accessories
                WHERE challan_accessories.challan_id = invoice.challan_id),0) as acce_qunt'), 'users.name', 'users.company_id', 'invoice_items.challan_product_id', 'challan.change_bill_address', 'challan.created_at as challan_date',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = invoice.financial_id) as fyear"),
                'billty.lr_no as billty_lr_no', 'billty.lr_date as billty_lr_date',
                DB::raw("(select transport_name from topland.transport_master as p WHERE p.transport_id = billty.transport_id) as billty_transport_nme"))
            ->leftJoin('challan', 'challan.challan_id', '=', 'invoice.challan_id')
            ->leftJoin('billty', 'challan.billty_id', '=', 'billty.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'invoice.transport_id')
            ->leftJoin('users', 'users.user_id', '=', 'invoice.created_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'users.company_id')
            ->leftJoin('invoice_items', 'invoice_items.invoice_id', '=', 'invoice.invoice_id')
            ->where('invoice.invoice_id', '=', $invoice_id)
            ->get();


        $company = DB::table('company_master')
            ->select('company_master.*', 'topland.city_master.city_name', 'topland.district_master.district_name', 'branch_master.*', 'topland.state_master.state_name', 'topland.godown_master.gst')
            ->leftJoin('topland.city_master', 'company_master.city_id', '=', 'topland.city_master.city_id')
            ->leftJoin('topland.district_master', 'company_master.district_id', '=', 'topland.district_master.district_id')
            ->leftJoin('topland.state_master', 'company_master.state_id', '=', 'topland.state_master.state_id')
            ->leftJoin('topland.godown_master', 'company_master.company_id', '=', 'topland.godown_master.company_id')
            ->join('branch_master', 'branch_master.company_id', '=', 'company_master.company_id')
            ->where('company_master.company_id', '=', $order_list[0]->company_id)
            ->get();

        $item_lis = DB::table('invoice_items')
            ->select('challan_item_master.challan_product_id', DB::raw("(select product_name from topland.product_master as p WHERE p.product_id = complain_item_details.product_id) as challan_product_name"),
                'topland.category_master.category_name', 'topland.brand_master.brand_name', DB::raw('challan_item_master.quantity as quantity'),
                'challan_item_master.packing_type', 'challan_item_master.serial_no as from_sr', 'topland.product_master.*',
                'challan_item_master.product_charge', 'challan_item_master.complain_product_id', 'topland.product_master.cetsh_hsn as cetsh_hsn')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'invoice_items.challan_product_id')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'challan_item_master.category_id')
            ->leftJoin('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('invoice_items.invoice_id', '=', $invoice_id)
            ->where('invoice_items.type', '=', 'product');

        $sp_item_lis = DB::table('invoice_items')
            ->select('challan_item_master.challan_product_id', DB::raw("(select product_name from topland.product_master as p WHERE p.product_id = complain_item_details.product_id) as challan_product_name"),
                'topland.category_master.category_name', 'topland.brand_master.brand_name', 'challan_optional.qty as quantity',
                'challan_item_master.packing_type', 'challan_item_master.serial_no as from_sr', 'topland.product_master.*',
                'challan_item_master.product_charge', 'challan_item_master.complain_product_id', DB::raw('8409 as cetsh_hsn'))
            ->leftJoin('challan_optional', 'challan_optional.challan_optional_id', '=', 'invoice_items.challan_product_id')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'challan_optional.challan_product_id')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'challan_item_master.category_id')
            ->leftJoin('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_optional.product_id')
            ->where('invoice_items.invoice_id', '=', $invoice_id)
            ->where('invoice_items.type', '=', 'spare');

        $final = $item_lis->union($sp_item_lis)->orderBY('brand_name')->orderBY('category_name')->orderBY('packing_type')->get();
        $item_lis = json_decode(json_encode($final), true);

        if (empty($final[0]->challan_product_id)) {
            return redirect('invoice');
        }
        $orderLists = DB::table('challan')
            ->select('invoice.client_name as name_of_client', 'invoice.*', 'challan.*', 'complain.*', 'complain.mobile as contact_no',
                'topland.client_master.pincode', 'topland.client_master.email as e_address', 'complain.complain_gst as gst_a',
                'topland.transport_master.*', 'topland.city_master.city_name', 'topland.district_master.district_name', 'topland.state_master.state_name')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('invoice', 'invoice.challan_id', '=', 'challan.challan_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'billty.transport_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.client_master', 'topland.client_master.client_id', '=', 'complain.client_id')
            ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('invoice.challan_id', $order_list[0]->challan_id)
            ->first();

        $client_name = $address1 = $address2 = $address3 = $city = $district = $state = $gst = '';
        if ($orderLists->change_bill_address == 'Y') {
            $client_name = strtoupper($orderLists->billing_name);
            $address = strtoupper($orderLists->address1) . "\n" . strtoupper($orderLists->address2) . "\n" . strtoupper($orderLists->address3);
            $city = strtoupper($orderLists->city_name);
            $district = strtoupper($orderLists->district_name);
            $state = strtoupper($orderLists->state_name);
            $gst = strtoupper(isset($orderLists->gst_a) ? $orderLists->gst_a : '');
            $pincode = strtoupper(isset($orderLists->pincode) ? $orderLists->pincode : '');
            $mobile = strtoupper(isset($orderLists->contact_no) ? $orderLists->contact_no : '');
            $e_address = strtoupper(isset($orderLists->e_address) ? $orderLists->e_address : '');
        } else {
            $client_name = strtoupper($orderLists->client_name);
            $address = strtoupper($orderLists->address);
            $city = strtoupper($orderLists->city_name);
            $district = strtoupper($orderLists->district_name);
            $state = strtoupper($orderLists->state_name);
            $gst = strtoupper(isset($orderLists->gst_a) ? $orderLists->gst_a : '');
            $pincode = strtoupper(isset($orderLists->pincode) ? $orderLists->pincode : '');
            $mobile = strtoupper(isset($orderLists->contact_no) ? $orderLists->contact_no : '');
            $e_address = strtoupper(isset($orderLists->e_address) ? $orderLists->e_address : '');
        }

        $total_rows = 21;

        $pdf = new FPDF('P', 'mm', 'A4');
        $quantity = 0;
        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana-Bold', 'B', 12);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

        Fpdf::Ln();

        Fpdf::SetWidths(array(10, 10, 10));
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::SetFont('Verdana', '', 10);
        Fpdf::Cell(190, 5, $company[0]->company_name, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::Cell(190, 5, 'DELIVERY CHALLAN OUT', 0, 0, 'C');
        Fpdf::SetFont('Verdana', '', 8);

        if ($order_list[0]->branch_id == 1) {
            $invoice_no = 'PF-INV/' . $order_list[0]->fyear . '/' . $order_list[0]->invoice_no;
        } elseif ($order_list[0]->branch_id == 3) {
            $invoice_no = 'TE-INV/' . $order_list[0]->fyear . '/' . $order_list[0]->invoice_no;
        } elseif ($order_list[0]->branch_id == 4) {
            $invoice_no = 'TP-INV/' . $order_list[0]->fyear . '/' . $order_list[0]->invoice_no;
        }
        Fpdf::Ln();
        Fpdf::Cell(130, 5, 'Subject to RAJKOT Jurisdiction', 0, 0);
        Fpdf::Cell(62, 5, 'ORIGINAL DUPLICATE TRIPLICATE EXTRA', 0, 0);
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(97, 4, 'Consigner', 'TRL', 0);
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Cell(50, 4, 'Inv No : ' . $invoice_no, 1, 0, 'L');
        Fpdf::Cell(47, 4, 'Date : ' . date("d-m-Y", strtotime($order_list[0]->invoice_date)), 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, trim($company[0]->company_name), 'RL', 0);
        Fpdf::Cell(20, 4, 'Transport : ', 1, 0, 'L');
        Fpdf::Cell(77, 4, $order_list[0]->transport_name, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company[0]->address1, 'RL', 0);

        Fpdf::Cell(50, 4, 'LR No : ' . $order_list[0]->lr_no, 1, 0, 'L');
        Fpdf::Cell(47, 4, 'LR Date : ' . date("d-m-Y", strtotime($order_list[0]->lr_date)), 1, 0, 'L');

        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company[0]->address2 . ' ' . $company[0]->address3, 'RL', 0);
        Fpdf::Cell(50, 4, '', 1, 0, 'L');
        Fpdf::Cell(47, 4, '', 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, 'City : ' . $company[0]->city_name . '-' . $company[0]->pincode . ' Dist : ' . $company[0]->district_name .
            ' State. : ' . $company[0]->state_name,
            'RL', 0);
        Fpdf::Cell(50, 4, 'Lorry No :', 1, 0, 'L');
        Fpdf::Cell(47, 4, strtoupper($order_list[0]->lory_no), 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, 'Ph.:' . $company[0]->phone, 'RL', 0);
        if ($order_list[0]->branch_id == 1) {
            $challan_rno = 'PF-CH/' . $order_list[0]->fyear . '/' . $order_list[0]->challan_rno;
        } elseif ($order_list[0]->branch_id == 3) {
            $challan_rno = 'TE-CH/' . $order_list[0]->fyear . '/' . $order_list[0]->challan_rno;
        } elseif ($order_list[0]->branch_id == 4) {
            $challan_rno = 'TP-CH/' . $order_list[0]->fyear . '/' . $order_list[0]->challan_rno;
        }
        Fpdf::Cell(50, 4, 'Ch No : ' . $challan_rno, 1, 0, 'L');
        Fpdf::Cell(47, 4, 'Ch Date : ' . date("d-m-Y", strtotime($order_list[0]->created_at)), 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, 'GSTN .:' . $company[0]->gst_no, 'RL', 0);
        Fpdf::Cell(50, 4, '', 1, 0, 'L');
        Fpdf::Cell(47, 4, '', 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, '', 'RLB', 0);
        Fpdf::Cell(50, 4, '', 1, 0, 'L');
        Fpdf::Cell(47, 4, '', 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(97, 4, 'Billing Address', 'TRL', 0);
        Fpdf::Cell(97, 4, 'Remarks:', 'TRL', 0, 'L');
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Ln();

        Fpdf::SetWidths(array(97, 97));
        Fpdf::SetFont('Verdana-Bold', 'B', 9);

        /** print address */
        $part1 = strtoupper($client_name) . "\n" . strtoupper($address) . "\n" . 'GSTN: ' . $gst
            . "\n" . 'City: ' . trim($city) . "\n" . 'District: ' . trim($district) . "\n" . 'State: ' . trim($state)
            . "\n" . 'PinCode: ' . trim($pincode) . "\n" . 'Contact No: ' . trim($mobile) . "\n" . 'E-Mail: ' . trim($e_address);
        $part2 = (empty($order_list[0]->remark) ? '' : $order_list[0]->remark . '') . "\n" . "*** RETURN AFTER REPAIRING NOT FOR SALE HAVING NO. COMM. VALUE ***";


        Fpdf::Row(array($part1, $part2), array('L', 'L'), '', array('', 'B'), true);

        if ($order_list[0]->change_develiry_address == 'Y') {

            $client_address_data_change_delivery = DB::table('invoice')
                ->select('invoice.billing_name as client_name', 'invoice.address1', 'invoice.address2', 'invoice.address3', 'topland.city_master.city_name', 'topland.district_master.district_name', 'topland.state_master.state_name', 'invoice.gst_no')
                ->select('invoice.billing_name as client_name', 'invoice.address1', 'invoice.address2', 'invoice.address3', 'topland.city_master.city_name', 'topland.district_master.district_name', 'topland.state_master.state_name', 'invoice.gst_no')
                ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'invoice.city_id')
                ->leftJoin('topland.district_master', 'topland.district_master.district_id', '=', 'city_master.district_id')
                ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'district_master.state_id')
                ->where('invoice.invoice_id', '=', $invoice_id)
                ->get();
            Fpdf::SetWidths(array(194));

            Fpdf::Row(array('DELIVERY AT : ' . strtoupper($client_address_data_change_delivery[0]->client_name) . "\n" . 'ADDRESS : ' . strtoupper($client_address_data_change_delivery[0]->address1) . " " . strtoupper($client_address_data_change_delivery[0]->address2) . " " . strtoupper($client_address_data_change_delivery[0]->address3) . " " . 'CITY: ' . strtoupper($client_address_data_change_delivery[0]->city_name) . " " . 'DISTRICT: ' . strtoupper($client_address_data_change_delivery[0]->district_name) . " " . 'STATE: ' . strtoupper($client_address_data_change_delivery[0]->state_name . "\n" . 'GSTIN : ' . strtoupper($client_address_data_change_delivery[0]->gst_no))),
                array('L'), '', array(''), true);
        }

        Fpdf::SetWidths(array(80, 114));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array(
            'GOODS RECEIVED FOR REPAIRING THROUGH ',
            $order_list[0]->billty_transport_nme . ' / LR No.' . $order_list[0]->billty_lr_no . ' LR Date. : ' . date("d-m-Y",
                strtotime($order_list[0]->billty_lr_date))
        ), array('C', 'C'), '', array(), true);

        $temp = 0;
        Fpdf::SetFont('Verdana-Bold', 'B', 8);

        Fpdf::SetWidths(array(15, 76, 50, 15));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetFont('Verdana', '', 8);

        Fpdf::SetWidths(array(10, 50, 20, 10));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetWidths(array(5, 7, 50, 15, 20, 26));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(10, 6, 'No', 'TL', 0, 'C');
        Fpdf::Cell(79, 6, 'Description of Goods / Services', 'TL', 0, 'C');
        Fpdf::Cell(20, 6, 'HSN', 'TL', 0, 'C');
        Fpdf::Cell(10, 6, 'Qty', 'TL', 0, 'C');
        Fpdf::Cell(25, 6, 'Rate', 'TL', 0, 'C');
        Fpdf::Cell(23, 6, 'IGST (%)', 'TLR', 0, 'C');
        Fpdf::Cell(27, 6, 'Total', 'TLR', 0, 'C');
        Fpdf::Ln();
        Fpdf::SetWidths(array(10, 79, 20, 10, 25, 23, 27));
        Fpdf::SetFont('Verdana', '', 9);
        if (!empty($item_lis)) {
            $temp = 1;
            $header_string = "";
            $lasttotal_qty = 0;
            $lasttotal_total = 0;
            $lasttotal_igst = 0;
            $lasttotal_finaltotal = 0;
            $allArray = array();
            foreach ($item_lis as $row) {
                $category_id = $row['category_id'];
                $complain_product_id = $row['complain_product_id'];
                $product_data = DB::table('challan_item_master')
                    ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
                    ->leftJoin('topland.new_single_price_list', 'topland.new_single_price_list.product_id', '=', 'complain_item_details.product_id')
                    ->where('complain_item_details.cid_id', '=', $complain_product_id)
                    ->where('topland.new_single_price_list.price_date', '=', '2017-07-01')
                    ->get();
                $new_header_string = strtoupper($row['brand_name'] . " " . $row['category_name'] . " " . $row['packing_type']);

                if ($header_string != $new_header_string) {
                    Fpdf::SetWidths(array(194));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array($new_header_string), array('C'), '', '', true);
                    $header_string = $new_header_string;
                    Fpdf::SetWidths(array(10, 79, 20, 10, 25, 23, 27));
                    $total_rows -= 1;
                }
                $opt_item = '';
                $challan_product_id = $row['challan_product_id'];
                $optional = DB::table('challan_optional')
                    ->select('topland.product_master.product_name', 'challan_optional.optional_status')
                    ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_optional.product_id')
                    ->where('challan_optional.challan_product_id', '=', $challan_product_id)
                    ->where('challan_optional.optional_status', '!=', 'Spare')
                    ->get();
                foreach ($optional as $add) {
                    if ($add->optional_status == 'Add') {
                        $opt_item .= "\n(+)" . $add->product_name;
                    } elseif ($add->optional_status == 'Remove') {
                        $opt_item .= "\n(-)" . $add->product_name;
                    }
                    $total_rows -= 1;
                }
                if ($row['packing_type'] == 'loose') {
                    $product_price = $product_data[0]->loose_price;
                } elseif ($row['packing_type'] == 'packing') {
                    $product_price = $product_data[0]->packing_price;
                } else {
                    $product_price = $product_data[0]->skd_price;
                }

                Fpdf::SetFont('Verdana', '', 8);
                $total = $product_price * $row['quantity'];
                $igst = '1.' . $row['igst_rate'];
                $igst_total = $product_price * $igst / 100;
                $finaltotal = $total;
                $lasttotal_qty = $lasttotal_qty + $row['quantity'];
                $lasttotal_total = $lasttotal_total + $total;
                $lasttotal_igst = $lasttotal_igst + $igst_total;
                $lasttotal_finaltotal = $lasttotal_finaltotal + $finaltotal;
//                $product_charges = $row['product_charge'];
//                $charge += $product_charges;
                if (!empty($row['from_sr'])) {
                    $ser = ' (' . $row['from_sr'] . ')';
                } else {
                    $ser = '';
                }
                if (!empty($row['challan_product_name'])) {
                    $product_name = '(' . $row['challan_product_name'] . ')';
                } else {
                    $product_name = '';
                }

                Fpdf::Row(array(
                    $temp,
                    $row['product_name'] . $product_name . $opt_item . $ser,
                    $row['cetsh_hsn'],
                    $row['quantity'],
                    $product_price,
                    $row['igst_rate'] . '%',
                    number_format($finaltotal, 2)
                ),
                    array('C', 'L', 'C', 'C', 'C', 'C', 'C'), '', '', true);
                array_push($allArray, array('hsn' => $row['cetsh_hsn'], 'qty' => $row['quantity'], 'price' => $finaltotal, 'igst' => $row['igst_rate']));
                $temp++;
                $quantity += $row['quantity'];
                $total_rows -= 1;
            }
            $price = array();
            foreach ($allArray as $key => $r) {
                $price[$key] = $r['hsn'];
            }
            array_multisort($price, SORT_ASC, $allArray);
            $arrayLength = sizeof($allArray);
            $newArray = [];
            array_push($newArray, array('hsn' => $allArray[0]['hsn'], 'qty' => $allArray[0]['qty'], 'price' => $allArray[0]['price'], 'igst' => $allArray[0]['igst']));

            for ($i = 1; $i < $arrayLength; $i++) {
                $lastValue = end($newArray);
                if ($allArray[$i]['hsn'] == $lastValue['hsn']) {
                    if ($allArray[$i]['igst'] == $lastValue['igst']) {
                        $priceWithQty = $allArray[$i]['price'];
                        $newPrice = $priceWithQty + $lastValue['price'];
                        $newQty = $allArray[$i]['qty'] + $lastValue['qty'];
                        array_pop($newArray);
                        array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $newQty, 'price' => $newPrice, 'igst' => $allArray[$i]['igst']));
                    } else {
                        array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $allArray[$i]['qty'], 'price' => $allArray[$i]['price'], 'igst' => $allArray[$i]['igst']));
                    }
                } else {
                    array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $allArray[$i]['qty'], 'price' => $allArray[$i]['price'], 'igst' => $allArray[$i]['igst']));
                }
            }
            $noto = $quantity + $order_list[0]->acce_qunt;
        }
        if ($order_list[0]->view_accessories == 'Y') {
            $dagina = DB::table('challan_accessories')
                ->select(DB::raw("SUM(accessories_qty) as total_dagina"))
                ->where('challan_accessories.challan_id', '=', $order_list[0]->challan_id)
                ->get();
        } else {
            $dagina[0]['total_dagina'] = 0;
        }

        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        for ($s = 1; $s <= $total_rows; $s++) {
            Fpdf::Cell(10, 5, '', 'L', 0, 'C');
            Fpdf::Cell(79, 5, '', 'L', 0, 'C');
            Fpdf::Cell(20, 5, '', 'L', 0, 'C');
            Fpdf::Cell(10, 5, '', 'L', 0, 'C');
            Fpdf::Cell(25, 5, '', 'L', 0, 'C');
            Fpdf::Cell(23, 5, '', 'L', 0, 'C');
            Fpdf::Cell(27, 5, '', 'LR', 1, 'C');

        }
        Fpdf::Row(array(
            '',
            'Total',
            '',
            $lasttotal_qty,
            '',
            '',
            number_format($lasttotal_finaltotal, 2)
        ),
            array('C', 'L', 'C', 'C', 'C', 'C', 'L'), '', '', true);
        $round_off = abs(round($lasttotal_finaltotal) - $lasttotal_finaltotal);
        Fpdf::SetWidths(array(74, 40, 40, 40));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array(
            'HSN',
            'Taxable Value',
            'IGST (%)',
            'IGST Value'
        ),
            array('C', 'C', 'C', 'C', 'C'), '', '', true);
        Fpdf::SetFont('Verdana', '', 9);
        $taxTotal = 0;
        $igstTotal = 0;
        foreach ($newArray as $key => $value) {

            $price = $value['price'];
            $lastTotal = round($price / (1 + ($value['igst'] / 100)));
            $igstPrice = ($lastTotal * $value['igst']) / 100;

            Fpdf::Row(array(
                $value['hsn'],
                $lastTotal,
                $value['igst'] . '%',
                round($igstPrice)
            ),
                array('C', 'C', 'C', 'C', 'C'), '', '', true);
            $taxTotal += $lastTotal;
            $igstTotal += round($igstPrice);
        }
        Fpdf::Row(array(
            'Total',
            $taxTotal,
            '',
            $igstTotal
        ),
            array('R', 'C', 'C', 'C', 'C'), '', '', true);

        Fpdf::SetWidths(array(39, 10, 34, 37, 34, 40));
        Fpdf::Row(array(
            'Dagina',
            $dagina[0]['total_dagina'],
            'Round off (+/-)',
            number_format($round_off, 2),
            'Invoice Total INR',
            number_format(round($lasttotal_finaltotal), 2)
        ), array('L', 'C', 'R', 'R', 'R', 'R'), false, '', true);
        Fpdf::SetWidths(array(194));
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Row(array('TOTAL AMOUNT IN WORDS INR: ' . strtoupper(Helper::conver_num_text_money(round($lasttotal_finaltotal)))),
            array('L'), false, '', true);

        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(194, 5, 'For, ' . $company[0]->company_name, 'LTR', 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(194, 5, 'Autho. Sign .', 'LR', 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(194, 5, '', 'LR', 0, 'R');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(194, 5, 'E.& O.E NOTE : ' . 'We Are Not Responsible For Any Sort Of Breakage Shortage ', 'LR', 0);
        Fpdf::Ln();
        Fpdf::Cell(194, 5, '          Or Damage Of Good In Transit.', 'LBR', 0);
    }

    public static function InvoicePdf($invoice_id)
    {
        $state = DB::table('invoice')
            ->select('complain.state')
            ->leftJoin('challan', 'challan.challan_id', '=', 'invoice.challan_id')
            ->leftJoin('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->where('invoice.invoice_id', '=', $invoice_id)
            ->first();
        if ($state->state == 'GUJARAT' || $state->state == 'SAURASHTRA') {
            $invoice = Helper::CGSTReport($invoice_id);
            Fpdf::Output();
            echo $invoice;
        } else {
            $invoice = Helper::IGSTReport($invoice_id);
            Fpdf::Output();
            echo $invoice;
        }

        $order_list = DB::table('invoice')
            ->select('invoice.*', 'challan.challan_id', 'challan.challan_no as challan_rno', 'challan.created_at', 'challan.change_bill_address as billing_change', 'billty.lr_no', 'billty.lr_date', 'billty.client_id', 'topland.transport_master.transport_name',
                DB::raw('ifnull((select sum(accessories_qty) from challan_accessories
                WHERE challan_accessories.challan_id = invoice.challan_id),0) as acce_qunt'), 'users.name', 'users.company_id', 'invoice_items.challan_product_id', 'challan.change_bill_address', 'challan.created_at as challan_date')
            ->leftJoin('challan', 'challan.challan_id', '=', 'invoice.challan_id')
            ->leftJoin('billty', 'challan.billty_id', '=', 'billty.billty_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'invoice.transport_id')
            ->leftJoin('users', 'users.user_id', '=', 'invoice.created_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'users.company_id')
            ->leftJoin('invoice_items', 'invoice_items.invoice_id', '=', 'invoice.invoice_id')
            ->where('invoice.invoice_id', '=', $invoice_id)
            ->get();

        if (empty($order_list[0]->product_id)) {
            return redirect('invoice');
        }
    }

    public static function creditNoteReport($credit_note_id)
    {
        $order_count = 0;
        $order_list = DB::table('challan')
            ->select('topland.transport_master.transport_name', 'complain.complain_no', 'credit_note.created_at as credit_note_date', 'complain.client_name', 'complain.address', 'challan.*',
                'topland.city_master.city_name', 'complain.district', 'complain.state', 'billty.freight_rs', 'billty.lr_no', 'billty.lr_date', 'challan.change_bill_address', 'credit_note.remark', 'billty.freight_rs_by', 'company_master.company_name',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = challan.financial_id) as fyear"))
            ->join('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->join('topland.transport_master', 'topland.transport_master.transport_id', '=', 'billty.transport_id')
            ->join('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->join('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->join('credit_note', 'credit_note.challan_id', '=', 'challan.challan_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'billty.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('credit_note.credit_note_id', $credit_note_id)
            ->first();
        $client_name = $spress1 = $spress2 = $spress3 = $city = $district = $state = '';
        if ($order_list->change_bill_address == 'Y') {
            $client_name = strtoupper($order_list->billing_name);
            $spress1 = strtoupper($order_list->address);
            $spress = trim($spress1) . "\n" . trim($spress2) . "\n" . trim($spress3);
            $city = strtoupper($order_list->city_name);
            $district = strtoupper($order_list->district);
            $state = strtoupper($order_list->state);
        } else {
            $client_name = strtoupper($order_list->client_name);
            $spress1 = strtoupper($order_list->address);
            $spress = trim($spress1);
            $city = strtoupper($order_list->city_name);
            $district = strtoupper($order_list->district);
            $state = strtoupper($order_list->state);
        }

        $item_list = DB::table('credit_note_item')
            ->select('challan_item_master.*', 'topland.category_master.category_name', 'topland.product_master.phase', 'topland.product_master.kva', 'topland.product_master.delivery_size_inch', 'topland.product_master.sucation_size_inch', 'topland.product_master.rpm', 'topland.product_master.h_p', 'topland.product_master.product_name', DB::raw('1 as quantity'),
                DB::raw("(select product_name from topland.product_master as p WHERE p.product_id = complain_item_details.product_id) as challan_product_name"),
                'topland.brand_master.brand_name', 'challan_item_master.packing_type as packing_types', 'challan_item_master.serial_no as from_sr', 'credit_note_item.amount', 'complain_item_details.*')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'credit_note_item.challan_product_id')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'challan_item_master.category_id')
            ->leftJoin('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('credit_note_item.credit_note_id', $credit_note_id)
            ->where('credit_note_item.type', '=', 'product');
        $optional_list = DB::table('credit_note_item')
            ->select('challan_item_master.*', 'topland.category_master.category_name', 'topland.product_master.phase', 'topland.product_master.kva', 'topland.product_master.delivery_size_inch', 'topland.product_master.sucation_size_inch', 'topland.product_master.rpm', 'topland.product_master.h_p', 'topland.product_master.product_name', 'challan_optional.qty as quantity',
                DB::raw("(select product_name from topland.product_master as p WHERE p.product_id = complain_item_details.product_id) as challan_product_name"),
                'topland.brand_master.brand_name', 'challan_item_master.packing_type as packing_types', 'challan_item_master.serial_no as from_sr', 'credit_note_item.amount', 'complain_item_details.*')
            ->leftJoin('challan_optional', 'challan_optional.challan_optional_id', '=', 'credit_note_item.challan_product_id')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'challan_optional.challan_product_id')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'challan_item_master.category_id')
            ->leftJoin('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_optional.product_id')
            ->where('credit_note_item.credit_note_id', $credit_note_id)
            ->where('credit_note_item.type', '=', 'spare');
        $final = $item_list->union($optional_list)->orderBY('brand_name')->orderBY('category_name')->orderBY('packing_types')->get();
        $final = json_decode(json_encode($final), true);

        $pdf = new FPDF('P', 'mm', 'A4');
        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::SetFont('Verdana', '', 10);
        Fpdf::Cell(190, 5, $order_list->company_name, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::Cell(190, 5, 'Credit Note', 0, 0, 'C');
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Ln();

        if ($order_list->branch_id == 1) {
            $complains_no = 'PF-TKT/' . $order_list->fyear . '/' . $order_list->complain_no;
        } elseif ($order_list->branch_id == 3) {
            $complains_no = 'TE-TKT/' . $order_list->fyear . '/' . $order_list->complain_no;
        } elseif ($order_list->branch_id == 4) {
            $complains_no = 'TP-TKT/' . $order_list->fyear . '/' . $order_list->complain_no;
        }

        Fpdf::Cell(190, 5, 'Complain No : ' . $complains_no, 0, 1, 'R');
        Fpdf::Cell(190, 5, 'Credit Date : ' . date('d/m/Y', strtotime($order_list->credit_note_date)), 0, 0, 'R');
        Fpdf::Ln();
        Fpdf::SetWidths(array(95, 95));

        Fpdf::SetFont('Verdana', '', 8);
        /** print address */
        Fpdf::Row(array(
            (trim($client_name) . "\n" . $spress . "\n" . trim($city) . "\n" . trim($district) . "\n" . trim($state)),
            'Transport : ' . $order_list->transport_name . "\n" . 'LR No. :' . $order_list->lr_no . "\n" . 'LR Date. :' . date('d/m/Y',
                strtotime($order_list->lr_date)) . "\n" . 'Freight By : ' . $order_list->freight_rs_by . "\n" . 'Freight Rs : ' . $order_list->freight_rs . "\n"
        ), array('L', 'L'), '', '', true, 4);

        Fpdf::Ln();

        Fpdf::SetWidths(array(10, 15, 121, 22, 22));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array('No.', 'Qty.', "Item Description", 'Serial No.', 'Amount'), array('C', 'C', 'L', 'C', 'C'), '', array(), true);
        Fpdf::SetFont('Verdana', '', 8);
        if (!empty($final)) {
            $temp = 1;
            $itm_grand_total = 0;
            $heading_string = strtoupper(Helper::HeadingString($final[0]['brand_id'], $final[0]['category_id'],
                $final[0]['packing_types'], $final[0]['challan_product_id']));
            Fpdf::SetFont('Verdana-Bold', 'B', 7);
            Fpdf::Cell(190, 5, $heading_string, 'LR', 0, 'C');
            Fpdf::Ln();
            Fpdf::SetFont('Verdana', '', 8);

            $grand_total = 0;
            $amount_total = 0;
            foreach ($final as $row) {
                $opt_item = '';
                $new_heading_string = strtoupper(Helper::HeadingString($row['brand_id'], $row['category_id'],
                    $row['packing_types'], $row['challan_product_id']));
                if ($heading_string != $new_heading_string) {
                    $heading_string = $new_heading_string;
                    Fpdf::SetFont('Verdana-Bold', 'B', 7);
                    Fpdf::Cell(190, 5, $new_heading_string, 'LR', 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana', '', 8);
                }

                $sp_qry = '';
                $challan_product_id = $row['challan_product_id'];
                $optional = DB::table('challan_optional')
                    ->select('topland.product_master.product_name', 'challan_optional.optional_status')
                    ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_optional.product_id')
                    ->where('challan_optional.challan_product_id', '=', $challan_product_id)
                    ->where('challan_optional.optional_status', '!=', 'Spare')
                    ->get();

                foreach ($optional as $add) {
                    if ($add->optional_status == 'Add') {
                        $opt_item .= "\n(+)" . $add->product_name;
                    } elseif ($add->optional_status == 'Remove') {
                        $opt_item .= "\n(-)" . $add->product_name;
                    }
//                    $total_rows -= 1;
                }
                if (!empty($row['challan_product_name'])) {
                    $product_name = '(' . $row['challan_product_name'] . ')';
                } else {
                    $product_name = '';
                }
                Fpdf::Row(array(
                    $temp,
                    $row['quantity'],
                    $row['product_name'] . ' ' . $product_name . " - " . strtoupper(Helper::ProductString($row['product_id'],
                        $row['category_id'])) . $opt_item,
                    rtrim($row['from_sr']),
                    $row['amount']
                ), array('C', 'C', 'L', 'C', 'C'), '', array(), true, 4);
                $grand_total += $row['quantity'];
                $amount_total += $row['amount'];
                $temp++;
            }
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('', $grand_total, 'Total Qty', '', ''), array('C', 'C', 'L', 'L', 'L'), '', array(), true, 4);
            Fpdf::Row(array('', '', 'Credit Amount', '', $amount_total), array('C', 'C', 'L', 'L', 'C'), '', array(), true, 4);
            Fpdf::Ln();
        }

        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetWidths(array(20, 170));
        Fpdf::Row(array('Remark .:', strtoupper($order_list->remark)), array('L', 'L'), '', array('B', ''), true);
        Fpdf::Ln(20);
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(155);
        Fpdf::Cell(35, 5, 'Authorised Signature', 'T', 0, 'R');
        Fpdf::Ln();
    }

    public static function destroyChallanReport($destroy_id)
    {
        $order_count = 0;
        $order_list = DB::table('challan')
            ->select('topland.transport_master.transport_name', 'complain.complain_no', 'destroy.created_at as destroy_date', 'complain.client_name', 'complain.address', 'challan.*',
                'topland.city_master.city_name', 'complain.district', 'complain.state', 'billty.freight_rs', 'billty.freight_rs_by', 'billty.lr_no', 'billty.lr_date', 'challan.change_bill_address', 'company_master.company_name')
            ->join('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->join('topland.transport_master', 'topland.transport_master.transport_id', '=', 'billty.transport_id')
            ->join('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->join('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->join('destroy', 'destroy.challan_id', '=', 'challan.challan_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'billty.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('destroy.destroy_id', $destroy_id)
            ->first();
        $client_name = $spress1 = $spress2 = $spress3 = $city = $district = $state = '';
        if ($order_list->change_bill_address == 'Y') {
            $client_name = strtoupper($order_list->billing_name);
            $spress = strtoupper($order_list->address);
//            $spress2 = strtoupper($order_list->address2);
//            $spress3 = strtoupper($order_list->address3);
            $city = strtoupper($order_list->city_name);
            $district = strtoupper($order_list->district);
            $state = strtoupper($order_list->state);
        } else {
            $client_name = strtoupper($order_list->client_name);
            $spress = strtoupper($order_list->address);
//            $spress2 = strtoupper($order_list->address2);
//            $spress3 = strtoupper($order_list->address3);
            $city = strtoupper($order_list->city_name);
            $district = strtoupper($order_list->district);
            $state = strtoupper($order_list->state);
        }

        $item_list = DB::table('destroy_item')
            ->select('challan_item_master.*', 'topland.category_master.category_name', 'topland.product_master.phase', 'topland.product_master.kva', 'topland.product_master.delivery_size_inch', 'topland.product_master.sucation_size_inch', 'topland.product_master.rpm', 'topland.product_master.h_p', 'topland.product_master.product_name', DB::raw('1 as quantity'),
                DB::raw("(select product_name from topland.product_master as p WHERE p.product_id = complain_item_details.product_id) as challan_product_name"),
                'topland.brand_master.brand_name', 'challan_item_master.packing_type as packing_types', 'challan_item_master.serial_no as from_sr', 'destroy_item.remark', 'complain_item_details.*')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'destroy_item.challan_product_id')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'challan_item_master.category_id')
            ->leftJoin('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->where('destroy_item.destroy_id', $destroy_id)
            ->where('destroy_item.type', '=', 'product');
        $optional_list = DB::table('destroy_item')
            ->select('challan_item_master.*', 'topland.category_master.category_name', 'topland.product_master.phase', 'topland.product_master.kva', 'topland.product_master.delivery_size_inch', 'topland.product_master.sucation_size_inch', 'topland.product_master.rpm', 'topland.product_master.h_p', 'topland.product_master.product_name', 'challan_optional.qty as quantity',
                DB::raw("(select product_name from topland.product_master as p WHERE p.product_id = complain_item_details.product_id) as challan_product_name"),
                'topland.brand_master.brand_name', 'challan_item_master.packing_type as packing_types', 'challan_item_master.serial_no as from_sr', 'destroy_item.remark', 'complain_item_details.*')
            ->leftJoin('challan_optional', 'challan_optional.challan_optional_id', '=', 'destroy_item.challan_product_id')
            ->leftJoin('challan_item_master', 'challan_item_master.challan_product_id', '=', 'challan_optional.challan_product_id')
            ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'challan_item_master.category_id')
            ->leftJoin('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_optional.product_id')
            ->where('destroy_item.destroy_id', $destroy_id)
            ->where('destroy_item.type', '=', 'spare');
        $final = $item_list->union($optional_list)->orderBY('brand_name')->orderBY('category_name')->orderBY('packing_types')->get();

        if (empty($final[0]->challan_product_id)) {
            return redirect('destroy');
        }
        $final = json_decode(json_encode($final), true);
        $pdf = new FPDF('P', 'mm', 'A4');
        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::SetFont('Verdana', '', 10);
        Fpdf::Cell(190, 5, $order_list->company_name, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::Cell(190, 5, 'Challan Destroy', 0, 0, 'C');
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Cell(190, 5, 'Complain No : ' . $order_list->complain_no, 0, 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(190, 5, 'Destroy Date : ' . date('d/m/Y', strtotime($order_list->destroy_date)), 0, 0, 'R');
        Fpdf::Ln();
        Fpdf::SetWidths(array(95, 95));

        Fpdf::SetFont('Verdana', '', 8);
        /** print address */
        Fpdf::Row(array(
            (trim($client_name) . "\n" . $spress . "\n" . trim($city) . "\n" . trim($district) . "\n" . trim($state)),
            'Transport : ' . $order_list->transport_name . "\n" . 'LR No. :' . $order_list->lr_no . "\n" . 'LR Date. :' . date('d/m/Y',
                strtotime($order_list->lr_date)) . "\n" . 'Freight By : ' . $order_list->freight_rs_by . "\n" . 'Freight Rs : ' . $order_list->freight_rs
        ), array('L', 'L'), '', '', true, 4);


        Fpdf::Ln();

        Fpdf::SetWidths(array(10, 15, 95, 25, 45));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array('No.', 'Qty.', "Item Description", 'Serial No.', 'Remark'), array('C', 'C', 'L', 'L', 'C'), '', array(), true);
        Fpdf::SetFont('Verdana', '', 8);
        if (!empty($final)) {
            $temp = 1;
            $itm_grand_total = 0;
            $heading_string = strtoupper(Helper::HeadingString($final[0]['brand_id'], $final[0]['category_id'],
                $final[0]['packing_types'], $final[0]['challan_product_id']));
            Fpdf::SetFont('Verdana-Bold', 'B', 7);
            Fpdf::Cell(190, 5, $heading_string, 'LR', 0, 'C');
            Fpdf::Ln();
            Fpdf::SetFont('Verdana', '', 8);

            $grand_total = 0;
            foreach ($final as $row) {

                $opt_item = '';
                $new_heading_string = strtoupper(Helper::HeadingString($row['brand_id'], $row['category_id'],
                    $row['packing_types'], $row['challan_product_id']));
                if ($heading_string != $new_heading_string) {
                    $heading_string = $new_heading_string;
                    Fpdf::SetFont('Verdana-Bold', 'B', 7);
                    Fpdf::Cell(190, 5, $new_heading_string, 'LR', 0, 'C');
                    Fpdf::Ln();
                    Fpdf::SetFont('Verdana', '', 8);
                }

                $sp_qry = '';
                $challan_product_id = $row['challan_product_id'];
                $optional = DB::table('challan_optional')
                    ->select('topland.product_master.product_name', 'challan_optional.optional_status')
                    ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_optional.product_id')
                    ->where('challan_optional.challan_product_id', '=', $challan_product_id)
                    ->where('challan_optional.optional_status', '!=', 'Spare')
                    ->get();

                foreach ($optional as $add) {
                    if ($add->optional_status == 'Add') {
                        $opt_item .= "\n(+)" . $add->product_name;
                    } elseif ($add->optional_status == 'Remove') {
                        $opt_item .= "\n(-)" . $add->product_name;
                    }
//                    $total_rows -= 1;
                }
                if (!empty($row['challan_product_name'])) {
                    $product_name = '(' . $row['challan_product_name'] . ')';
                } else {
                    $product_name = '';
                }
                Fpdf::Row(array(
                    $temp,
                    $row['quantity'],
                    $row['product_name'] . ' ' . $product_name . " - " . strtoupper(Helper::ProductString($row['product_id'],
                        $row['category_id'])) . $opt_item,
                    rtrim($row['from_sr']),
                    $row['remark']
                ), array('C', 'C', 'L', 'L', 'L'), '', array(), true, 4);
                $grand_total += $row['quantity'];
                $temp++;
            }
            Fpdf::Ln();
            Fpdf::SetFont('Verdana-Bold', 'B', 9);
            Fpdf::Row(array('', $grand_total, 'Total Qty', '', ''), array('C', 'C', 'L', 'L', 'L'), '', array(), true, 4);
            Fpdf::Ln();
        }

        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetWidths(array(20, 170));
//        Fpdf::Row(array('Remark .:', strtoupper($order_list->remark)), array('L', 'L'), '', array('B', ''), true);
        Fpdf::Ln(20);
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(155);
        Fpdf::Cell(35, 5, 'Authorised Signature', 'T', 0, 'R');
        Fpdf::Ln();

    }

    public static function serviceExpenseReport($expense_id)
    {
        $expense = DB::table('replacement_expense')
            ->select('topland.mechanic_master.mechanic_name', 'replacement_expense.*', 'topland.state_master.state_name', DB::raw('ifnull((select topland.mechanic_master.mechanic_name from topland.mechanic_master WHERE topland.mechanic_master.mechanic_id = replacement_expense.mechanic_id2),"")
                as mechanic_id2'), 'company_master.company_name', 'replacement_expense.expense_no')
            ->leftJoin('topland.mechanic_master', 'topland.mechanic_master.mechanic_id', '=', 'replacement_expense.mechanic_id')
            ->leftJoin('topland.state_master', 'topland.state_master.state_id', '=', 'replacement_expense.state_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'replacement_expense.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('replacement_expense.expense_id', '=', $expense_id)
            ->get();


        $complain_id = $expense[0]->complain_id;
        $pdf = new FPDF('P', 'mm', 'A4');
        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

        Fpdf::Cell(190, 5, $expense[0]->company_name, 0, 1, 'C');
        Fpdf::SetWidths(array(113, 90));
        Fpdf::Row(array('TRAVELING REPORT', 'Report No : ' . $expense[0]->expense_no), array('R', 'C'), '', array(),
            '');
        Fpdf::Row(array('', '     Date : ' . date('d/m/Y', strtotime($expense[0]->traveling_from))),
            array('R', 'C'), '', array(), '');
        Fpdf::SetWidths(array(40, 140));
        Fpdf::Row(array('Person Name', ': ' . $expense[0]->mechanic_name . ' , ' . $expense[0]->mechanic_id2),
            array('L', 'L'), '', array(), '');

        Fpdf::SetWidths(array(40, 50, 90));

        Fpdf::Row(array(
            'Place Of Tour    ',
            ': State : ' . $expense[0]->state_name,
            ' City : ' . $expense[0]->city_name
        ),
            array('L', 'L', 'L'), '', array(),
            '');
        Fpdf::SetWidths(array(40, 140));
        Fpdf::Row(array('Reason Of Tour', ': ' . $expense[0]->traveling_reason . ' Repairing'), array('L', 'L'), '',
            array(), '');
        Fpdf::SetWidths(array(40, 50, 90));
        $word_advance_amount = Helper::conver_num_text_money($expense[0]->advance_amount);
        $word_amount_taken_from_dealer = Helper::conver_num_text_money($expense[0]->amount_taken_from_dealer);
        Fpdf::Row(array(
            'Advance Amount    ',
            ': Rs.  ' . $expense[0]->advance_amount,
            'In Words : ' . ucwords($word_advance_amount)
        ),
            array('L', 'L', 'L'), '',
            array(),
            '');

        $replacement_traveling_expense = DB::table('replacement_traveling_expense')
            ->where('is_delete', '=', 'N')
            ->where('expense_id', '=', $expense_id)
            ->orderBy('travel_date', 'ASC')
            ->get();
        $replacement_traveling_expense = isset($replacement_traveling_expense) ? $replacement_traveling_expense : '';
        $replacement_traveling_expense_time_from = DB::select("SELECT
			replacement_traveling_expense.time_from
		FROM
			replacement_traveling_expense
		WHERE
			replacement_traveling_expense.expense_id = $expense_id
		GROUP BY
			replacement_traveling_expense.traveling_expense_id
		ORDER BY
			replacement_traveling_expense.traveling_expense_id ASC LIMIT 1");
        $replacement_traveling_expense_time_to = DB::select("SELECT
			replacement_traveling_expense.time_to
		FROM
			replacement_traveling_expense
		WHERE
			replacement_traveling_expense.expense_id = $expense_id
		GROUP BY
			replacement_traveling_expense.traveling_expense_id
		ORDER BY
			replacement_traveling_expense.traveling_expense_id DESC LIMIT 1");


        $replacement_other_expense = DB::table('replacement_other_expense')
            ->where('is_delete', '=', 'N')
            ->where('expense_id', '=', $expense_id)
            ->get();
        $tot_traveling = 0;

        foreach ($replacement_traveling_expense as $total_traveling) {
            $tot_traveling = $tot_traveling + $total_traveling->amount;
        }

        $tot_other = 0;
        foreach ($replacement_other_expense as $total_other) {
            $tot_other = $tot_other + $total_other->amount;
        }
        $tot_a_b = $expense[0]->ta_da_amount * $expense[0]->traveling_days;

        $tot_tra_other = $tot_traveling + $tot_other;
        $total_expense = $tot_a_b + $tot_tra_other;

        Fpdf::Row(array(
            'Amount Taken From Dealer  ',
            ': Rs.  ' . $expense[0]->amount_taken_from_dealer,
            'In Words : ' . ucwords($word_amount_taken_from_dealer)
        ), array('L', 'L', 'L'), '',
            array(),
            '');
        Fpdf::SetWidths(array(40, 140));
        Fpdf::Row(array('Party Name', ': ' . ucwords($expense[0]->party_name)), array('L', 'L'), '',
            array(), '');
        Fpdf::SetWidths(array(40, 50, 50, 40));
        Fpdf::Row(array(
            'Start Tour    ',
            ': Date.  ' . date('d/m/Y', strtotime($expense[0]->traveling_from)),
            'Time.  ' . $replacement_traveling_expense_time_from[0]->time_from,
            'Place : ' . $expense[0]->city_name
        ),
            array('L', 'L', 'L', 'L'), '', array(),
            '');
        Fpdf::Row(array(
            'End Tour    ',
            ': Date.  ' . date('d/m/Y', strtotime($expense[0]->traveling_to)),
            'Time.  ' . $replacement_traveling_expense_time_to[0]->time_to,
            'Place : Rajkot'
        ),
            array('L', 'L', 'L', 'L'), '', array(),
            '');
        Fpdf::SetWidths(array(40, 50, 90));
//        $word_traveling_days = Helper::conver_num_text_money($expense[0]->traveling_days);
        $word_total_expense = Helper::conver_num_text_money($total_expense);

        Fpdf::Row(array(
            'Days Of Tour    ',
            ': ' . $expense[0]->traveling_days,
            'In Words : '
        ), array('L', 'L', 'L'),
            '', array(),
            '');
        Fpdf::Row(array('Total Expense  ', ': Rs.  ' . $total_expense, 'In Words : ' . ucwords($word_total_expense)),
            array('L', 'L', 'L'), '',
            array(),
            '');

        Fpdf::Ln();
        Fpdf::Cell(120, 5, '', 0, 0, 'C');
        Fpdf::Cell(77, 5, 'Accepted By', 1, 1, 'C');
        Fpdf::Cell(120, 5, '', 0, 0, 'C');
        Fpdf::Cell(37, 5, 'Amount', 1, 0, 'C');
        Fpdf::Cell(40, 5, 'Signature', 1, 1, 'C');
        Fpdf::Cell(120, 10, '', 0, 0, 'C');
        Fpdf::Cell(37, 10, $total_expense, 1, 0, 'C');
        Fpdf::Cell(40, 10, '', 1, 1, 'C');
        Fpdf::SetWidths(array(11, 19, 16, 16, 25, 30, 45, 20, 15));
        Fpdf::Row(array(
            'Sr.',
            'Date',
            'Time From',
            'Time To',
            'Holt',
            'Night Hault City',
            'Traveling',
            'Journey',
            'Amt.'
        ), array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '',
            array(),
            true);
        Fpdf::SetFont('Verdana', '', 8);

        $i = 1;
        $traveling_amount = 0;
        foreach ($replacement_traveling_expense as $row_replacement_traveling_expense) {

            Fpdf::Row(array(
                $i++,
                date('d-m-Y', strtotime($row_replacement_traveling_expense->travel_date)),
                $row_replacement_traveling_expense->time_from,
                $row_replacement_traveling_expense->time_to,
                $row_replacement_traveling_expense->hault,
                $row_replacement_traveling_expense->place,
                $row_replacement_traveling_expense->traveling_detail,
                $row_replacement_traveling_expense->journey,
                $row_replacement_traveling_expense->amount
            ), array('C', 'C', 'C', 'C', 'C', 'C', 'L', 'C', 'R'), '',
                array(),
                true);
            $traveling_amount = $traveling_amount + $row_replacement_traveling_expense->amount;
        }
        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        Fpdf::SetWidths(array(7, 135, 55));

        Fpdf::Row(array(

            '',
            'Total',
            $traveling_amount
        ), array('L', 'R', 'R'), '',
            array(),
            true);
        Fpdf::Ln();

        Fpdf::SetWidths(array(7, 135, 55));
        Fpdf::Row(array(
            'Sr.',
            'Other Expense',
            'Amount'
        ), array('C', 'C', 'C'), '',
            array(),
            true);
        Fpdf::SetFont('Verdana', '', 9);
        $o = 1;
        $other_amount = 0;
        foreach ($replacement_other_expense as $row_replacement_other_expense) {

            Fpdf::Row(array(
                $o++,
                $row_replacement_other_expense->detail,
                $row_replacement_other_expense->amount
            ), array('L', 'L', 'R'), '',
                array(),
                true);
            $other_amount = $other_amount + $row_replacement_other_expense->amount;
        }
        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        Fpdf::Row(array(
            '',
            'Total',
            $other_amount
        ), array('C', 'R', 'R'), '',
            array(),
            true);
        $grand_total = $traveling_amount + $other_amount;
        Fpdf::Ln();
        Fpdf::Cell(197, 5, 'Total  Amount : ' . $grand_total, 1, 1, 'C');
        Fpdf::Ln();
        Fpdf::SetWidths(array(30, 30, 30, 30, 30, 47));
        Fpdf::Row(array(
            'Days Of Tour',
            'TADA(FIX)',
            'TADA Exp',
            'Total Amount',
            'Total Exp',
            'Tour Person Sign',
        ), array('C', 'C', 'C', 'C', 'C', 'C'), '',
            array(),
            true);
        Fpdf::SetFont('Verdana', '', 9);

        Fpdf::Row(array(
            $expense[0]->traveling_days,
            $expense[0]->ta_da_amount,
            $a_b = $expense[0]->ta_da_amount * $expense[0]->traveling_days,
            $grand_total,
            $a_b + $grand_total,
            '',
        ), array('C', 'C', 'C', 'C', 'C', 'C'), '',
            array(),
            true);
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 9);

        Fpdf::Cell(65, 8, 'Sender Signature', 1, 0, 'C');
        Fpdf::Cell(65, 8, 'Verified Signature', 1, 0, 'C');
        Fpdf::Cell(67, 8, 'A/C Signature', 1, 1, 'C');
        Fpdf::Cell(65, 10, '', 1, 0, 'C');
        Fpdf::Cell(65, 10, '', 1, 0, 'C');
        Fpdf::Cell(67, 10, '', 1, 1, 'C');
        Fpdf::Ln();


    }

    public
    static function spareExpenseReport($expense_id)
    {
        $complainDetail = DB::table('replacement_expense')
            ->select('complain.*', 'topland.city_master.city_name', 'company_master.company_name',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = complain.financial_id) as fyear"),
                'topland.product_master.product_name', 'complain_item_details.serial_no')
            ->join('complain', 'complain.complain_id', '=', 'replacement_expense.complain_id')
            ->join('complain_item_details', 'complain_item_details.complain_id', '=', 'complain.complain_id')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->join('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'replacement_expense.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('expense_id', $expense_id)
            ->get();
//        echo "<pre>";
//        print_r($complainDetail);exit;
        $productDetail = DB::table('replacement_expense_product_in')
            ->select('topland.product_master.product_name',
                DB::Raw('(select product_name from topland.product_master as a where a.product_id = replacement_expense_product_in.spare_id) as spare_name'))
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_expense_product_in.spare_id')
            ->where('expense_id', $expense_id)
            ->get();

        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetAutoPageBreak(true);

        Fpdf::Cell(190, 5, $complainDetail[0]->company_name, 0, 1, 'C');
        Fpdf::Cell(190, 5, 'INSPECTION REPORT', 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);
        if ($complainDetail[0]->branch_id == 1) {
            $complains_no = 'PF-TKT/' . $complainDetail[0]->fyear . '/' . $complainDetail[0]->complain_no;
        } elseif ($complainDetail[0]->branch_id == 3) {
            $complains_no = 'TE-TKT/' . $complainDetail[0]->fyear . '/' . $complainDetail[0]->complain_no;
        } elseif ($complainDetail[0]->branch_id == 4) {
            $complains_no = 'TP-TKT/' . $complainDetail[0]->fyear . '/' . $complainDetail[0]->complain_no;
        }
        Fpdf::SetWidths(array(95, 95));
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::SetWidths(array(121, 44));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(22, 5, 'TKT. NO :- ', '', 0, 'L');
        Fpdf::Cell(41, 5, $complains_no, 'B', 0, 'L');
        Fpdf::Cell(22, 5, 'TKT. DATE :- ', '', 0, 'L');
        Fpdf::Cell(39, 5, date("d-m-Y", strtotime($complainDetail[0]->created_at)), 'B', 0, 'L');
        Fpdf::Cell(32, 5, 'REPAIRED DATE :- ', '', 0, 'L');
        Fpdf::Cell(28, 5, '', 'B', 0, 'L');
        Fpdf::Ln(8);
        Fpdf::Cell(26, 5, 'PARTY NAME :-', '', 0, 'L');
        Fpdf::Cell(171, 5, $complainDetail[0]->client_name, 'B', 0, 'L');
        Fpdf::Ln(8);
        Fpdf::Cell(12, 5, 'CITY :-', '', 0, 'L');
        Fpdf::Cell(55, 5, $complainDetail[0]->city_name, 'B', 0, 'L');
        Fpdf::Cell(21, 5, 'DISTRICT :-', '', 0, 'L');
        Fpdf::Cell(48, 5, $complainDetail[0]->district, 'B', 0, 'L');
        Fpdf::Cell(15, 5, 'STATE :-', '', 0, 'L');
        Fpdf::Cell(45, 5, $complainDetail[0]->state, 'B', 0, 'L');
        Fpdf::Ln(8);
        Fpdf::Cell(28, 5, 'MODEL NAME :- ', '', 0, 'L');
        Fpdf::Cell(41, 5, $complainDetail[0]->product_name, 'B', 0, 'L');
        Fpdf::Cell(22, 5, 'SERIAL NO :- ', '', 0, 'L');
        Fpdf::Cell(39, 5, $complainDetail[0]->serial_no, 'B', 0, 'L');
        Fpdf::Ln(10);

        Fpdf::SetWidths(array(30, 30, 30, 36, 50, 20));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array('MODEL', 'SERIAL NO', "PARTS", 'COMPLAIN', 'CO.OBSERVATION', 'CHANGE (Y/N)'),
            array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
        $sp_count = 1;
        foreach ($productDetail as $ss) {
            Fpdf::Row(array(
                $ss->product_name,
                '',
//                        ($ss['product_id'] == 27869) ? $ss['description'] : $ss['spare_name'],
                $ss->spare_name,
                '',
                '',
                ''
            ), array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true, 7);
            $sp_count++;
        }
        for ($k = $sp_count; $k <= 22; $k++) {
            Fpdf::Row(array('', '', '', '', '', ''), array('C', 'C', 'C', 'C', 'C', 'C'), '', array(), true, 7);
        }

        Fpdf::Ln(5);
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetWidths(array(95, 95));
        Fpdf::Cell(18, 5, 'FAULT :-', '', 0, 'L');
        Fpdf::Cell(49, 5, '', 'B', 0, 'L');
        Fpdf::Cell(85, 5, 'CHECKED BY :-', '', 0, 'R');
        Fpdf::Cell(45, 5, '', 'B', 0, 'L');
        Fpdf::Ln(10);
        Fpdf::Cell(45, 5, 'COMPANY OBSERVATION :- ', '', 0, 'L');
        Fpdf::CellFitScale(151, 5, '', 'B', 0, 'L');
        Fpdf::Ln(18);


        Fpdf::Cell(5);
        Fpdf::Cell(25, 5, 'DHIRU BHAI. ', '', 0, 'C');
        Fpdf::Cell(14);
        Fpdf::Cell(25, 5, 'MOHAN BHAI. ', '', 0, 'C');
        Fpdf::Cell(14);
        Fpdf::Cell(25, 5, 'SAVJI BHAI. ', '', 0, 'C');
        Fpdf::Cell(14);
        Fpdf::Cell(25, 5, 'NILESH BHAI. ', '', 0, 'C');
        Fpdf::Ln();
    }

    public
    static function advanceReplacementOutPdf($replacement_out_id)
    {
        $advance_replacement = DB::table('advance_replacement_out')
            ->select('company_master.company_name as company', 'advance_replacement_out.*', 'complain.*', 'topland.city_master.city_name', 'topland.transport_master.transport_name',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = advance_replacement_out.financial_id) as fyear"))
            ->leftJoin('complain', 'complain.complain_id', '=', 'advance_replacement_out.complain_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('topland.transport_master', 'topland.transport_master.transport_id', '=', 'advance_replacement_out.transport_id')
            ->leftJoin('branch_master', 'branch_master.branch_id', '=', 'advance_replacement_out.branch_id')
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('advance_replacement_out.replacement_out_id', '=', $replacement_out_id)->first();

        $order_id = $advance_replacement->order_id;
        $company_name = $advance_replacement->company_name;
        $financial_id = $advance_replacement->financial_year;
        $financial_year = DB::table('topland.financial_year')->where('financial_id', $financial_id)->first();
        $year_heading = $financial_year->year_heading;

        if ($company_name === 'PFMA') {
            $order_master = DB::table($year_heading . '.order_master')
                ->select($year_heading . '.order_master.order_auto_id', $year_heading . '.order_master.item_name', $year_heading . '.order_master.order_quantity', $year_heading . '.order_master.order_id', $year_heading . '.order_master.order_type')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get()
                ->toArray();
            $order_master = json_decode(json_encode($order_master), true);

        } elseif ($company_name === 'TEPL') {
            $order_master = DB::table($year_heading . '.engine_order_master')
                ->select($year_heading . '.engine_order_master.order_auto_id', $year_heading . '.engine_order_master.item_name', $year_heading . '.engine_order_master.order_quantity', $year_heading . '.engine_order_master.order_id', $year_heading . '.engine_order_master.order_type')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get()
                ->toArray();
            $order_master = json_decode(json_encode($order_master), true);
        } else {
            $order_master = DB::table($year_heading . '.tppl_order_master')
                ->select($year_heading . '.tppl_order_master.order_auto_id', $year_heading . '.tppl_order_master.item_name', $year_heading . '.tppl_order_master.order_quantity', $year_heading . '.tppl_order_master.order_id', $year_heading . '.tppl_order_master.order_type')
                ->where('order_type', 'Spare')
                ->where('order_id', $order_id)
                ->get()
                ->toArray();
            $order_master = json_decode(json_encode($order_master), true);
        }

        $userName = DB::table('users')
            ->select('users.name')
            ->leftJoin('advance_replacement_out', 'advance_replacement_out.created_id', '=', 'users.user_id')
            ->where('advance_replacement_out.replacement_out_id', '=', $replacement_out_id)
            ->first();

        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::SetFont('Verdana', '', 10);
        Fpdf::Cell(190, 5, $advance_replacement->company, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::Cell(190, 5, 'Advanced Replacement', 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);
        if ($advance_replacement->branch_id == 1) {
            $complains_no = 'PF-TKT/' . $advance_replacement->fyear . '/' . $advance_replacement->complain_no;
        } elseif ($advance_replacement->branch_id == 3) {
            $complains_no = 'TE-TKT/' . $advance_replacement->fyear . '/' . $advance_replacement->complain_no;
        } elseif ($advance_replacement->branch_id == 4) {
            $complains_no = 'TP-TKT/' . $advance_replacement->fyear . '/' . $advance_replacement->complain_no;
        }
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Cell(190, 5, 'Complain No : ' . $complains_no, 0, 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(190, 5, 'Complain Date : ' . date('d/m/Y', strtotime($advance_replacement->created_at)), 0, 0, 'R');
        Fpdf::Ln();
        Fpdf::SetWidths(array(95, 95));

        Fpdf::SetFont('Verdana', '', 8);
        /** print address */
        Fpdf::Row(array(
            (trim($advance_replacement->client_name) . "\n" . $advance_replacement->address . "\n" . trim($advance_replacement->city_name) . "\n" . trim($advance_replacement->district) . "\n" . trim($advance_replacement->state)),
            'Financial Year : ' . $financial_year->fyear . "\n" . 'Company Type : ' . $advance_replacement->company_name . "\n" . 'Order No. : ' . $advance_replacement->order_id . "\n" . 'Transport : ' . $advance_replacement->transport_name . "\n" . 'Billty No. :' . $advance_replacement->billty_no . "\n" . 'LR No. :' . $advance_replacement->lr_no . "\n" . 'Lory No. :' . $advance_replacement->lory_no . "\n" . 'Mobile No. :' . $advance_replacement->mobile_no
        ), array('L', 'L'), '', '', true, 4);

        Fpdf::Ln();

        Fpdf::SetWidths(array(10, 158, 22));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array('No.', "Item Description", 'Qty'), array('C', 'C', 'C'), '', array(), true);
        Fpdf::SetFont('Verdana', '', 8);


        $ac_grand_total = 0;
        Fpdf::SetFont('Verdana', '', 8);
        $temp = 0;
        foreach ($order_master as $value) {
            $temp++;
            Fpdf::Row(array($temp, $value['item_name'], $value['order_quantity']), array('C', 'L', 'C'), '',
                array(), true);
            $ac_grand_total += $value['order_quantity'];
        }
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array('', 'Total Qty', $ac_grand_total), array('C', 'L', 'C'), '', array(), true, 4);
        Fpdf::Ln(8);
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Cell(190, 5, $userName->name, 0, 0, 'C');


        $product_inward = DB::table('replacement_product_in')
            ->select('topland.product_master.product_name', 'replacement_product_in.qty', 'advance_replacement_in.*', 'topland.transport_master.transport_name')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'replacement_product_in.product_id')
            ->join('advance_replacement_in', 'advance_replacement_in.replacement_in_id', '=', 'replacement_product_in.replacement_in_id')
            ->join('topland.transport_master', 'topland.transport_master.transport_id', '=', 'advance_replacement_in.transport_id')
            ->where('advance_replacement_in.replacement_out_id', '=', $replacement_out_id)
            ->get();
        if (!empty($product_inward[0]->replacement_in_id)) {
            Fpdf::AliasNbPages();
            Fpdf::AddPage();
            Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
            Fpdf::AddFont('Verdana', '', 'Verdana.php');
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::SetAutoPageBreak(true);

            Fpdf::SetFont('Verdana', '', 10);
            Fpdf::Cell(190, 5, $advance_replacement->company_name, 0, 0, 'C');
            Fpdf::Ln();
            Fpdf::SetFont('Verdana-Bold', 'B', 10);
            Fpdf::Cell(190, 5, 'Advance Replacement Product Inward', 0, 0, 'C');
            Fpdf::Ln();
            Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(190, 5, 'Complain No :' . $complains_no, 0, 0, 'R');
            Fpdf::Ln();
            Fpdf::Cell(190, 5, 'Complain Date : ' . date('d/m/Y', strtotime($advance_replacement->created_at)), 0, 0, 'R');
            Fpdf::Ln();
            Fpdf::SetWidths(array(95, 95));

            Fpdf::SetFont('Verdana', '', 8);
            /** print address */
            Fpdf::Row(array(
                (trim($advance_replacement->client_name) . "\n" . $advance_replacement->address . "\n" . trim($advance_replacement->city_name) . "\n" . trim($advance_replacement->district) . "\n" . trim($advance_replacement->state)),
                'Company Type : ' . $advance_replacement->company_name . "\n" . 'Order No. : ' . $advance_replacement->order_id . "\n" . 'Transport : ' . $product_inward[0]->transport_name . "\n" . 'Billty No. :' . $product_inward[0]->billty_no . "\n" . 'Bill No. :' . $product_inward[0]->bill_no . "\n" . 'Inward Date. :' . date('d/m/Y', strtotime($product_inward[0]->inward_date))
            ), array('L', 'L'), '', '', true, 4);
            Fpdf::Ln();

            if (!empty($product_inward)) {
                $ac_grand_total = 0;
                Fpdf::SetWidths(array(10, 158, 22));
                Fpdf::SetFont('Verdana-Bold', 'B', 8);
                Fpdf::Ln();
                Fpdf::Row(array('No.', 'Item Description', "Qty"), array('C', 'C', 'C'), '', array(), true);
                Fpdf::SetFont('Verdana', '', 8);
                $temp = 0;
                foreach ($product_inward as $value) {
                    $temp++;
                    Fpdf::Row(array($temp, $value->product_name, $value->qty), array('C', 'L', 'C'), '',
                        array(), true);
                    $ac_grand_total += $value->qty;
                }
                Fpdf::SetFont('Verdana-Bold', 'B', 8);
                Fpdf::Row(array('', 'Total Qty', $ac_grand_total), array('C', 'L', 'C'), '', array(), true, 4);
                Fpdf::Ln();
            }
            Fpdf::Ln(8);
            Fpdf::SetFont('Verdana', '', 8);
            Fpdf::Cell(190, 5, $userName->name, 0, 0, 'C');
        }
    }

    public
    static function deliveryChallanOutReport($delivery_challan_out_id)
    {
        $total_rows = 20;
        $company_detail = DB::table('delivery_challan_out')
            ->select('company_master.company_name', 'company_master.phone as phne', 'company_master.address1 as c_a1', 'company_master.address2 as c_a2', 'company_master.address3 as c_a3', 'topland.city_master.city_name',
                'delivery_challan_out.lr_no', 'complain.client_name', 'complain.district as dis', 'complain.state as stat', 'complain.complain_no', 'complain.created_at as complain_date', 'topland.district_master.district_name',
                'delivery_challan_out.delivery_challan_no', 'delivery_challan_out.despatched_through', 'delivery_challan_out.destination', 'delivery_challan_out.transport_vehicle',
                'topland.state_master.state_name', 'challan.*', 'branch_master.gst_no',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = delivery_challan_out.financial_id) as fyear"))
            ->join('challan', 'challan.challan_id', '=', 'delivery_challan_out.challan_id')
            ->join('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->join('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->join('branch_master', 'branch_master.branch_id', '=', 'complain.branch_id')
            ->join('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->join('topland.city_master', 'topland.city_master.city_id', '=', 'company_master.city_id')
            ->join('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->join('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('delivery_challan_out.delivery_challan_out_id', '=', $delivery_challan_out_id)
            ->first();

        $supplierList = DB::table('delivery_challan_out')
            ->select('topland.supplier_master.*')
            ->join('topland.supplier_master', 'topland.supplier_master.supplier_id', '=', 'delivery_challan_out.supplier_id')
            ->where('delivery_challan_out.delivery_challan_out_id', '=', $delivery_challan_out_id)
            ->first();

        $product_list = DB::table('delivery_challan_out_product')
            ->select('topland.product_master.*', 'delivery_challan_out_product.*', 'topland.category_master.*', 'challan_item_master.*', 'topland.brand_master.*', DB::raw('challan_item_master.quantity as quantity'), 'complain_item_details.*')
            ->join('challan_item_master', 'challan_item_master.challan_product_id', '=', 'delivery_challan_out_product.challan_product_id')
            ->join('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
            ->join('topland.category_master', 'topland.category_master.category_id', '=', 'complain_item_details.category_id')
            ->join('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id')
            ->where('delivery_challan_out_id', '=', $delivery_challan_out_id)
            ->get();
//print_r($product_list);exit();
        $quantity = 0;
        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

        Fpdf::Ln();
        if ($company_detail->branch_id == 1) {
            $complains_no = 'PF-TKT/' . $company_detail->fyear . '/' . $company_detail->complain_no;
        } elseif ($company_detail->branch_id == 3) {
            $complains_no = 'TE-TKT/' . $company_detail->fyear . '/' . $company_detail->complain_no;
        } elseif ($company_detail->branch_id == 4) {
            $complains_no = 'TP-TKT/' . $company_detail->fyear . '/' . $company_detail->complain_no;
        }
        if ($company_detail->branch_id == 1) {
            $delivery_challan_no = 'PF-DC/' . $company_detail->fyear . '/' . $company_detail->delivery_challan_no;
        } elseif ($company_detail->branch_id == 3) {
            $delivery_challan_no = 'TE-DC/' . $company_detail->fyear . '/' . $company_detail->delivery_challan_no;
        } elseif ($company_detail->branch_id == 4) {
            $delivery_challan_no = 'TP-DC/' . $company_detail->fyear . '/' . $company_detail->delivery_challan_no;
        }
        Fpdf::SetWidths(array(10, 10, 10));
        Fpdf::SetFont('Verdana', '', 10);
        Fpdf::Cell(190, 5, $company_detail->company_name, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::Cell(190, 5, 'Delivery Challan', 0, 0, 'C');
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Ln(8);
        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        Fpdf::Cell(97, 4, 'Consigner', 'TRL', 0);
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Cell(41, 4, 'DC No :- ', 1, 0, 'L');
        Fpdf::Cell(56, 4, $delivery_challan_no, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company_detail->company_name, 'RL', 0);
        Fpdf::Cell(41, 4, 'Complain No :- ', 1, 0, 'L');
        Fpdf::Cell(56, 4, $complains_no, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company_detail->c_a1, 'RL', 0);
        Fpdf::Cell(41, 4, 'Complain Date :-', 1, 0, 'L');
        Fpdf::Cell(56, 4, date("d-m-Y", strtotime($company_detail->complain_date)), 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company_detail->c_a2 . ' - ' . $company_detail->c_a3, 'RL', 0);
        Fpdf::Cell(41, 4, "Dispatch through :-", 1, 0, 'L');
        Fpdf::Cell(56, 4, $company_detail->despatched_through, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4,
            'City :- ' . $company_detail->city_name . '  Dist :- ' . $company_detail->district_name . '  State :- ' . $company_detail->state_name,
            'RL', 0);
        Fpdf::Cell(41, 4, 'Destination :-', 1, 0, 'L');
        Fpdf::Cell(56, 4, $company_detail->destination, 1, 0, 'L');

        Fpdf::Ln();
        Fpdf::Cell(97, 4, 'Phone No. :- ' . $company_detail->phne, 'RL', 0);
        Fpdf::Cell(41, 4, 'Motor Vehicle No :-', 1, 0, 'L');
        Fpdf::Cell(56, 4, $company_detail->transport_vehicle, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, 'GSTIN  :- ' . $company_detail->gst_no, 'RL', 0);
        Fpdf::Cell(41, 4, 'LR NO. :-', 1, 0, 'L');
        Fpdf::Cell(56, 4, $company_detail->lr_no, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, '', 'RLB', 0);
        Fpdf::Cell(41, 4, '', 1, 0, 'L');
        Fpdf::Cell(56, 4, '', 1, 0, 'L');

        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        Fpdf::Cell(97, 4, "Supplier", 'LR', 0);
        Fpdf::Cell(97, 4, "Terms of Delivery", 'LR', 0);
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Ln();
        Fpdf::SetWidths(array(97, 97));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);

        /** print address */
        $part1 = strtoupper($supplierList->supplier_name) . "\n" . strtoupper($supplierList->address1) . "\n" . 'City :- ' . trim($supplierList->city) . "\n" . 'District :- ' . trim($supplierList->district) . "\n" . 'State :- ' . trim($supplierList->state) . "\n" . 'PinCode :- ' . trim($supplierList->pincode) . "\n" . 'Tel.No :- ' . trim($supplierList->mobile) . "\n" . 'GSTIN :- ' . trim($supplierList->gstin);
        $part2 = "\n" . "**** THIS GOODS SEND FOR REPAIRING PURPOSE NOT FOR SALE ****";

        Fpdf::Row(array($part1, $part2), array('L', 'L'), '', array('', 'B'), true);

        Fpdf::SetFont('Verdana-Bold', 'B', 8);

        Fpdf::SetWidths(array(15, 76, 50, 15));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetFont('Verdana', '', 8);

        Fpdf::SetWidths(array(10, 50, 20, 10));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetWidths(array(5, 7, 50, 15, 20, 26));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(10, 5, 'No', 'TL', 0, 'C');
        Fpdf::Cell(75, 5, 'Description of Goods', 'TL', 0, 'C');
        Fpdf::Cell(20, 5, 'HSN', 'TL', 0, 'C');
        Fpdf::Cell(15, 5, 'CGST', 'TLR', 0, 'C');
        Fpdf::Cell(15, 5, 'SGST', 'TLR', 0, 'C');
        Fpdf::Cell(15, 5, 'QTY', 'TL', 0, 'C');
        Fpdf::Cell(15, 5, 'RATE', 'TL', 0, 'C');
        Fpdf::Cell(29, 5, 'TOTAL', 'TLR', 0, 'C');
        Fpdf::Ln();
        Fpdf::SetWidths(array(10, 75, 20, 15, 15, 15, 15, 29));
        Fpdf::SetFont('Verdana', '', 9);
        if (!empty($product_list)) {
            $temp = 1;
            $header_string = "";
            $lasttotal_qty = 0;
            $lasttotal_total = 0;
            $lasttotal_sgst = 0;
            $lasttotal_cgst = 0;
            $lasttotal_finaltotal = 0;
            $allArray = array();
            foreach ($product_list as $row) {
                $category_id = $row->category_id;
                $complain_product_id = $row->complain_product_id;
//                echo "<pre>";
//                print_r($complain_product_id);exit();
                $product_data = DB::table('challan_item_master')
                    ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
                    ->leftJoin('topland.new_single_price_list', 'topland.new_single_price_list.product_id', '=', 'complain_item_details.product_id')
                    ->where('complain_item_details.cid_id', '=', $complain_product_id)
                    ->where('topland.new_single_price_list.price_date', '=', '2017-07-01')
                    ->get();
                $new_header_string = '';
                if ($header_string != $new_header_string) {
                    Fpdf::SetWidths(array(194));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array($new_header_string), array('C'), '', '', true);
                    $header_string = $new_header_string;
                    Fpdf::SetWidths(array(10, 75, 20, 15, 15, 15, 15, 29));
                    $total_rows -= 1;
                }
                $opt_item = '';

                if ($row->packing_type == 'loose') {
                    $product_price = $product_data[0]->loose_price;
                } elseif ($row->packing_type == 'packing') {
                    $product_price = $product_data[0]->packing_price;
                } else {
                    $product_price = $product_data[0]->skd_price;
                }

                Fpdf::SetFont('Verdana', '', 8);
                $total = $product_price * $row->quantity;
                $sgst = $row->sgst_rate;
                $sgst_total = $product_price * $sgst / 100;
                $cgst = $row->cgst_rate;
                $cgst_total = $product_price * $cgst / 100;
                $finaltotal = $total;
                $lasttotal_qty = $lasttotal_qty + $row->quantity;
                $lasttotal_total = $lasttotal_total + $total;
                $lasttotal_sgst = $lasttotal_sgst + $sgst_total;
                $lasttotal_cgst = $lasttotal_cgst + $cgst_total;
                $lasttotal_finaltotal = $lasttotal_finaltotal + $finaltotal;

                if (!empty($row->serial_no)) {
                    $ser = 'Serial No. : ' . $row->serial_no . '';
                } else {
                    $ser = '';
                }
                Fpdf::Row(array(
                    $temp,
                    $row->product_name . $opt_item . "\n" . $ser,
                    $row->cetsh_hsn,
                    $row->cgst_rate . '%',
                    $row->sgst_rate . '%',
                    $row->quantity . ' Nos.',
                    $product_price,
                    number_format($finaltotal, 2)
                ), array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
                array_push($allArray, array('hsn' => $row->cetsh_hsn, 'qty' => $row->quantity, 'price' => $finaltotal, 'cgst' => $row->cgst_rate, 'sgst' => $row->sgst_rate
                ));
                $temp++;
                $quantity += $row->quantity;
                $total_rows -= 1;
            }


            $price = array();
            foreach ($allArray as $key => $r) {
                $price[$key] = $r['hsn'];
            }
            array_multisort($price, SORT_ASC, $allArray);
            $arrayLength = sizeof($allArray);
            $newArray = [];
            array_push($newArray, array('hsn' => $allArray[0]['hsn'], 'qty' => $allArray[0]['qty'], 'price' => $allArray[0]['price'], 'cgst' => $allArray[0]['cgst'], 'sgst' => $allArray[0]['sgst']));

            for ($i = 1; $i < $arrayLength; $i++) {
                $lastValue = end($newArray);
                if ($allArray[$i]['hsn'] == $lastValue['hsn']) {
                    if ($allArray[$i]['cgst'] == $lastValue['cgst']) {
                        $priceWithQty = $allArray[$i]['price'];
                        $newPrice = $priceWithQty + $lastValue['price'];
                        $newQty = $allArray[$i]['qty'] + $lastValue['qty'];
                        array_pop($newArray);
                        if ($allArray[$i]['qty'] > 1) {
                            array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $newQty, 'price' => $newPrice, 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                        } else {
                            array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $newQty, 'price' => $newPrice, 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                        }
                    } else {
                        array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $allArray[$i]['qty'], 'price' => $allArray[$i]['price'], 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                    }
                } else {
                    array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $allArray[$i]['qty'], 'price' => $allArray[$i]['price'], 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                }
            }

        }

//        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        for ($s = 1; $s <= $total_rows; $s++) {
            Fpdf::Cell(10, 5, '', 'L', 0, 'C');
            Fpdf::Cell(75, 5, '', 'L', 0, 'C');
            Fpdf::Cell(20, 5, '', 'L', 0, 'C');
            Fpdf::Cell(15, 5, '', 'L', 0, 'C');
            Fpdf::Cell(15, 5, '', 'L', 0, 'C');
            Fpdf::Cell(15, 5, '', 'L', 0, 'C');
            Fpdf::Cell(15, 5, '', 'L', 0, 'C');
            Fpdf::Cell(29, 5, '', 'LR', 1, 'C');
        }
        Fpdf::Row(array(
            '',
            'Total',
            '',
            '',
            $lasttotal_qty,
            '',
            '',
            $lasttotal_finaltotal,
        ),
            array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);

        $round_off = abs(round($lasttotal_finaltotal) - $lasttotal_finaltotal);
        Fpdf::SetWidths(array(30, 44, 25, 35, 25, 35));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array(
            'HSN',
            'Taxable Value',
            'SGST (%)',
            'SGST Value',
            'CGST (%)',
            'CGST Value '
        ),
            array('C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
        Fpdf::SetFont('Verdana', '', 9);
        $taxTotal = 0;
        $sgstTotal = 0;
        $cgstTotal = 0;
        foreach ($newArray as $key => $value) {

            $totalGst = $value['cgst'] + $value['sgst'];
            $price = $value['price'];
            $lastTotal = round($price / (1 + ($totalGst / 100)));
            $cgstPrice = ($lastTotal * $value['cgst']) / 100;
            $sgstPrice = ($lastTotal * $value['sgst']) / 100;

            Fpdf::Row(array(
                $value['hsn'],
                $lastTotal,
                $value['sgst'] . '%',
                round($sgstPrice),
                $value['cgst'] . '%',
                round($cgstPrice)
            ),
                array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
            $taxTotal += $lastTotal;
            $sgstTotal += round($sgstPrice);
            $cgstTotal += round($cgstPrice);
        }

        Fpdf::Row(array(
            'Total',
            $taxTotal,
            '',
            $sgstTotal,
            '',
            $cgstTotal
        ),
            array('R', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);

        Fpdf::SetWidths(array(154, 40));
        Fpdf::Row(array(
            'Delivery Challan Total INR',
            '  Rs.  ' . number_format(round($lasttotal_finaltotal), 2)
        ), array('R', 'L'), false, '', true);
        Fpdf::SetWidths(array(194));
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Row(array('TOTAL AMOUNT IN WORDS INR: ' . strtoupper(Helper::conver_num_text_money(round($lasttotal_finaltotal)))),
            array('L'), false, '', true);

        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(194, 5, 'For, ' . $company_detail->company_name, 'LTR', 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(194, 5, 'Authorised Sign .', 'LR', 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(194, 5, '', 'LR', 0, 'R');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(194, 5, 'Recd. in Good Condition', 'LBR', 0);
        Fpdf::Ln();
    }

    public
    static function deliveryChallanInReport($delivery_challan_out_id)
    {
        $total_rows = 20;
        $company_detail = DB::table('delivery_challan_out')
            ->select('company_master.company_name', 'company_master.phone as phne', 'company_master.address1 as c_a1', 'company_master.address2 as c_a2', 'company_master.address3 as c_a3', 'topland.city_master.city_name',
                'delivery_challan_out.lr_no', 'complain.client_name', 'complain.district as dis', 'complain.state as stat', 'complain.complain_no', 'complain.created_at as complain_date', 'topland.district_master.district_name',
                'delivery_challan_out.delivery_challan_no', 'delivery_challan_out.despatched_through', 'delivery_challan_out.destination', 'delivery_challan_out.transport_vehicle',
                'topland.state_master.state_name', 'challan.*', 'branch_master.gst_no',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = delivery_challan_out.financial_id) as fyear"))
            ->join('challan', 'challan.challan_id', '=', 'delivery_challan_out.challan_id')
            ->join('billty', 'billty.billty_id', '=', 'challan.billty_id')
            ->join('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->join('branch_master', 'branch_master.branch_id', '=', 'complain.branch_id')
            ->join('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->join('topland.city_master', 'topland.city_master.city_id', '=', 'company_master.city_id')
            ->join('topland.district_master', 'topland.district_master.district_id', '=', 'topland.city_master.district_id')
            ->join('topland.state_master', 'topland.state_master.state_id', '=', 'topland.district_master.state_id')
            ->where('delivery_challan_out.delivery_challan_out_id', '=', $delivery_challan_out_id)
            ->first();

        $supplierList = DB::table('delivery_challan_out')
            ->select('topland.supplier_master.*')
            ->join('topland.supplier_master', 'topland.supplier_master.supplier_id', '=', 'delivery_challan_out.supplier_id')
            ->where('delivery_challan_out.delivery_challan_out_id', '=', $delivery_challan_out_id)
            ->first();

        $product_list = DB::table('delivery_challan_out_product')
            ->select('topland.product_master.*', 'topland.category_master.*', 'delivery_challan_out_product.*', 'challan_item_master.*', 'topland.brand_master.*', DB::raw('1 as quantity'))
            ->join('challan_item_master', 'challan_item_master.challan_product_id', '=', 'delivery_challan_out_product.challan_product_id')
            ->join('topland.category_master', 'topland.category_master.category_id', '=', 'challan_item_master.category_id')
            ->join('topland.brand_master', 'topland.brand_master.brand_id', '=', 'challan_item_master.brand_id')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id')
            ->where('delivery_challan_out_id', '=', $delivery_challan_out_id)
            ->where('delivery_challan_out_product.is_inward', '=', 'Y')
            ->get();


        $quantity = 0;
        Fpdf::AliasNbPages();
        Fpdf::AddPage();
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Image("./images/LogoWatera.jpg", 32, 60, 150, 0);

        Fpdf::Ln();
        if ($company_detail->branch_id == 1) {
            $complains_no = 'PF-TKT/' . $company_detail->fyear . '/' . $company_detail->complain_no;
        } elseif ($company_detail->branch_id == 3) {
            $complains_no = 'TE-TKT/' . $company_detail->fyear . '/' . $company_detail->complain_no;
        } elseif ($company_detail->branch_id == 4) {
            $complains_no = 'TP-TKT/' . $company_detail->fyear . '/' . $company_detail->complain_no;
        }
        if ($company_detail->branch_id == 1) {
            $delivery_challan_no = 'PF-DC/' . $company_detail->fyear . '/' . $company_detail->delivery_challan_no;
        } elseif ($company_detail->branch_id == 3) {
            $delivery_challan_no = 'TE-DC/' . $company_detail->fyear . '/' . $company_detail->delivery_challan_no;
        } elseif ($company_detail->branch_id == 4) {
            $delivery_challan_no = 'TP-DC/' . $company_detail->fyear . '/' . $company_detail->delivery_challan_no;
        }
        Fpdf::SetWidths(array(10, 10, 10));
        Fpdf::SetFont('Verdana', '', 10);
        Fpdf::Cell(190, 5, $company_detail->company_name, 0, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 10);
        Fpdf::Cell(190, 5, 'Delivery Challan Inward', 0, 0, 'C');
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Ln(8);
        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        Fpdf::Cell(97, 4, 'Consigner', 'TRL', 0);
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Cell(41, 4, 'DC No :- ', 1, 0, 'L');
        Fpdf::Cell(56, 4, $delivery_challan_no, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company_detail->company_name, 'RL', 0);
        Fpdf::Cell(41, 4, 'Complain No :- ', 1, 0, 'L');
        Fpdf::Cell(56, 4, $complains_no, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company_detail->c_a1, 'RL', 0);
        Fpdf::Cell(41, 4, 'Complain Date :-', 1, 0, 'L');
        Fpdf::Cell(56, 4, date("d-m-Y", strtotime($company_detail->complain_date)), 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, $company_detail->c_a2 . ' - ' . $company_detail->c_a3, 'RL', 0);
        Fpdf::Cell(41, 4, "Despatched through :-", 1, 0, 'L');
        Fpdf::Cell(56, 4, $company_detail->despatched_through, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4,
            'City :- ' . $company_detail->city_name . '  Dist :- ' . $company_detail->district_name . '  State :- ' . $company_detail->state_name,
            'RL', 0);
        Fpdf::Cell(41, 4, 'Destination :-', 1, 0, 'L');
        Fpdf::Cell(56, 4, $company_detail->destination, 1, 0, 'L');

        Fpdf::Ln();
        Fpdf::Cell(97, 4, 'Phone No. :- ' . $company_detail->phne, 'RL', 0);
        Fpdf::Cell(41, 4, 'Motor Vehicle No :-', 1, 0, 'L');
        Fpdf::Cell(56, 4, $company_detail->transport_vehicle, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, 'GSTIN  :- ' . $company_detail->gst_no, 'RL', 0);
        Fpdf::Cell(41, 4, 'LR NO. :-', 1, 0, 'L');
        Fpdf::Cell(56, 4, $company_detail->lr_no, 1, 0, 'L');
        Fpdf::Ln();
        Fpdf::Cell(97, 4, '', 'RLB', 0);
        Fpdf::Cell(41, 4, '', 1, 0, 'L');
        Fpdf::Cell(56, 4, '', 1, 0, 'L');

        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        Fpdf::Cell(97, 4, "Supplier", 'LR', 0);
        Fpdf::Cell(97, 4, "Terms of Delivery", 'LR', 0);
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Ln();
        Fpdf::SetWidths(array(97, 97));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);

        /** print address */
        $part1 = strtoupper($supplierList->supplier_name) . "\n" . strtoupper($supplierList->address1) . "\n" . 'City :- ' . trim($supplierList->city) . "\n" . 'District :- ' . trim($supplierList->district) . "\n" . 'State :- ' . trim($supplierList->state) . "\n" . 'PinCode :- ' . trim($supplierList->pincode) . "\n" . 'Tel.No :- ' . trim($supplierList->mobile) . "\n" . 'GSTIN :- ' . trim($supplierList->gstin);
        $part2 = "\n" . "**** THIS GOODS SEND FOR REPAIRING PURPOSE NOT FOR SALE ****";

        Fpdf::Row(array($part1, $part2), array('L', 'L'), '', array('', 'B'), true);

        Fpdf::SetFont('Verdana-Bold', 'B', 8);

        Fpdf::SetWidths(array(15, 76, 50, 15));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetFont('Verdana', '', 8);

        Fpdf::SetWidths(array(10, 50, 20, 10));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::SetWidths(array(5, 7, 50, 15, 20, 26));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(10, 5, 'No', 'TL', 0, 'C');
        Fpdf::Cell(75, 5, 'Description of Goods', 'TL', 0, 'C');
        Fpdf::Cell(20, 5, 'HSN', 'TL', 0, 'C');
        Fpdf::Cell(15, 5, 'CGST', 'TLR', 0, 'C');
        Fpdf::Cell(15, 5, 'SGST', 'TLR', 0, 'C');
        Fpdf::Cell(15, 5, 'QTY', 'TL', 0, 'C');
        Fpdf::Cell(15, 5, 'RATE', 'TL', 0, 'C');
        Fpdf::Cell(29, 5, 'TOTAL', 'TLR', 0, 'C');
        Fpdf::Ln();
        Fpdf::SetWidths(array(10, 75, 20, 15, 15, 15, 15, 29));
        Fpdf::SetFont('Verdana', '', 9);
        if (!empty($product_list)) {
            $temp = 1;
            $header_string = "";
            $lasttotal_qty = 0;
            $lasttotal_total = 0;
            $lasttotal_sgst = 0;
            $lasttotal_cgst = 0;
            $lasttotal_finaltotal = 0;
            $allArray = array();
            foreach ($product_list as $row) {
                $category_id = $row->category_id;
                $complain_product_id = $row->complain_product_id;
                $product_data = DB::table('challan_item_master')
                    ->leftJoin('complain_item_details', 'complain_item_details.cid_id', '=', 'challan_item_master.complain_product_id')
                    ->leftJoin('topland.new_single_price_list', 'topland.new_single_price_list.product_id', '=', 'complain_item_details.product_id')
                    ->where('complain_item_details.cid_id', '=', $complain_product_id)
                    ->where('topland.new_single_price_list.price_date', '=', '2017-07-01')
                    ->get();
                $new_header_string = '';
                if ($header_string != $new_header_string) {
                    Fpdf::SetWidths(array(194));
                    Fpdf::SetFont('Verdana-Bold', 'B', 8);
                    Fpdf::Row(array($new_header_string), array('C'), '', '', true);
                    $header_string = $new_header_string;
                    Fpdf::SetWidths(array(10, 75, 20, 15, 15, 15, 15, 29));
                    $total_rows -= 1;
                }
                $opt_item = '';

                if ($row->packing_type == 'loose') {
                    $product_price = $product_data[0]->loose_price;
                } elseif ($row->packing_type == 'packing') {
                    $product_price = $product_data[0]->packing_price;
                } else {
                    $product_price = $product_data[0]->skd_price;
                }

                Fpdf::SetFont('Verdana', '', 8);
                $total = $product_price * $row->quantity;
                $sgst = $row->sgst_rate;
                $sgst_total = $product_price * $sgst / 100;
                $cgst = $row->cgst_rate;
                $cgst_total = $product_price * $cgst / 100;
                $finaltotal = $total;
                $lasttotal_qty = $lasttotal_qty + $row->quantity;
                $lasttotal_total = $lasttotal_total + $total;
                $lasttotal_sgst = $lasttotal_sgst + $sgst_total;
                $lasttotal_cgst = $lasttotal_cgst + $cgst_total;
                $lasttotal_finaltotal = $lasttotal_finaltotal + $finaltotal;

                if (!empty($row->serial_no)) {
                    $ser = 'Serial No. : ' . $row->serial_no . '';
                } else {
                    $ser = '';
                }
                Fpdf::Row(array(
                    $temp,
                    $row->product_name . $opt_item . "\n" . $ser . "\n" . 'Inward Date : ' . date("d-m-Y", strtotime($product_list[0]->inward_date)),
                    $row->cetsh_hsn,
                    $row->cgst_rate . '%',
                    $row->sgst_rate . '%',
                    $row->quantity . ' Nos.',
                    $product_price,
                    number_format($finaltotal, 2)
                ), array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
                array_push($allArray, array('hsn' => $row->cetsh_hsn, 'qty' => $row->quantity, 'price' => $finaltotal, 'cgst' => $row->cgst_rate, 'sgst' => $row->sgst_rate
                ));
                $temp++;
                $quantity += $row->quantity;
                $total_rows -= 1;
            }


            $price = array();
            foreach ($allArray as $key => $r) {
                $price[$key] = $r['hsn'];
            }
            array_multisort($price, SORT_ASC, $allArray);
            $arrayLength = sizeof($allArray);
            $newArray = [];
            array_push($newArray, array('hsn' => $allArray[0]['hsn'], 'qty' => $allArray[0]['qty'], 'price' => $allArray[0]['price'], 'cgst' => $allArray[0]['cgst'], 'sgst' => $allArray[0]['sgst']));

            for ($i = 1; $i < $arrayLength; $i++) {
                $lastValue = end($newArray);
                if ($allArray[$i]['hsn'] == $lastValue['hsn']) {
                    if ($allArray[$i]['cgst'] == $lastValue['cgst']) {
                        $priceWithQty = $allArray[$i]['price'];
                        $newPrice = $priceWithQty + $lastValue['price'];
                        $newQty = $allArray[$i]['qty'] + $lastValue['qty'];
                        array_pop($newArray);
                        if ($allArray[$i]['qty'] > 1) {
                            array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $newQty, 'price' => $newPrice, 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                        } else {
                            array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $newQty, 'price' => $newPrice, 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                        }
                    } else {
                        array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $allArray[$i]['qty'], 'price' => $allArray[$i]['price'], 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                    }
                } else {
                    array_push($newArray, array('hsn' => $allArray[$i]['hsn'], 'qty' => $allArray[$i]['qty'], 'price' => $allArray[$i]['price'], 'cgst' => $allArray[$i]['cgst'], 'sgst' => $allArray[$i]['sgst']));
                }
            }

        }

//        Fpdf::SetFont('Verdana-Bold', 'B', 9);
        for ($s = 1; $s <= $total_rows; $s++) {
            Fpdf::Cell(10, 5, '', 'L', 0, 'C');
            Fpdf::Cell(75, 5, '', 'L', 0, 'C');
            Fpdf::Cell(20, 5, '', 'L', 0, 'C');
            Fpdf::Cell(15, 5, '', 'L', 0, 'C');
            Fpdf::Cell(15, 5, '', 'L', 0, 'C');
            Fpdf::Cell(15, 5, '', 'L', 0, 'C');
            Fpdf::Cell(15, 5, '', 'L', 0, 'C');
            Fpdf::Cell(29, 5, '', 'LR', 1, 'C');
        }
        Fpdf::Row(array(
            '',
            'Total',
            '',
            '',
            $lasttotal_qty,
            '',
            '',
            $lasttotal_finaltotal,
        ),
            array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);

        $round_off = abs(round($lasttotal_finaltotal) - $lasttotal_finaltotal);
        Fpdf::SetWidths(array(30, 44, 25, 35, 25, 35));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array(
            'HSN',
            'Taxable Value',
            'SGST (%)',
            'SGST Value',
            'CGST (%)',
            'CGST Value '
        ),
            array('C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
        Fpdf::SetFont('Verdana', '', 9);
        $taxTotal = 0;
        $sgstTotal = 0;
        $cgstTotal = 0;
        foreach ($newArray as $key => $value) {

            $totalGst = $value['cgst'] + $value['sgst'];
            $price = $value['price'];
            $lastTotal = round($price / (1 + ($totalGst / 100)));
            $cgstPrice = ($lastTotal * $value['cgst']) / 100;
            $sgstPrice = ($lastTotal * $value['sgst']) / 100;

            Fpdf::Row(array(
                $value['hsn'],
                $lastTotal,
                $value['sgst'] . '%',
                round($sgstPrice),
                $value['cgst'] . '%',
                round($cgstPrice)
            ),
                array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
            $taxTotal += $lastTotal;
            $sgstTotal += round($sgstPrice);
            $cgstTotal += round($cgstPrice);
        }

        Fpdf::Row(array(
            'Total',
            $taxTotal,
            '',
            $sgstTotal,
            '',
            $cgstTotal
        ),
            array('R', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);

        Fpdf::SetWidths(array(154, 40));
        Fpdf::Row(array(
            'Delivery Challan Total INR',
            '  Rs.  ' . number_format(round($lasttotal_finaltotal), 2)
        ), array('R', 'L'), false, '', true);
        Fpdf::SetWidths(array(194));
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::Row(array('TOTAL AMOUNT IN WORDS INR: ' . strtoupper(Helper::conver_num_text_money(round($lasttotal_finaltotal)))),
            array('L'), false, '', true);

        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(194, 5, 'For, ' . $company_detail->company_name, 'LTR', 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(194, 5, 'Authorised Sign .', 'LR', 0, 'R');
        Fpdf::Ln();
        Fpdf::Cell(194, 5, '', 'LR', 0, 'R');
        Fpdf::Ln();
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Cell(194, 5, 'Recd. in Good Condition', 'LBR', 0);
        Fpdf::Ln();
    }

}
