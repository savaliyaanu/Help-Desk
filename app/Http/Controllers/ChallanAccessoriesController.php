<?php

namespace App\Http\Controllers;

use App\ChallanAccessories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChallanAccessoriesController extends Controller
{

    private $pageType;

    public function __construct()
    {

        $this->pageType = 'Accessories';
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
    public function create($challan_id,Request $request)
    {
        $challanAccessories = DB::table('challan_accessories')
            ->select('challan_accessories.*', 'accessories_master.accessories_id', 'accessories_master.accessories_name')
            ->leftJoin('topland.accessories_master', 'accessories_master.accessories_id', '=', 'challan_accessories.accessories_id')
            ->where('challan_id', '=', $challan_id)
            ->get();

        $accessories_master = DB::table('topland.accessories_master')->get();
        $unitMaster = DB::table('unit_master')->get();
        return view('challan.accessories')->with('action', 'INSERT')->with('pageType', $this->pageType)->with(compact('accessories_master', 'unitMaster', 'challanAccessories', 'challan_id'))->with('CURRENT_PAGE', 'ACCESSORIES');
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
            'accessories_id.required' => 'Please select Accessories Name',
            'accessories_qty.required' => 'Please select Quantity',
        ];
        $rules = [
            'accessories_id' => 'required',
            'accessories_qty' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $challanAccessories = new ChallanAccessories();
        $challanAccessories->challan_id =  $request->input('challan_id');
        $challanAccessories->accessories_id = $request->input('accessories_id');
        $challanAccessories->accessories_qty = $request->input('accessories_qty');
        $challanAccessories->accessories_unit_name = $request->input('accessories_unit_name');
        $challanAccessories->created_id = Auth::user()->user_id;
        $challanAccessories->branch_id = Auth::user()->branch_id;
        $challanAccessories->created_at = date('Y-m-d H:i:s');
        $challanAccessories->save();
        $request->session()->flash('create-status', 'Accessories Successful Add...');
        return redirect('challan-accessories-create/'.$challanAccessories->challan_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ChallanAccessories $challanAccessories
     * @return \Illuminate\Http\Response
     */
    public function show(ChallanAccessories $challanAccessories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ChallanAccessories $challanAccessories
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $accessoriesList = DB::table('challan_accessories')->where('challan_accessories_id', '=', $id)->first();
        $challan_id = $accessoriesList->challan_id;
//        print_r($accessoriesList->challan_id);exit();
        $challanAccessories = DB::table('challan_accessories')
            ->select('challan_accessories.*', 'accessories_master.accessories_id', 'accessories_master.accessories_name')
            ->leftJoin('topland.accessories_master', 'accessories_master.accessories_id', '=', 'challan_accessories.accessories_id')
            ->where('challan_id', '=', $challan_id)
            ->get();
        $unitMaster = DB::table('unit_master')->get();
        $accessories_master = DB::table('topland.accessories_master')->get();
        return view('challan.accessories')->with('action', 'UPDATE')->with('pageType', $this->pageType)->with(compact('challan_id'))->with('unitMaster',$unitMaster)->with('accessoriesChallan', $accessoriesList)->with('accessories_master', $accessories_master)->with('challanAccessories', $challanAccessories)->with('CURRENT_PAGE', 'ACCESSORIES');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ChallanAccessories $challanAccessories
     * @param $challanAccessories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'accessories_id.required' => 'Please select Accessories Name',
            'accessories_qty.required' => 'Please select Quantity',
        ];
        $rules = [
            'accessories_id' => 'required',
            'accessories_qty' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $challanAccessories = ChallanAccessories::find($id);
        $challanAccessories->challan_id = $request->input('challan_id');
        $challanAccessories->accessories_id = $request->input('accessories_id');
        $challanAccessories->accessories_qty = $request->input('accessories_qty');
        $challanAccessories->accessories_unit_name = $request->input('accessories_unit_name');
        $challanAccessories->updated_id = Auth::user()->user_id;
        $challanAccessories->branch_id = Auth::user()->branch_id;
        $challanAccessories->updated_at = date('Y-m-d H:i:s');
        $challanAccessories->save();
        $request->session()->flash('update-status', 'Accessories Successful Updated...');
        return redirect('challan-accessories-create/'.$challanAccessories->challan_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ChallanAccessories $challanAccessories
     * @param $challanAccessories
     * @return \Illuminate\Http\Response
     */
    public function destroy($challan_accessories_id, Request $request)
    {
        $challan_id = ChallanAccessories::where('challan_accessories_id',$challan_accessories_id)->first();

        ChallanAccessories::destroy($challan_accessories_id);
        $request->session()->flash('delete-status', 'Accessories Successful Deleted..');
        return redirect('challan-accessories-create/'.$challan_id->challan_id);
    }
}
