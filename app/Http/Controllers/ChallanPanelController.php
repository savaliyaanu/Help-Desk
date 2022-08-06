<?php

namespace App\Http\Controllers;

use App\ChallanPanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChallanPanelController extends Controller
{

    private $pageType;

    public function __construct()
    {

        $this->pageType = 'Panel';
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
    public function create(Request $request,$challan_id)
    {
//        $challan_id = $request->session()->get('challan_id');

        $panelItem = DB::table('challan_panel')
            ->select('challan_panel.*', 'product_master.product_name')
            ->leftJoin('topland.product_master', 'product_master.product_id', '=', 'challan_panel.panel_id')
            ->where('challan_id', '=', $challan_id)
            ->get();

        $panel_master = DB::table('topland.product_master')
            ->where('product_name', 'like', '%PANEL%')
            ->where('is_delete', '=', 'N')
            ->get();
        $unitMaster = DB::table('unit_master')->get();
        return view('challan.panel')->with('action', 'INSERT')->with('pageType', $this->pageType)->with(compact('unitMaster','panel_master','panelItem','challan_id'))->with('CURRENT_PAGE', 'PANEL');
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
            'panel_id.required' => 'Please select Panel Name',
            'panel_qty.required' => 'Please select Quantity',
        ];
        $rules = [
            'panel_id' => 'required',
            'panel_qty' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $challan_Panel = new ChallanPanel();
        $challan_Panel->challan_id = $request->input('challan_id');
        $challan_Panel->panel_id = $request->input('panel_id');
        $challan_Panel->panel_qty = $request->input('panel_qty');
        $challan_Panel->panel_unit_name = $request->input('panel_unit_name');
        $challan_Panel->created_id = Auth::user()->user_id;
        $challan_Panel->branch_id = Auth::user()->branch_id;
        $challan_Panel->created_at = date('Y-m-d H:i:s');
        $challan_Panel->save();
        $request->session()->flash('create-status','Panel Successful Add..');
        return redirect('challan-panel-create/'.$challan_Panel->challan_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ChallanPanel $challan_Panel
     * @return \Illuminate\Http\Response
     */
    public function show(ChallanPanel $challan_Panel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ChallanPanel $challan_Panel
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $panelList = DB::table('challan_panel')->where('challan_panel_id', '=', $id)->first();
        $challan_id = $panelList->challan_id;

        $panelItem = DB::table('challan_panel')
            ->select('challan_panel.*', 'topland.product_master.product_name')
            ->leftJoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_panel.panel_id')
            ->where('challan_panel.challan_id', '=', $challan_id)
            ->get();
        $panel_master = DB::table('topland.product_master')
            ->where('product_name', 'like', '%PANEL%')
            ->where('is_delete', '=', 'N')
            ->get();

        $unitMaster = DB::table('unit_master')->get();
        return view('challan.panel')->with('action', 'UPDATE')->with('pageType', $this->pageType)->with(compact('challan_id'))->with('panelChallan', $panelList)->with('panel_master', $panel_master)->with('unitMaster',$unitMaster)->with('panelItem', $panelItem)->with('CURRENT_PAGE', 'PANEL');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ChallanPanel $challan_Panel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $messages = [
            'panel_id.required' => 'Please select Panel Name',
            'panel_qty.required' => 'Please select Quantity',
        ];
        $rules = [
            'panel_id' => 'required',
            'panel_qty' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $challan_Panel = ChallanPanel::find($id);
        $challan_Panel->challan_id = $request->input('challan_id');
        $challan_Panel->panel_id = $request->input('panel_id');
        $challan_Panel->panel_qty = $request->input('panel_qty');
        $challan_Panel->panel_unit_name = $request->input('panel_unit_name');
        $challan_Panel->created_id = Auth::user()->user_id;
        $challan_Panel->branch_id = Auth::user()->branch_id;
        $challan_Panel->created_at = date('Y-m-d H:i:s');
        $challan_Panel->save();
        $request->session()->flash('update-status','Panel Successful Updated...');
        return redirect('challan-panel-create/'.$challan_Panel->challan_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ChallanPanel $challan_Panel
     * @return \Illuminate\Http\Response
     */
    public function destroy($challan_panel_id,Request $request)
    {
        $challan_id = ChallanPanel::where('challan_panel_id',$challan_panel_id)->first();
        ChallanPanel::destroy($challan_panel_id);
        $request->session()->flash('delete-status','Panel Successful Deleted...');
        return redirect('challan-panel-create/'.$challan_id->challan_id);
    }
}
