<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;

class ServiceMechanicWiseReport extends Controller
{
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
    public function create()
    {
        $complainNo = DB::table('replacement_expense')
            ->leftJoin('complain', 'complain.complain_id', '=', 'replacement_expense.complain_id')
            ->where('replacement_expense.branch_id', '=', Auth::user()->branch_id)->get();
        return view('service_mechanic_wise_report.create')->with('action', 'INSERT')->with(compact('complainNo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $complain_id = $request->post('complain_id');
        $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('from_date'))));
        $to = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('to_date'))));
        $query = DB::table('replacement_expense')
            ->select('complain.complain_id as ComplainID', 'replacement_expense.branch_id', 'complain.complain_no', 'replacement_expense.created_at as DateInfio', 'replacement_expense.party_name', 'replacement_expense.city_name', 'topland.mechanic_master.mechanic_name',
                'topland.product_master.product_name', 'complain.client_name', 'complain_item_details.complain', 'multiple_product_complain.complain_in_word',
                'complain_item_details.serial_no', 'complain_item_details.solution', 'complain_item_details.warranty', 'complain_item_details.solution_by',
                DB::raw("(select concat(right(year(date_from),2),'-',right(year(date_to),2)) from financial_year as p WHERE p.financial_id = replacement_expense.financial_id) as fyear"),
                'multiple_product_complain.complain_id as Multy_complainID')
            ->leftJoin('complain', 'complain.complain_id', '=', 'replacement_expense.complain_id')
            ->leftJoin('multiple_product_complain', 'multiple_product_complain.complain_id', '=', 'replacement_expense.complain_id')
            ->leftJoin('complain_item_details', 'complain_item_details.complain_id', '=', 'complain.complain_id')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'complain_item_details.product_id')
            ->leftJoin('topland.mechanic_master', 'topland.mechanic_master.mechanic_id', '=', 'replacement_expense.mechanic_id')
            ->where('replacement_expense.branch_id','=', Auth::user()->branch_id)
            ->groupBy('complain_item_details.serial_no')
            ->where(DB::raw('DATE_FORMAT(replacement_expense.created_at,"%Y-%m-%d")'), '>=', $from)
            ->where(DB::raw('DATE_FORMAT(replacement_expense.created_at,"%Y-%m-%d")'), '<=', $to);
        if (!empty($complain_id)) {
            $query->where('replacement_expense.complain_id', '=', $complain_id);
        }
        $result = $query->get();

        Fpdf::AddPage('L', 'A4');
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::AddFont('Verdana', '', 'Verdana.php');
        Fpdf::SetFont('Courier', 'B', 13);
        Fpdf::SetAutoPageBreak(true);
        Fpdf::Ln(8);
        Fpdf::SetWidths(array(8, 17, 19, 18, 18, 33, 18, 33, 35, 45, 30, 11));
        Fpdf::SetFont('Verdana-Bold', 'B', 8);
        Fpdf::Row(array('No.', 'TKT No', "Date", 'Model No', 'Serial No', 'Party Name', 'City', 'Client Name', 'Complaint', 'Solution', 'Mechanic Name', 'Warr.'), array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', array(), true);
        Fpdf::SetFont('Verdana', '', 8);
        Fpdf::SetWidths(array(8, 17, 19, 18, 18, 33, 18, 33, 35, 45, 30, 11));
        $i = 1;
        foreach ($result as $value) {
            if ($value->branch_id == 1) {
                $complains_no = 'PF-TKT/' . $value->fyear . '/' . $value->complain_no;
            } elseif ($value->branch_id == 3) {
                $complains_no = 'TE-TKT/' . $value->fyear . '/' . $value->complain_no;
            } elseif ($value->branch_id == 4) {
                $complains_no = 'TP-TKT/' . $value->fyear . '/' . $value->complain_no;
            }
            if ($value->Multy_complainID == NULL) {
                $complain_in_word = $value->complain;
            }else{
                $complain_in_word= $value->complain_in_word;
            }
            Fpdf::Row(array($i++, $complains_no, date('d-m-Y', strtotime($value->DateInfio)), strtoupper($value->product_name),
                $value->serial_no, strtoupper($value->party_name), strtoupper($value->city_name), strtoupper($value->client_name),
                strtoupper($complain_in_word),
                strtoupper($value->solution), strtoupper($value->mechanic_name), strtoupper($value->warranty)), array('C', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'C'), '', array(), true);
        }
        Fpdf::Output();
        exit();
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
