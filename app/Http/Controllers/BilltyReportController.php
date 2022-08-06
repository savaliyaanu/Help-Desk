<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;

class BilltyReportController extends Controller
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
        $clientDetail = DB::table('topland.client_master')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'topland.client_master.city_id')->get();
        return view('billty.report')->with('action', 'INSERT')->with(compact('clientDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client_id = $request->input('client_id');
        $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('from_date'))));
        $to = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('to_date'))));

        $query = DB::table('billty')
            ->select('billty.other', 'billty.lr_no', 'billty.lr_date', 'billty.entry_by', 'complain.client_name', 'topland.city_master.city_name', 'billty_handover_date.handover_date', 'complain.complain_no', 'billty.created_at as billty_date')
            ->leftJoin('complain', 'complain.complain_id', '=', 'billty.complain_id')
            ->leftJoin('topland.client_master', 'topland.client_master.client_id', '=', 'billty.client_id')
            ->leftJoin('topland.city_master', 'topland.city_master.city_id', '=', 'complain.city_id')
            ->leftJoin('billty_handover_date', 'billty_handover_date.billty_id', '=', 'billty.billty_id')
            ->where('billty.branch_id', '=', Auth::user()->branch_id)
            ->orderByDesc('billty.billty_id')
            ->where(DB::raw('DATE_FORMAT(billty.created_at,"%Y-%m-%d")'), '>=', $from)
            ->where(DB::raw('DATE_FORMAT(billty.created_at,"%Y-%m-%d")'), '<=', $to);
        if (!empty($client_id)) {
            $query = $query->where('complain.client_id', '=', $client_id);
        }
        $billtyData = $query->get();

        Fpdf::AddPage('L', 'A4');
        Fpdf::AddFont('Verdana-Bold', 'B', 'verdanab.php');
        Fpdf::SetFont('Courier', 'B', 13);
        Fpdf::SetAutoPageBreak(false);
        Fpdf::Cell(290, 10, 'Replacement Billty Between ' . $request->input('from_date') . ' To ' . $request->input('to_date'), '', 0, 'C');
        Fpdf::Ln(15);
        if (($billtyData)) {
            Fpdf::SetWidths(array(10, 20, 19, 38, 70, 30, 23, 22, 25, 21));
            Fpdf::SetFont('Verdana-Bold', 'B', 8);
            Fpdf::Row(array('Sr.N',  'Comp. No','Billty Date', 'Type', 'Client Name', 'City', 'Lr No', 'LR Date', 'Entry By', 'Ha.over Da.'),
                array('C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C'), '', '', true);
            Fpdf::SetFont('Verdana', '', 8);
            $temp = 1;
            foreach ($billtyData as $item) {
                $handover = ($item->handover_date > 1970 - 01 - 01) ? date('d-m-Y',
                    strtotime($item->handover_date)) : '';
                $lr_date = ($item->lr_date > 1970 - 01 - 01) ? date('d-m-Y',
                    strtotime($item->lr_date)) : '';
                $billty_date = ($item->billty_date > 1970 - 01 - 01) ? date('d-m-Y',
                    strtotime($item->billty_date)) : '';
                Fpdf::Row(array(
                    $temp, $item->complain_no,$billty_date, strtoupper($item->other), strtoupper($item->client_name), strtoupper($item->city_name), $item->lr_no, $lr_date,  strtoupper($item->entry_by), $handover), array('C', 'C', 'L', 'L', 'C', 'C', 'C', 'C', 'L', 'C'), '', '', true);
                $temp++;
            }
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
