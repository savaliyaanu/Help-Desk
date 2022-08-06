<?php

namespace App\Http\Controllers;

use App\ChallanOptional;
use App\ChallanProduct;
use App\FinancialYear;
use App\InspectionReport;
use App\SpareInspectionReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InspectionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $challan_item_id)
    {
        $inspection_report = InspectionReport::where('challan_product_id', $challan_item_id)->first();
        $spare = SpareInspectionReport::where('challan_product_id', $challan_item_id)->first();
        $category_id = DB::table('challan_item_master')
            ->select('challan_item_master.category_id','challan_id')
            ->where('challan_product_id', '=', $challan_item_id)
            ->first();
        $category_id = $category_id->category_id;

        $challan_id = DB::table('challan_item_master')->where('challan_product_id', '=', $challan_item_id)->first();

        $spareItem = DB::table('challan_item_master')
            ->select('topland.product_master.product_name', 'topland.product_master.product_id', 'challan_item_master.*')
            ->join('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id');
        if (!empty($challan_item_id)) {
            $spareItem = $spareItem->where('challan_item_master.challan_product_id', '=', $challan_item_id);
        }
        $spareItem = $spareItem->get();

        return view('inspectionreport.create')->with('action', 'INSERT')->with(compact('inspection_report', 'challan_id', 'spare', 'category_id', 'challan_item_id', 'spareItem'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $financialYear = FinancialYear::where('is_active', 'Y')->first();
        $challan_product_id = $request->input('challan_product_id');
        $challan_id = ChallanProduct::find($challan_product_id);
        InspectionReport::where('challan_product_id', $challan_product_id)->delete();
        $inspection_report = new InspectionReport();
        $inspection_report->challan_product_id = $challan_product_id;
        $inspection_report->financial_id = $financialYear->financial_id;
        $inspection_report->challan_id = $challan_id->challan_id;
        $inspection_report->mechanic_name = $request->input('mechanic_name');
        $inspection_report->problem = $request->input('problem');
        $inspection_report->crank_shaft1 = $request->input('crank_shaft1');
        $inspection_report->crank_shaft2 = $request->input('crank_shaft2');
        $inspection_report->crank_shaft3 = $request->input('crank_shaft3');
        $inspection_report->crank_shaft4 = $request->input('crank_shaft4');
        $inspection_report->trb_bb1 = $request->input('trb_bb1');
        $inspection_report->trb_bb2 = $request->input('trb_bb2');
        $inspection_report->trb_bb3 = $request->input('trb_bb3');
        $inspection_report->cr_bearing1 = $request->input('cr_bearing1');
        $inspection_report->cr_bearing2 = $request->input('cr_bearing2');
        $inspection_report->cyl_liner1 = $request->input('cyl_liner1');
        $inspection_report->cyl_liner2 = $request->input('cyl_liner2');
        $inspection_report->piston1 = $request->input('piston1');
        $inspection_report->piston2 = $request->input('piston2');
        $inspection_report->piston3 = $request->input('piston3');
        $inspection_report->gudgeon_pin1 = $request->input('gudgeon_pin1');
        $inspection_report->gudgeon_pin2 = $request->input('gudgeon_pin2');
        $inspection_report->gudgeon_pin3 = $request->input('gudgeon_pin3');
        $inspection_report->gudgeon_pin4 = $request->input('gudgeon_pin4');
        $inspection_report->ring_set1 = $request->input('ring_set1');
        $inspection_report->ring_set2 = $request->input('ring_set2');
        $inspection_report->ring_set3 = $request->input('ring_set3');
        $inspection_report->con_rod1 = $request->input('con_rod1');
        $inspection_report->con_rod2 = $request->input('con_rod2');
        $inspection_report->con_rod3 = $request->input('con_rod3');
        $inspection_report->con_rod4 = $request->input('con_rod4');
        $inspection_report->cam_shaft1 = $request->input('cam_shaft1');
        $inspection_report->cam_shaft2 = $request->input('cam_shaft2');
        $inspection_report->cam_shaft3 = $request->input('cam_shaft3');
        $inspection_report->cam_shaft4 = $request->input('cam_shaft4');
        $inspection_report->valve1 = $request->input('valve1');
        $inspection_report->valve2 = $request->input('valve2');
        $inspection_report->valve3 = $request->input('valve3');
        $inspection_report->valve4 = $request->input('valve4');
        $inspection_report->ram_roller1 = $request->input('ram_roller1');
        $inspection_report->ram_roller2 = $request->input('ram_roller2');
        $inspection_report->ram_roller3 = $request->input('ram_roller3');
        $inspection_report->ram_roller4 = $request->input('ram_roller4');
        $inspection_report->cyl_head1 = $request->input('cyl_head1');
        $inspection_report->cyl_head2 = $request->input('cyl_head2');
        $inspection_report->cyl_head3 = $request->input('cyl_head3');
        $inspection_report->valve_guide1 = $request->input('valve_guide1');
        $inspection_report->valve_guide2 = $request->input('valve_guide2');
        $inspection_report->side_cover1 = $request->input('side_cover1');
        $inspection_report->side_cover2 = $request->input('side_cover2');
        $inspection_report->side_cover3 = $request->input('side_cover3');
        $inspection_report->crank_case1 = $request->input('crank_case1');
        $inspection_report->crank_case2 = $request->input('crank_case2');
        $inspection_report->crank_case3 = $request->input('crank_case3');
        $inspection_report->crank_case4 = $request->input('crank_case4');
        $inspection_report->componentsA1 = $request->input('componentsA1');
        $inspection_report->componentsA2 = $request->input('componentsA2');
        $inspection_report->componentsA3 = $request->input('componentsA3');
        $inspection_report->componentsA4 = $request->input('componentsA4');
        $inspection_report->componentsA5 = $request->input('componentsA5');
        $inspection_report->componentsB1 = $request->input('componentsB1');
        $inspection_report->componentsB2 = $request->input('componentsB2');
        $inspection_report->componentsB3 = $request->input('componentsB3');
        $inspection_report->componentsB4 = $request->input('componentsB4');
        $inspection_report->componentsB5 = $request->input('componentsB5');
        $inspection_report->componentsC1 = $request->input('componentsC1');
        $inspection_report->componentsC2 = $request->input('componentsC2');
        $inspection_report->componentsC3 = $request->input('componentsC3');
        $inspection_report->componentsC4 = $request->input('componentsC4');
        $inspection_report->componentsC5 = $request->input('componentsC5');
        $inspection_report->componentsD1 = $request->input('componentsD1');
        $inspection_report->componentsD2 = $request->input('componentsD2');
        $inspection_report->componentsD3 = $request->input('componentsD3');
        $inspection_report->componentsD4 = $request->input('componentsD4');
        $inspection_report->componentsD5 = $request->input('componentsD5');
        $inspection_report->company_observation = $request->input('company_observation');
        $inspection_report->checked_by = $request->input('checked_by');
        $inspection_report->fault = $request->input('fault');
        $inspection_report->parts_replaced = $request->input('parts_replaced');
        $inspection_report->external = $request->input('external');
        $inspection_report->internal = $request->input('internal');
        $inspection_report->component_changed_fitted = $request->input('component_changed_fitted');
        $inspection_report->complain = $request->input('complain');
        $inspection_report->observation = $request->input('observation');
        $inspection_report->part_change = $request->input('part_change');

        $inspection_report->created_id = Auth::user()->user_id;
        $inspection_report->branch_id = Auth::user()->branch_id;
        $inspection_report->save();

//        if (is_array($request->input('challan_id'))) {
//            foreach ($request->input('challan_id') as $row) {
//                $optionalId = ChallanOptional::find($row);
////                print_r($optionalId->challan_id);die();
//
//                $spare = new SpareInspectionReport();
//                $spare->inspection_report_id = $inspection_report->inspection_report_id;
//                $spare->challan_optional_id = $optionalId->challan_optional_id;
//                $spare->product_id = $optionalId->product_id;
//                $spare->challan_id = $optionalId->challan_id;
//                $spare->challan_product_id = $challan_product_id;
//                $spare->complain = $request->input('complain');
//                $spare->observation = $request->input('observation');
//                $spare->part_change = $request->input('part_change');
//                $spare->created_id = Auth::user()->user_id;
//                $spare->created_at = date('Y-m-d H:i:s');
//                $spare->branch_id = Auth::user()->branch_id;
//                $spare->save();
//            }
//        }

        return redirect('inspection-report/' . $challan_product_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\InspectionReport $inspectionReport
     * @return \Illuminate\Http\Response
     */
    public function show(InspectionReport $inspectionReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\InspectionReport $inspectionReport
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\InspectionReport $inspectionReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\InspectionReport $inspectionReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(InspectionReport $inspectionReport, Request $request)
    {
        //
    }
}
