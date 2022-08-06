@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline mr-5">
                        <!--begin::Page Title-->
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Inspection Report</h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->

        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <!--begin::Form-->
                            <form class="form" id="kt_form_1" method="post"
                                  action="{{($action=='INSERT')? route('inspection-report.store'):route('inspection-report.update',$inspection_report->inspection_report_id) }}">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <input type="hidden" name="challan_product_id" value="{{ $challan_item_id }}">
                                    <input type="hidden" name="challan_id" value="{{ $challan_id->challan_id }}">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label ">Mechanic Name
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <input style="width: 100%" id="mechanic_name"
                                                       placeholder="Enter Name"
                                                       class="form-control  form-control-sm" name="mechanic_name"
                                                       value="{{ ((!empty($inspection_report->mechanic_name)) ?$inspection_report->mechanic_name :old('mechanic_name')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label "> Problem
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <input style="width: 100%" id="problem"
                                                       placeholder="Enter Problem"
                                                       class="form-control  form-control-sm" name="problem"
                                                       value="{{ ((!empty($inspection_report->problem)) ?$inspection_report->problem :old('problem')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    @if(in_array($category_id, array(1, 2, 3)))
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">CRANK SHAFT<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group ">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="crank_shaft1" placeholder="Enter Value"
                                                           class="form-control form-control-sm" name="crank_shaft1"
                                                           value="{{ ((!empty($inspection_report->crank_shaft1)) ?$inspection_report->crank_shaft1 :old('crank_shaft1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>PIN DIA. <span class="text-danger">*</span></label>
                                                    <input type="text" id="crank_shaft2" placeholder="Enter Value"
                                                           class="form-control " name="crank_shaft2"
                                                           value="{{ ((!empty($inspection_report->crank_shaft2)) ?$inspection_report->crank_shaft2 :old('crank_shaft2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>BEARING DIA <span class="text-danger">*</span></label>
                                                    <input type="text" id="crank_shaft3" placeholder="Enter Value"
                                                           class="form-control " name="crank_shaft3"
                                                           value="{{ ((!empty($inspection_report->crank_shaft3)) ?$inspection_report->crank_shaft3 :old('crank_shaft3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>FW RUN OUT <span class="text-danger">*</span></label>
                                                    <input type="text" id="crank_shaft4" placeholder="Enter Value"
                                                           class="form-control " name="crank_shaft4"
                                                           value="{{ ((!empty($inspection_report->crank_shaft4)) ?$inspection_report->crank_shaft4 :old('crank_shaft4')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">TRB/BB <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="trb_bb1" placeholder="Enter Value"
                                                           class="form-control " name="trb_bb1"
                                                           value="{{ ((!empty($inspection_report->trb_bb1)) ?$inspection_report->trb_bb1 :old('trb_bb1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>BORE <span class="text-danger">*</span></label>
                                                    <input type="text" id="trb_bb2" placeholder="Enter Value"
                                                           class="form-control " name="trb_bb2"
                                                           value="{{ ((!empty($inspection_report->trb_bb2)) ?$inspection_report->trb_bb2 :old('trb_bb2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>NOISE <span class="text-danger">*</span></label>
                                                    <input type="text" id="trb_bb3" placeholder="Enter Value"
                                                           class="form-control " name="trb_bb3"
                                                           value="{{ ((!empty($inspection_report->trb_bb3)) ?$inspection_report->trb_bb3 :old('trb_bb3')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">C.R.BEARING <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="cr_bearing1" placeholder="Enter Value"
                                                           class="form-control " name="cr_bearing1"
                                                           value="{{ ((!empty($inspection_report->cr_bearing1)) ?$inspection_report->cr_bearing1 :old('cr_bearing1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>WELL THICKNESS <span class="text-danger">*</span></label>
                                                    <input type="text" id="cr_bearing2" placeholder="Enter Value"
                                                           class="form-control " name="cr_bearing2"
                                                           value="{{ ((!empty($inspection_report->cr_bearing2)) ?$inspection_report->cr_bearing2 :old('cr_bearing2')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">CYL.LINER <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="cyl_liner1" placeholder="Enter Value"
                                                           class="form-control " name="cyl_liner1"
                                                           value="{{ ((!empty($inspection_report->cyl_liner1)) ?$inspection_report->cyl_liner1 :old('cyl_liner1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>BORE <span class="text-danger">*</span></label>
                                                    <input type="text" id="cyl_liner2" placeholder="Enter Value"
                                                           class="form-control " name="cyl_liner2"
                                                           value="{{ ((!empty($inspection_report->cyl_liner2)) ?$inspection_report->cyl_liner2 :old('cyl_liner2')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">PISTON<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="piston1" placeholder="Enter Value"
                                                           class="form-control " name="piston1"
                                                           value="{{ ((!empty($inspection_report->piston1)) ?$inspection_report->piston1 :old('piston1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>ING GROOVE WIDT <span class="text-danger">*</span></label>
                                                    <input type="text" id="piston2" placeholder="Enter Value"
                                                           class="form-control " name="piston2"
                                                           value="{{ ((!empty($inspection_report->piston2)) ?$inspection_report->piston2 :old('piston2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>G.P BORE <span class="text-danger">*</span></label>
                                                    <input type="text" id="piston3" placeholder="Enter Value"
                                                           class="form-control " name="piston3"
                                                           value="{{ ((!empty($inspection_report->piston3)) ?$inspection_report->piston3 :old('piston3')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">GUDGEON PIN<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="gudgeon_pin1" placeholder="Enter Value"
                                                           class="form-control " name="gudgeon_pin1"
                                                           value="{{ ((!empty($inspection_report->gudgeon_pin1)) ?$inspection_report->gudgeon_pin1 :old('gudgeon_pin1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>OUTER DIA <span class="text-danger">*</span></label>
                                                    <input type="text" id="gudgeon_pin2" placeholder="Enter Value"
                                                           class="form-control " name="gudgeon_pin2"
                                                           value="{{ ((!empty($inspection_report->gudgeon_pin2)) ?$inspection_report->gudgeon_pin2 :old('gudgeon_pin2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>HARDNESS <span class="text-danger">*</span></label>
                                                    <input type="text" id="gudgeon_pin3" placeholder="Enter Value"
                                                           class="form-control " name="gudgeon_pin3"
                                                           value="{{ ((!empty($inspection_report->gudgeon_pin3)) ?$inspection_report->gudgeon_pin3 :old('gudgeon_pin3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>CRACK <span class="text-danger">*</span></label>
                                                    <input type="text" id="gudgeon_pin4" placeholder="Enter Value"
                                                           class="form-control " name="gudgeon_pin4"
                                                           value="{{ ((!empty($inspection_report->gudgeon_pin4)) ?$inspection_report->gudgeon_pin4 :old('gudgeon_pin4')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">RING SET<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="ring_set1" placeholder="Enter Value"
                                                           class="form-control " name="ring_set1"
                                                           value="{{ ((!empty($inspection_report->ring_set1)) ?$inspection_report->ring_set1 :old('ring_set1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>CLOSED GAP <span class="text-danger">*</span></label>
                                                    <input type="text" id="ring_set2" placeholder="Enter Value"
                                                           class="form-control " name="ring_set2"
                                                           value="{{ ((!empty($inspection_report->ring_set2)) ?$inspection_report->ring_set2 :old('ring_set2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>AXIAL THICKNESS <span class="text-danger">*</span></label>
                                                    <input type="text" id="ring_set3" placeholder="Enter Value"
                                                           class="form-control " name="ring_set3"
                                                           value="{{ ((!empty($inspection_report->ring_set3)) ?$inspection_report->ring_set3 :old('ring_set3')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">CON. ROD.<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="con_rod1" placeholder="Enter Value"
                                                           class="form-control " name="con_rod1"
                                                           value="{{ ((!empty($inspection_report->con_rod1)) ?$inspection_report->con_rod1 :old('con_rod1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>BUSH BORE <span class="text-danger">*</span></label>
                                                    <input type="text" id="con_rod2" placeholder="Enter Value"
                                                           class="form-control " name="con_rod2"
                                                           value="{{ ((!empty($inspection_report->con_rod2)) ?$inspection_report->con_rod2 :old('con_rod2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>BENDING <span class="text-danger">*</span></label>
                                                    <input type="text" id="con_rod3" placeholder="Enter Value"
                                                           class="form-control " name="con_rod3"
                                                           value="{{ ((!empty($inspection_report->con_rod3)) ?$inspection_report->con_rod3 :old('con_rod3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>TWISTING <span class="text-danger">*</span></label>
                                                    <input type="text" id="con_rod4" placeholder="Enter Value"
                                                           class="form-control " name="con_rod4"
                                                           value="{{ ((!empty($inspection_report->con_rod4)) ?$inspection_report->con_rod4 :old('con_rod4')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">CAM SHAFT<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="cam_shaft1" placeholder="Enter Value"
                                                           class="form-control " name="cam_shaft1"
                                                           value="{{ ((!empty($inspection_report->cam_shaft1)) ?$inspection_report->cam_shaft1 :old('cam_shaft1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>HARDNESS <span class="text-danger">*</span></label>
                                                    <input type="text" id="cam_shaft2" placeholder="Enter Value"
                                                           class="form-control " name="cam_shaft2"
                                                           value="{{ ((!empty($inspection_report->cam_shaft2)) ?$inspection_report->cam_shaft2 :old('cam_shaft2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>RUN OUT <span class="text-danger">*</span></label>
                                                    <input type="text" id="cam_shaft3" placeholder="Enter Value"
                                                           class="form-control " name="cam_shaft3"
                                                           value="{{ ((!empty($inspection_report->cam_shaft3)) ?$inspection_report->cam_shaft3 :old('cam_shaft3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>SHAFT DIA <span class="text-danger">*</span></label>
                                                    <input type="text" id="cam_shaft4" placeholder="Enter Value"
                                                           class="form-control " name="cam_shaft4"
                                                           value="{{ ((!empty($inspection_report->cam_shaft4)) ?$inspection_report->cam_shaft4 :old('cam_shaft4')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">VALVE<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="valve1" placeholder="Enter Value"
                                                           class="form-control " name="valve1"
                                                           value="{{ ((!empty($inspection_report->valve1)) ?$inspection_report->valve1 :old('valve1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>DIA <span class="text-danger">*</span></label>
                                                    <input type="text" id="valve2" placeholder="Enter Value"
                                                           class="form-control " name="valve2"
                                                           value="{{ ((!empty($inspection_report->valve2)) ?$inspection_report->valve2 :old('valve2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>HARDNESS <span class="text-danger">*</span></label>
                                                    <input type="text" id="valve3" placeholder="Enter Value"
                                                           class="form-control " name="valve3"
                                                           value="{{ ((!empty($inspection_report->valve3)) ?$inspection_report->valve3 :old('valve3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VALVE SET <span class="text-danger">*</span></label>
                                                    <input type="text" id="valve4" placeholder="Enter Value"
                                                           class="form-control " name="valve4"
                                                           value="{{ ((!empty($inspection_report->valve4)) ?$inspection_report->valve4 :old('valve4')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">RAM ROLLER<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="ram_roller1" placeholder="Enter Value"
                                                           class="form-control " name="ram_roller1"
                                                           value="{{ ((!empty($inspection_report->ram_roller1)) ?$inspection_report->ram_roller1 :old('ram_roller1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>HARDNESS <span class="text-danger">*</span></label>
                                                    <input type="text" id="ram_roller2" placeholder="Enter Value"
                                                           class="form-control " name="ram_roller2"
                                                           value="{{ ((!empty($inspection_report->ram_roller2)) ?$inspection_report->ram_roller2 :old('ram_roller2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>OUTER DIA <span class="text-danger">*</span></label>
                                                    <input type="text" id="ram_roller3" placeholder="Enter Value"
                                                           class="form-control " name="ram_roller3"
                                                           value="{{ ((!empty($inspection_report->ram_roller3)) ?$inspection_report->ram_roller3 :old('ram_roller3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>PLAY <span class="text-danger">*</span></label>
                                                    <input type="text" id="ram_roller4" placeholder="Enter Value"
                                                           class="form-control " name="ram_roller4"
                                                           value="{{ ((!empty($inspection_report->ram_roller4)) ?$inspection_report->ram_roller4 :old('ram_roller4')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">CYL.HEAD<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="cyl_head1" placeholder="Enter Value"
                                                           class="form-control " name="cyl_head1"
                                                           value="{{ ((!empty($inspection_report->cyl_head1)) ?$inspection_report->cyl_head1 :old('cyl_head1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>HARDNESS <span class="text-danger">*</span></label>
                                                    <input type="text" id="cyl_head2" placeholder="Enter Value"
                                                           class="form-control " name="cyl_head2"
                                                           value="{{ ((!empty($inspection_report->cyl_head2)) ?$inspection_report->cyl_head2 :old('cyl_head2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VALVE SEAT <span class="text-danger">*</span></label>
                                                    <input type="text" id="cyl_head3" placeholder="Enter Value"
                                                           class="form-control " name="cyl_head3"
                                                           value="{{ ((!empty($inspection_report->cyl_head3)) ?$inspection_report->cyl_head3 :old('cyl_head3')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">VALVE GUIDE<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="valve_guide1" placeholder="Enter Value"
                                                           class="form-control " name="valve_guide1"
                                                           value="{{ ((!empty($inspection_report->valve_guide1)) ?$inspection_report->valve_guide1 :old('valve_guide1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>BORE <span class="text-danger">*</span></label>
                                                    <input type="text" id="valve_guide2" placeholder="Enter Value"
                                                           class="form-control " name="valve_guide2"
                                                           value="{{ ((!empty($inspection_report->valve_guide2)) ?$inspection_report->valve_guide2 :old('valve_guide2')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">SIDE COVER<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>VISUAL <span class="text-danger">*</span></label>
                                                    <input type="text" id="side_cover1" placeholder="Enter Value"
                                                           class="form-control " name="side_cover1"
                                                           value="{{ ((!empty($inspection_report->side_cover1)) ?$inspection_report->side_cover1 :old('side_cover1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>CAM BORE <span class="text-danger">*</span></label>
                                                    <input type="text" id="side_cover2" placeholder="Enter Value"
                                                           class="form-control " name="side_cover2"
                                                           value="{{ ((!empty($inspection_report->side_cover2)) ?$inspection_report->side_cover2 :old('side_cover2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>TAPPET BORE <span class="text-danger">*</span></label>
                                                    <input type="text" id="side_cover3" placeholder="Enter Value"
                                                           class="form-control " name="side_cover3"
                                                           value="{{ ((!empty($inspection_report->side_cover3)) ?$inspection_report->side_cover3 :old('side_cover3')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">CRANK CASE<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="crank_case1" placeholder="Enter Value"
                                                           class="form-control " name="crank_case1"
                                                           value="{{ ((!empty($inspection_report->crank_case1)) ?$inspection_report->crank_case1 :old('crank_case1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="crank_case2" placeholder="Enter Value"
                                                           class="form-control " name="crank_case2"
                                                           value="{{ ((!empty($inspection_report->crank_case2)) ?$inspection_report->crank_case2 :old('crank_case2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="crank_case3" placeholder="Enter Value"
                                                           class="form-control " name="crank_case3"
                                                           value="{{ ((!empty($inspection_report->crank_case3)) ?$inspection_report->crank_case3 :old('crank_case3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="crank_case4" placeholder="Enter Value"
                                                           class="form-control " name="crank_case4"
                                                           value="{{ ((!empty($inspection_report->crank_case4)) ?$inspection_report->crank_case4 :old('crank_case4')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-3 col-form-label">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsA1" placeholder="Enter Component"
                                                           class="form-control " name="componentsA1"
                                                           value="{{ ((!empty($inspection_report->componentsA1)) ?$inspection_report->componentsA1 :old('componentsA1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsA2" placeholder="Enter Value"
                                                           class="form-control " name="componentsA2"
                                                           value="{{ ((!empty($inspection_report->componentsA2)) ?$inspection_report->componentsA2 :old('componentsA2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsA3" placeholder="Enter Value"
                                                           class="form-control " name="componentsA3"
                                                           value="{{ ((!empty($inspection_report->componentsA3)) ?$inspection_report->componentsA3 :old('componentsA3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsA4" placeholder="Enter Value"
                                                           class="form-control " name="componentsA4"
                                                           value="{{ ((!empty($inspection_report->componentsA4)) ?$inspection_report->componentsA4 :old('componentsA4')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsA5" placeholder="Enter Value"
                                                           class="form-control " name="componentsA5"
                                                           value="{{ ((!empty($inspection_report->componentsA5)) ?$inspection_report->componentsA5 :old('componentsA5')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-3 col-form-label">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsB1" placeholder="Enter Component"
                                                           class="form-control " name="componentsB1"
                                                           value="{{ ((!empty($inspection_report->componentsB1)) ?$inspection_report->componentsB1 :old('componentsB1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsB2" placeholder="Enter Value"
                                                           class="form-control " name="componentsB2"
                                                           value="{{ ((!empty($inspection_report->componentsB2)) ?$inspection_report->componentsB2 :old('componentsB2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsB3" placeholder="Enter Value"
                                                           class="form-control " name="componentsB3"
                                                           value="{{ ((!empty($inspection_report->componentsB3)) ?$inspection_report->componentsB3 :old('componentsB3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsB4" placeholder="Enter Value"
                                                           class="form-control " name="componentsB4"
                                                           value="{{ ((!empty($inspection_report->componentsB4)) ?$inspection_report->componentsB4 :old('componentsB4')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsB5" placeholder="Enter Value"
                                                           class="form-control " name="componentsB5"
                                                           value="{{ ((!empty($inspection_report->componentsB5)) ?$inspection_report->componentsB5 :old('componentsB5')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-3 col-form-label">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsC1" placeholder="Enter Component"
                                                           class="form-control " name="componentsC1"
                                                           value="{{ ((!empty($inspection_report->componentsC1)) ?$inspection_report->componentsC1 :old('componentsC1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsC2" placeholder="Enter Value"
                                                           class="form-control " name="componentsC2"
                                                           value="{{ ((!empty($inspection_report->componentsC2)) ?$inspection_report->componentsC2 :old('componentsC2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsC3" placeholder="Enter Value"
                                                           class="form-control " name="componentsC3"
                                                           value="{{ ((!empty($inspection_report->componentsC3)) ?$inspection_report->componentsC3 :old('componentsC3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsC4" placeholder="Enter Value"
                                                           class="form-control " name="componentsC4"
                                                           value="{{ ((!empty($inspection_report->componentsC4)) ?$inspection_report->componentsC4 :old('componentsC4')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsC5" placeholder="Enter Value"
                                                           class="form-control " name="componentsC5"
                                                           value="{{ ((!empty($inspection_report->componentsC5)) ?$inspection_report->componentsC5 :old('componentsC5')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-3 col-form-label">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsD1" placeholder="Enter Component"
                                                           class="form-control " name="componentsD1"
                                                           value="{{ ((!empty($inspection_report->componentsD1)) ?$inspection_report->componentsD1 :old('componentsD1')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsD2" placeholder="Enter Value"
                                                           class="form-control " name="componentsD2"
                                                           value="{{ ((!empty($inspection_report->componentsD2)) ?$inspection_report->componentsD2 :old('componentsD2')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsD3" placeholder="Enter Value"
                                                           class="form-control " name="componentsD3"
                                                           value="{{ ((!empty($inspection_report->componentsD3)) ?$inspection_report->componentsD3 :old('componentsD3')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsD4" placeholder="Enter Value"
                                                           class="form-control " name="componentsD4"
                                                           value="{{ ((!empty($inspection_report->componentsD4)) ?$inspection_report->componentsD4 :old('componentsD4')) }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" id="componentsD5" placeholder="Enter Value"
                                                           class="form-control " name="componentsD5"
                                                           value="{{ ((!empty($inspection_report->componentsD5)) ?$inspection_report->componentsD5 :old('componentsD5')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array($category_id, array(6, 7, 11, 12, 4)))
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">PARTS REPLACED
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-4 ">
                                                <div class="input-group">
                                                <textarea style="width: 100%" id="parts_replaced"
                                                          placeholder="Enter Part"
                                                          class="form-control" name="parts_replaced"
                                                          rows="3">{{ ((!empty($inspection_report->parts_replaced)) ?$inspection_report->parts_replaced :old('parts_replaced')) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array($category_id, array(5)))
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">EXTERNAL
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-4 ">
                                                <div class="input-group">
                                                <textarea style="width: 100%" id="external" placeholder="Enter"
                                                          class="form-control" name="external"
                                                          rows="3">{{ ((!empty($inspection_report->external)) ?$inspection_report->external :old('external')) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">INTERNAL
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-4 ">
                                                <div class="input-group">
                                                <textarea style="width: 100%" id="internal" placeholder="Enter"
                                                          class="form-control" name="internal"
                                                          rows="3">{{ ((!empty($inspection_report->internal)) ?$inspection_report->internal :old('internal')) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label ">COMPONENT CHANGED / FITTED
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-4 ">
                                                <div class="input-group">
                                                <textarea style="width: 100%" id="component_changed_fitted"
                                                          placeholder="Enter"
                                                          class="form-control" name="component_changed_fitted"
                                                          rows="3">{{ ((!empty($inspection_report->component_changed_fitted)) ?$inspection_report->component_changed_fitted :old('component_changed_fitted')) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    {{--                                    @if($spareItem[0]->optional_status == 'Spare')--}}
                                    @foreach($spareItem as $key=>$value)
                                        <input type="hidden" name="challan_optional_id[]" value="{{ $value->challan_optional_id }}">
                                        <div class="form-group row">
                                            <div class="col-xl-3">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>PRODUCT NAME <span class="text-danger">*</span></label>
                                                    <textarea type="text" id="challan_optional_id" readonly rows="3"
                                                              class="form-control "
                                                              name="challan_optional_id[]">{{$value->product_name}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>COMPLAIN <span class="text-danger">*</span></label>
                                                    <textarea type="text" id="complain" placeholder="Enter Complain"
                                                              rows="3"
                                                              class="form-control "
                                                              name="complain">{{ ((!empty($spare->complain)) ?$spare->complain :old('complain')) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>CO.OBSERVATION<span class="text-danger">*</span></label>
                                                    <textarea type="text" id="observation"
                                                              placeholder="Enter Observation" rows="3"
                                                              class="form-control "
                                                              name="observation">{{ ((!empty($spare->observation)) ?$spare->observation :old('observation')) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>CHANGE(Y/N) <span class="text-danger">*</span></label>
                                                    <input type="text" id="part_change" placeholder="Enter (Y/N)"
                                                           class="form-control " name="part_change"
                                                           value="{{ ((!empty($spare->part_change)) ?$spare->part_change :old('part_change')) }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{--                                    @endif--}}
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label ">CHECKED BY
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <input style="width: 100%" id="checked_by" placeholder="Enter Name"
                                                       class="form-control" name="checked_by"
                                                       value="{{ ((!empty($inspection_report->checked_by)) ?$inspection_report->checked_by :old('checked_by')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label ">COMPANY OBSERVATION
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <input style="width: 100%" id="company_observation"
                                                       placeholder="Enter Name"
                                                       class="form-control" name="company_observation"
                                                       value="{{ ((!empty($inspection_report->company_observation)) ?$inspection_report->company_observation :old('company_observation')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label ">FAULT
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="fault" name="fault"
                                                        class="form-control">
                                                    <option value="">Select Fault</option>
                                                    <option value="">-</option>
                                                    <option value="MFG FAULT">MFG FAULT</option>
                                                    <option value="DEALER CUSTOMER FAULT">DEALER CUSTOMER FAULT
                                                    </option>
                                                    <option value="TRANSPORTATION FAULT">TRANSPORTATION FAULT
                                                    </option>
                                                </select>
                                                <?php if(!empty($inspection_report->fault)){ ?>
                                                <script>document.getElementById("fault").value = '{{ $inspection_report->fault }}';</script>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4 ml-lg-auto">
                                            @if($action=='INSERT')
                                                <button type="submit" class="btn btn-success"
                                                        name="submitButton"><i class="fas fa-save"></i>
                                                    Save
                                                </button>
                                                <a href="{{ url('challan-product-create/'.$challan_id->challan_id) }}"
                                                   class="btn btn-light-primary font-weight-bold"><i class="fas fa-arrow-left"></i>
                                                    Back Challan
                                                </a>
                                            @else
                                                <button type="submit" class="btn btn-warning"
                                                        name="submitButton">
                                                    Update
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
@endpush
