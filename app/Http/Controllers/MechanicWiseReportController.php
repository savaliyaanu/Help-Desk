<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Fpdf;

class MechanicWiseReportController extends Controller
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
        $branch = Branch::leftjoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('branch_master.company_id', '=', Auth::user()->branch_id)
            ->get();
        $mechanicList = DB::table('topland.mechanic_master')->get();
        return view('mechanic_wise.create')->with('action', 'INSERT')->with(compact('branch', 'mechanicList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $branch_id = $request->post('branch_id');
        $mechanic_id = $request->post('mechanic_id');
        $result = DB::table('replacement_expense')
            ->leftJoin('complain','complain.complain_id','=','replacement_expense.complain_id')
            ->where('replacement_expense.mechanic_id', '=', $mechanic_id)
            ->where('replacement_expense.branch_id', '=', $branch_id)
            ->get();
        echo "<pre>";
        print_r($result);die();
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
