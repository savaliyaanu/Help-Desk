<?php

namespace App\Http\Controllers;

use App\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateNumbertoYearChange extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $branch_id = Auth::user()->branch_id;
        $complain_detail = DB::select("SELECT
	complain.*, (
		SELECT
			CONCAT(
				RIGHT (YEAR(date_from), 2),
				'-',
				RIGHT (YEAR(date_to), 2)
			)
		FROM
			financial_year AS p
		WHERE
			p.financial_id = complain.financial_id
	) AS fyear

FROM
	complain
INNER JOIN complain_item_details ON complain_item_details.complain_id = complain.complain_id
WHERE
	complain.complain_status = 'Pending' AND  complain.branch_id = $branch_id
GROUP BY
	complain.complain_id
ORDER BY
	complain.complain_id");

        foreach ($complain_detail as $complain) {
            /**  Generate New Complain Number  */
            $financialYear = FinancialYear::where('is_active', 'Y')->first();
            $financialID = $financialYear->financial_id;
            $complainNo = DB::table('complain')
                ->select('complain_no')
                ->where('branch_id', '=', $branch_id)
                ->where('financial_id', '=', $financialID)
                ->orderBy('complain_no', 'desc')
                ->get()
                ->take(1)
                ->toArray();
            $complainNo = json_decode(json_encode($complainNo), true);
            $newComplainNo = (!empty($complainNo[0]['complain_no'])) ? $complainNo[0]['complain_no'] + 1 : 1;

            $financial_year = $complain->fyear;
            $mainComplainNo = $complain->complain_no;
            /** Set Complain Number to as old number with year and prefix */
            if ($complain->branch_id == 1) {
                $old_complain_no = 'PF-TKT/' . $financial_year . '/' . $mainComplainNo;
            } elseif ($complain->branch_id == 3) {
                $old_complain_no = 'TE-TKT/' . $financial_year . '/' . $mainComplainNo;
            } elseif ($complain->branch_id == 4) {
                $old_complain_no = 'TP-TKT/' . $financial_year . '/' . $mainComplainNo;
            }
            $complainData = [
                'financial_id' => $financialID,
                'client_id' => $complain->client_id,
                'distributor_id' => $complain->distributor_id,
                'complain_type' => $complain->complain_type,
                'problem' => $complain->problem,
                'client_name' => $complain->client_name,
                'address' => $complain->address,
                'mobile' => $complain->mobile,
                'mobile2' => $complain->mobile2,
                'email_address' => $complain->email_address,
                'city_id' => $complain->city_id,
                'district' => $complain->district,
                'state' => $complain->state,
                'medium_id' => $complain->medium_id,
                'complain_gst' => $complain->complain_gst,
                'created_id' => $complain->created_id,
                'branch_id' => $complain->branch_id,
                'created_at' => date('Y-m-d H:i:s'),
                'complain_no' => $newComplainNo,
                'old_complain_no' => $old_complain_no
            ];
            $complainID = DB::table('complain')->insertGetId($complainData);
            $complain_product = DB::select("SELECT
	complain_item_details.*
FROM
	complain_item_details
WHERE complain_item_details.complain_id = $complainID");

            foreach ($complain_product as $com_item) {
                $old_complain_id = $com_item->complain_id;
                $complainProductItem = [
                    'complain_id' => $complainID,
                    'category_id' => $com_item['category_id'],
                    'product_id' => $com_item['product_id'],
                    'serial_no' => $com_item['sr_no'],
                    'warranty' => $com_item['warranty'],
                    'complain' => $com_item['complain'],
                    'production_no' => $com_item['production_no'],
                    'invoice_no' => $com_item['invoice_no'],
                    'invoice_date' => $com_item['invoice_date'],
                    'qty' => $com_item['qty'],
                    'branch_id' => $com_item->branch_id,
                    'created_id' => $com_item->created_id,
                    'application' => $com_item['application'],
                    'old_complain_id'=>$old_complain_id
                ];
                print_r($complainProductItem);exit();
                DB::table('complain_item_details')->insertGetId($complainProductItem);
            }
        }
        echo "done";
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
        //
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
