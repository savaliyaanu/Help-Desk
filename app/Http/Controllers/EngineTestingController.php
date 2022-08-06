<?php

namespace App\Http\Controllers;

use App\BorewellTesting;
use App\ChallanProduct;
use App\ChallanTestingMaster;
use App\EngineTesting;
use App\FinancialYear;
use App\GeneratorTesting;
use App\WeldingGeneratorTesting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EngineTestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($challan_product_id, Request $request)
    {
        $productList = DB::select("SELECT topland.product_master.product_name,complain_item_details.category_id,challan_item_master.* FROM challan_item_master
LEFT JOIN complain_item_details ON complain_item_details.cid_id = challan_item_master.complain_product_id
LEFT JOIN topland.product_master ON topland.product_master.product_id = complain_item_details.product_id
WHERE challan_item_master.challan_product_id = $challan_product_id");
        $category_id = $productList[0]->category_id;
        $challan_id = DB::table('challan_item_master')->where('challan_product_id',$challan_product_id)->first();
        $testing_master = ChallanTestingMaster::where('challan_product_id', '=', $challan_product_id)->first();
        $engine_testing = EngineTesting::where('challan_product_id', '=', $challan_product_id)->first();
        $generator_testing = GeneratorTesting::where('challan_product_id', '=', $challan_product_id)->first();
        $welding_testing = WeldingGeneratorTesting::where('challan_product_id', '=', $challan_product_id)->first();
        $borewell_testing = BorewellTesting::where('challan_product_id', '=', $challan_product_id)->first();

        return view('challan.enginetesting')->with('action', 'INSERT')->with(compact('productList','challan_id', 'challan_product_id', 'category_id', 'engine_testing', 'welding_testing', 'generator_testing', 'testing_master', 'borewell_testing'));
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
        $challan_product_id = $request->input('challan_product_id');
        $challan_id = ChallanProduct::find($challan_product_id);
        ChallanTestingMaster::where('challan_product_id', $challan_product_id)->delete();
        $testing_master = new ChallanTestingMaster();
        $testing_master->challan_id = $challan_id->challan_id;
        $testing_master->category_id = $challan_id->category_id;
        $testing_master->product_id = $challan_id->product_id;
        $testing_master->challan_product_id = $challan_product_id;
        $testing_master->checking_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('checking_date'))));
        $testing_master->testing_by = $request->input('testing_by');
        $testing_master->created_id = Auth::user()->user_id;
        $testing_master->branch_id = Auth::user()->branch_id;
        $testing_master->save();

        $challan_product_engine = ChallanProduct::find($challan_product_id);
        EngineTesting::where('challan_product_id', $challan_product_id)->delete();
        $engine_testing = new EngineTesting();
        $engine_testing->challan_testing_id = $testing_master->challan_testing_id;
        $engine_testing->challan_product_id = $challan_product_id;
        $engine_testing->category_id = $challan_product_engine->category_id;
        $engine_testing->product_id = $challan_product_engine->product_id;
        $engine_testing->reading = $request->input('reading');
        $engine_testing->sfc = $request->input('sfc');
        $engine_testing->temp_rpm = $request->input('temp_rpm');
        $engine_testing->temp_percentage = $request->input('temp_percentage');
        $engine_testing->perm_rpm = $request->input('perm_rpm');
        $engine_testing->perm_percentage = $request->input('perm_percentage');
        $engine_testing->created_id = Auth::user()->user_id;
        $engine_testing->branch_id = Auth::user()->branch_id;
        $engine_testing->save();

        $challan_product_gen = ChallanProduct::find($challan_product_id);
        GeneratorTesting::where('challan_product_id', $challan_product_id)->delete();
        $generator_testing = new GeneratorTesting();
        $generator_testing->challan_testing_id = $testing_master->challan_testing_id;
        $generator_testing->challan_product_id = $challan_product_id;
        $generator_testing->category_id = $challan_product_gen->category_id;
        $generator_testing->product_id = $challan_product_gen->product_id;
        $generator_testing->ac_voltage = $request->input('ac_voltage');
        $generator_testing->watts = $request->input('watts');
        $generator_testing->dc_voltage_nl = $request->input('dc_voltage_nl');
        $generator_testing->dc_voltage_fl = $request->input('dc_voltage_fl');
        $generator_testing->dc_amp_nl = $request->input('dc_amp_nl');
        $generator_testing->dc_amp_fl = $request->input('dc_amp_fl');
        $generator_testing->rpm_nl = $request->input('rpm_nl');
        $generator_testing->rpm_fl = $request->input('rpm_fl');
        $generator_testing->ac_voltage_ifl = $request->input('ac_voltage_ifl');
        $generator_testing->ac_voltage_pf = $request->input('ac_voltage_pf');
        $generator_testing->ac_voltage_rfl = $request->input('ac_voltage_rfl');
        $generator_testing->ac_voltage_pfl = $request->input('ac_voltage_pfl');
        $generator_testing->ac_amp_ol = $request->input('ac_amp_ol');
        $generator_testing->ac_amp_pfl = $request->input('ac_amp_pfl');
        $generator_testing->watts_rfl = $request->input('watts_rfl');
        $generator_testing->vr_ifl = $request->input('vr_ifl');
        $generator_testing->rfl = $request->input('rfl');
        $generator_testing->kbl = $request->input('kbl');
        $generator_testing->amount_temp = $request->input('amount_temp');
        $generator_testing->regi = $request->input('regi');
        $generator_testing->stator_main_winding = $request->input('stator_main_winding');
        $generator_testing->stator_aux_winding = $request->input('stator_aux_winding');
        $generator_testing->ex_fld_wnd_regi = $request->input('ex_fld_wnd_regi');
        $generator_testing->ex_arm_wnd_regi = $request->input('ex_arm_wnd_regi');
        $generator_testing->created_id = Auth::user()->user_id;
        $generator_testing->branch_id = Auth::user()->branch_id;
        $generator_testing->save();

        $challan_product_welding_gen = ChallanProduct::find($challan_product_id);
        WeldingGeneratorTesting::where('challan_product_id', $challan_product_id)->delete();
        $welding_testing = new WeldingGeneratorTesting();
        $welding_testing->challan_testing_id = $testing_master->challan_testing_id;
        $welding_testing->challan_product_id = $challan_product_id;
        $welding_testing->category_id = $challan_product_welding_gen->category_id;
        $welding_testing->product_id = $challan_product_welding_gen->product_id;
        $welding_testing->voltage_low = $request->input('voltage_low');
        $welding_testing->voltage_high = $request->input('voltage_high');
        $welding_testing->voltage_lighting = $request->input('voltage_lighting');
        $welding_testing->temperature = $request->input('temperature');
        $welding_testing->no_load1 = $request->input('no_load1');
        $welding_testing->no_load2 = $request->input('no_load2');
        $welding_testing->no_load3 = $request->input('no_load3');
        $welding_testing->no_load4 = $request->input('no_load4');
        $welding_testing->no_load5 = $request->input('no_load5');
        $welding_testing->no_load6 = $request->input('no_load6');
        $welding_testing->no_load7 = $request->input('no_load7');
        $welding_testing->resistive_load1 = $request->input('resistive_load1');
        $welding_testing->resistive_load2 = $request->input('resistive_load2');
        $welding_testing->resistive_load3 = $request->input('resistive_load3');
        $welding_testing->resistive_load4 = $request->input('resistive_load4');
        $welding_testing->resistive_load5 = $request->input('resistive_load5');
        $welding_testing->resistive_load6 = $request->input('resistive_load6');
        $welding_testing->resistive_load7 = $request->input('resistive_load7');
        $welding_testing->welding_low1 = $request->input('welding_low1');
        $welding_testing->welding_low2 = $request->input('welding_low2');
        $welding_testing->welding_low3 = $request->input('welding_low3');
        $welding_testing->welding_low4 = $request->input('welding_low4');
        $welding_testing->welding_low5 = $request->input('welding_low5');
        $welding_testing->welding_low6 = $request->input('welding_low6');
        $welding_testing->welding_low7 = $request->input('welding_low7');
        $welding_testing->welding_high1 = $request->input('welding_high1');
        $welding_testing->welding_high2 = $request->input('welding_high2');
        $welding_testing->welding_high3 = $request->input('welding_high3');
        $welding_testing->welding_high4 = $request->input('welding_high4');
        $welding_testing->welding_high5 = $request->input('welding_high5');
        $welding_testing->welding_high6 = $request->input('welding_high6');
        $welding_testing->welding_high7 = $request->input('welding_high7');
        $welding_testing->created_id = Auth::user()->user_id;
        $welding_testing->branch_id = Auth::user()->branch_id;
        $welding_testing->save();

        $challan_product_borewell = ChallanProduct::find($challan_product_id);
        BorewellTesting::where('challan_product_id', $challan_product_id)->delete();
        $borewell_testing = new BorewellTesting();
        $borewell_testing->challan_testing_id = $testing_master->challan_testing_id;
        $borewell_testing->challan_product_id = $challan_product_id;
        $borewell_testing->category_id = $challan_product_borewell->category_id;
        $borewell_testing->product_id = $challan_product_borewell->product_id;
        $borewell_testing->remark = $request->input('remark');
        $borewell_testing->voltage1 = $request->input('voltage1');
        $borewell_testing->voltage2 = $request->input('voltage2');
        $borewell_testing->voltage3 = $request->input('voltage3');
        $borewell_testing->nl_amp1 = $request->input('nl_amp1');
        $borewell_testing->nl_amp2 = $request->input('nl_amp2');
        $borewell_testing->nl_amp3 = $request->input('nl_amp3');
        $borewell_testing->max_amp1 = $request->input('max_amp1');
        $borewell_testing->max_amp2 = $request->input('max_amp2');
        $borewell_testing->max_amp3 = $request->input('max_amp3');
        $borewell_testing->hz1 = $request->input('hz1');
        $borewell_testing->hz2 = $request->input('hz2');
        $borewell_testing->hz3 = $request->input('hz3');
        $borewell_testing->pf1 = $request->input('pf1');
        $borewell_testing->pf2 = $request->input('pf2');
        $borewell_testing->pf3 = $request->input('pf3');
        $borewell_testing->kw1 = $request->input('kw1');
        $borewell_testing->kw2 = $request->input('kw2');
        $borewell_testing->kw3 = $request->input('kw3');
        $borewell_testing->dp_amp1 = $request->input('dp_amp1');
        $borewell_testing->dp_amp2 = $request->input('dp_amp2');
        $borewell_testing->dp_amp3 = $request->input('dp_amp3');
        $borewell_testing->so_head1 = $request->input('so_head1');
        $borewell_testing->so_head2 = $request->input('so_head2');
        $borewell_testing->so_head3 = $request->input('so_head3');
        $borewell_testing->dp_head1 = $request->input('dp_head1');
        $borewell_testing->dp_head2 = $request->input('dp_head2');
        $borewell_testing->dp_head3 = $request->input('dp_head3');
        $borewell_testing->disch1 = $request->input('disch1');
        $borewell_testing->disch2 = $request->input('disch2');
        $borewell_testing->disch3 = $request->input('disch3');
        $borewell_testing->created_id = Auth::user()->user_id;
        $borewell_testing->branch_id = Auth::user()->branch_id;
        $borewell_testing->save();
        return redirect('challan-engine-testing/' . $challan_product_id);
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
    public function edit($challan_testing_id, Request $request)
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
    public function update(Request $request, $challan_testing_id)
    {
//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($challan_testing_id, Request $request)
    {
        $challan_id = $request->session()->get('challan_id');
        ChallanTestingMaster::destroy($challan_testing_id);
        EngineTesting::where('challan_testing_id', $challan_testing_id)->delete();
        GeneratorTesting::where('challan_testing_id', $challan_testing_id)->delete();
        WeldingGeneratorTesting::where('challan_testing_id', $challan_testing_id)->delete();
        BorewellTesting::where('challan_testing_id', $challan_testing_id)->delete();
        return redirect('challan-engine-testing/' . $challan_id);
    }

    public function getCategoryId(Request $request)
    {
        $challan_product_id = $request->input('challan_product_id');

        $category = DB::table('challan_item_master')
            ->select('challan_item_master.category_id')
            ->where('challan_product_id', '=', $challan_product_id)
            ->first();
        return response()->json(['category_id' => $category->category_id]);

    }
}
