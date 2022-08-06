<?php

namespace App\Http\Controllers;

use App\AdvanceReplacementIn;
use App\FinancialYear;
use App\ReplacementProductIn;
use App\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdvanceReplacementInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($replacement_out_id, Request $request)
    {
        $request->session()->put('replacement_out_id', $replacement_out_id);
        $replacement_in_item = AdvanceReplacementIn::where('replacement_out_id', $replacement_out_id)->get();
        $replacement_in = AdvanceReplacementIn::where('replacement_out_id', $replacement_out_id)->first();
        $transport_list = Transport::get();
        return view('advancereplacement.replacement_in')->with('action', 'INSERT')->with(compact('replacement_in_item', 'transport_list', 'replacement_in'));
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
        $replacement_out_id = $request->session()->get('replacement_out_id');
        $financialYear =FinancialYear::where('is_active','Y')->first();
        $replacement_in = DB::table('advance_replacement_in')->where('replacement_out_id', $replacement_out_id)->get();
//        print_r($replacement_in[0]->replacement_in_id);die();
        if (!empty($replacement_in[0]->replacement_in_id)) {
            $replacement_in = AdvanceReplacementIn::find($replacement_in[0]->replacement_in_id);
            $replacement_in->replacement_out_id = $replacement_out_id;
            $replacement_in->bill_no = $request->input('bill_no');
            $replacement_in->billty_no = $request->input('billty_no');
            $replacement_in->financial_id = $financialYear->financial_id;
            $replacement_in->transport_id = $request->input('transport_id');
            $replacement_in->inward_date = $request->input('inward_date');
            $replacement_in->created_id = Auth::user()->user_id;
            $replacement_in->branch_id = Auth::user()->branch_id;
            $replacement_in->save();
            $request->session()->put('replacement_in_id', $replacement_in->replacement_in_id);
            $request->session()->flash('update-status', 'Successfully Updated..');

            return redirect('replacement-product/');
        } else {
            $replacement_in = new AdvanceReplacementIn();
            $replacement_in->replacement_out_id = $replacement_out_id;
            $replacement_in->bill_no = $request->input('bill_no');
            $replacement_in->billty_no = $request->input('billty_no');
            $replacement_in->transport_id = $request->input('transport_id');
            $replacement_in->inward_date = $request->input('inward_date');
            $replacement_in->created_id = Auth::user()->user_id;
            $replacement_in->branch_id = Auth::user()->branch_id;
            $replacement_in->save();
            $request->session()->flash('create-status', 'Successfully Created..');
            $request->session()->put('replacement_in_id', $replacement_in->replacement_in_id);
            return redirect('replacement-product/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\AdvanceReplacementIn $advanceReplacementIn
     * @return \Illuminate\Http\Response
     */
    public function show(AdvanceReplacementIn $advanceReplacementIn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\AdvanceReplacementIn $advanceReplacementIn
     * @return \Illuminate\Http\Response
     */
    public function edit(AdvanceReplacementIn $advanceReplacementIn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\AdvanceReplacementIn $advanceReplacementIn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdvanceReplacementIn $advanceReplacementIn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\AdvanceReplacementIn $advanceReplacementIn
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvanceReplacementIn $advanceReplacementIn)
    {
        //
    }
}
