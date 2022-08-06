@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3"></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                @if (session('create-status'))
                    <div class="alert alert-custom alert-notice alert-light-success fade show mb-5" role="alert">
                        <div class="alert-icon">
                            <i class="flaticon2-check-mark"></i>
                        </div>
                        <div class="alert-text">{{ session('create-status') }}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
																	<span aria-hidden="true">
																		<i class="ki ki-close"></i>
																	</span>
                            </button>
                        </div>
                    </div>
                @endif
                @if (session('update-status'))
                    <div class="alert alert-custom alert-notice alert-light-warning fade show mb-5" role="alert">
                        <div class="alert-icon">
                            <i class="flaticon-warning"></i>
                        </div>
                        <div class="alert-text">{{ session('update-status') }}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
																	<span aria-hidden="true">
																		<i class="ki ki-close"></i>
																	</span>
                            </button>
                        </div>
                    </div>
                @endif
                @if (session('delete-status'))
                    <div class="alert alert-custom alert-notice alert-light-primary fade show mb-5" role="alert">
                        <div class="alert-icon">
                            <i class="flaticon-delete-1"></i>
                        </div>
                        <div class="alert-text">{{ session('delete-status') }}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
																	<span aria-hidden="true">
																		<i class="ki ki-close"></i>
																	</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="card card-custom example example-compact">
                    <form class="form" id="kt_form"
                          action="{{($action=='INSERT')? url('engine-testing'):route('engine-testing.update',$testing_master->challan_testing_id) }}"
                          method="post">
                        @if ($action=='UPDATE')
                            {{ method_field('PUT') }}
                        @endif
                        {{ csrf_field() }}
                        <div class="card-body">
                            @if(in_array($category_id, array(1,5,8,11,3)))
                                <input type="hidden" name="challan_product_id" value="{{ $challan_product_id }}">
                                <input type="hidden" name="challan_id" value="{{ $challan_id->challan_id }}">
                                <div id="common_field">
                                    <div class="row">
                                        <div class="col-xl-4" id="check_date">

                                            <div class="form-group">
                                                <label>Checking Date <span class="text-danger">*</span></label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" name="checking_date"
                                                           placeholder="Select date" id="kt_datepicker_3"
                                                           value="{{ !empty(old('checking_date'))?old('checking_date'):(!empty($testing_master->checking_date)?date('d-m-Y',strtotime($testing_master->checking_date)):date('d-m-Y')) }}"/>
                                                    <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4" id="tested_by">
                                            <div class="form-group">
                                                <label>Testing By <span class="text-danger">*</span></label>
                                                <input type="text" id="testing_by"
                                                       class="form-control " placeholder="Enter Checker Name"
                                                       name="testing_by"
                                                       value="{{ ((!empty($testing_master->testing_by)) ?$testing_master->testing_by :old('testing_by'))}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-10"></div>
                            @endif
                            @if(in_array($category_id, array(1,3)))
                                @if($category_id == 1)
                                    <h3>Engine Testing :</h3>
                                    <div class="separator separator-dashed my-10"></div>
                                @else
                                    <h3> MonoSet Testing :</h3>
                                    <div class="separator separator-dashed my-10"></div>
                                @endif
                                <div id="testing_engine">
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Reading <span class="text-danger">*</span></label>
                                                <input type="text" id="reading"
                                                       class="form-control" placeholder="Enter Reading"
                                                       name="reading"
                                                       value="{{ ((!empty($engine_testing->reading)) ?$engine_testing->reading :old('reading'))}}"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>S.F.C. <span class="text-danger">*</span></label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" name="sfc"
                                                           placeholder="Enter S.F.C." id='sfc'
                                                           value="{{ ((!empty($engine_testing->sfc)) ?$engine_testing->sfc :old('sfc'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Temp RPM <span class="text-danger">*</span></label>
                                                <input type="text" id="temp_rpm"
                                                       class="form-control " placeholder="Enter Temp RPM"
                                                       name="temp_rpm"
                                                       value="{{ ((!empty($engine_testing->temp_rpm)) ?$engine_testing->temp_rpm :old('temp_rpm'))}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Temp % <span class="text-danger">*</span></label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" name="temp_percentage"
                                                           placeholder="Enter Temp Percentage" id='temp_percentage'
                                                           value="{{ ((!empty($engine_testing->temp_percentage)) ?$engine_testing->temp_percentage :old('temp_percentage'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Perm RPM <span class="text-danger">*</span></label>
                                                <input type="text" id="perm_rpm"
                                                       class="form-control " placeholder="Enter Perm RPM"
                                                       name="perm_rpm"
                                                       value="{{ ((!empty($engine_testing->perm_rpm)) ?$engine_testing->perm_rpm :old('perm_rpm'))}}"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Perm % <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="perm_percentage"
                                                           placeholder="Enter Prem Percentage" id='perm_percentage'
                                                           value="{{ ((!empty($engine_testing->perm_percentage)) ?$engine_testing->perm_percentage :old('perm_percentage'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(in_array($category_id, array(8)))
                                <h3> Diesel Generating Set Testing :</h3>
                                <div class="separator separator-dashed my-10"></div>
                                <div id="testing_generator">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>AC Voltage(N.L) <span class="text-danger">*</span></label>
                                                    <input type="text" id="ac_voltage"
                                                           class="form-control" placeholder="Enter AC Voltage"
                                                           name="ac_voltage"
                                                           value="{{ ((!empty($generator_testing->ac_voltage)) ?$generator_testing->ac_voltage :old('ac_voltage'))}}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>DC Voltage(N.L) <span class="text-danger">*</span></label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="dc_voltage_nl"
                                                               placeholder="Enter DC Voltage" id="dc_voltage_nl"
                                                               value="{{ ((!empty($generator_testing->dc_voltage_nl)) ?$generator_testing->dc_voltage_nl :old('dc_voltage_nl'))}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>DC Amp(N.L) <span class="text-danger">*</span></label>
                                                    <input type="text" id="dc_amp_nl"
                                                           class="form-control " placeholder="Enter DC Amp"
                                                           name="dc_amp_nl"
                                                           value="{{ ((!empty($generator_testing->dc_amp_nl)) ?$generator_testing->dc_amp_nl :old('dc_amp_nl'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>RPM(N.L) <span class="text-danger">*</span></label>
                                                    <input type="text" id="rpm_nl"
                                                           class="form-control" placeholder="Enter RPM"
                                                           name="rpm_nl"
                                                           value="{{ ((!empty($generator_testing->rpm_nl)) ?$generator_testing->rpm_nl :old('rpm_nl'))}}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>AC Voltage(I.F.L) <span class="text-danger">*</span></label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="ac_voltage_ifl"
                                                               placeholder="Enter AC Voltage I.F.L" id='ac_voltage_ifl'
                                                               value="{{ ((!empty($generator_testing->ac_voltage_ifl)) ?$generator_testing->ac_voltage_ifl :old('ac_voltage_ifl'))}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>AC Voltage(R.F.L) <span class="text-danger">*</span></label>
                                                    <input type="text" id="ac_voltage_rfl"
                                                           class="form-control " placeholder="Enter AC Voltage(R.F.L)"
                                                           name="ac_voltage_rfl"
                                                           value="{{ ((!empty($generator_testing->ac_voltage_rfl)) ?$generator_testing->ac_voltage_rfl :old('ac_voltage_rfl'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>AC Voltage(0.8PF 10%OL) <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="ac_voltage_pf"
                                                           class="form-control"
                                                           placeholder="Enter AC Voltage(0.8PF 10%OL)"
                                                           name="ac_voltage_pf"
                                                           value="{{ ((!empty($generator_testing->ac_voltage_pf)) ?$generator_testing->ac_voltage_pf :old('ac_voltage_pf'))}}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>AC Amp(0.8 P.F.L) <span class="text-danger">*</span></label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="ac_amp_pfl"
                                                               placeholder="Enter AC Amp(0.8 P.F.L)" id="ac_amp_pfl"
                                                               value="{{ ((!empty($generator_testing->ac_amp_pfl)) ?$generator_testing->ac_amp_pfl :old('ac_amp_pfl'))}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>Watts(0.8 P.F.L) <span class="text-danger">*</span></label>
                                                    <input type="text" id="watts"
                                                           class="form-control " placeholder="Enter Watts(0.8 P.F.L)"
                                                           name="watts"
                                                           value="{{ ((!empty($generator_testing->watts)) ?$generator_testing->watts :old('watts'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>DC Voltage(0.8 P.F.L) <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="dc_voltage_fl"
                                                           class="form-control"
                                                           placeholder="Enter DC Voltage(0.8 P.F.L)"
                                                           name="dc_voltage_fl"
                                                           value="{{ ((!empty($generator_testing->dc_voltage_fl)) ?$generator_testing->dc_voltage_fl :old('dc_voltage_fl'))}}"/>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>DC Amp(0.8 P.F.L) <span class="text-danger">*</span></label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="dc_amp_fl"
                                                               placeholder="Enter DC Amp(0.8 P.F.L)" id="dc_amp_fl"
                                                               value="{{ ((!empty($generator_testing->dc_amp_fl)) ?$generator_testing->dc_amp_fl :old('dc_amp_fl'))}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>RPM(0.8 P.F.L) <span class="text-danger">*</span></label>
                                                    <input type="text" id="rpm_fl"
                                                           class="form-control " placeholder="Enter RPM(0.8 P.F.L)"
                                                           name="rpm_fl"
                                                           value="{{ ((!empty($generator_testing->rpm_fl)) ?$generator_testing->rpm_fl :old('rpm_fl'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>Amount Temp. C <span class="text-danger">*</span></label>
                                                    <input type="text" id="amount_temp"
                                                           class="form-control" placeholder="Enter Amount Temp. C"
                                                           name="amount_temp"
                                                           value="{{ ((!empty($generator_testing->amount_temp)) ?$generator_testing->amount_temp :old('amount_temp'))}}"/>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>Stator Main Winding <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control"
                                                               name="stator_main_winding"
                                                               placeholder="Enter Stator Main Winding"
                                                               id="stator_main_winding"
                                                               value="{{ ((!empty($generator_testing->stator_main_winding)) ?$generator_testing->stator_main_winding :old('stator_main_winding'))}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>Stator Aux Winding <span class="text-danger">*</span></label>
                                                    <input type="text" id="stator_aux_winding"
                                                           class="form-control " placeholder="Enter Stator Aux Winding"
                                                           name="stator_aux_winding"
                                                           value="{{ ((!empty($generator_testing->stator_aux_winding)) ?$generator_testing->stator_aux_winding :old('stator_aux_winding'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>Ex Fld/C Wng Resistance in <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="ex_fld_wnd_regi"
                                                           class="form-control"
                                                           placeholder="Enter Ex Fld/C Wng Resistance in"
                                                           name="ex_fld_wnd_regi"
                                                           value="{{ ((!empty($generator_testing->ex_fld_wnd_regi)) ?$generator_testing->ex_fld_wnd_regi :old('ex_fld_wnd_regi'))}}"/>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>Ex Arm/L Wng Resistance in <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="ex_arm_wnd_regi"
                                                               placeholder="Enter Ex Arm/L Wng Resistance in"
                                                               id="ex_arm_wnd_regi"
                                                               value="{{ ((!empty($generator_testing->ex_arm_wnd_regi)) ?$generator_testing->ex_arm_wnd_regi :old('ex_arm_wnd_regi'))}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>AC Voltage(0.8 P.F.L) <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="ac_voltage_pfl"
                                                           class="form-control "
                                                           placeholder="Enter AC Voltage(0.8 P.F.L"
                                                           name="ac_voltage_pfl"
                                                           value="{{ ((!empty($generator_testing->ac_voltage_pfl)) ?$generator_testing->ac_voltage_pfl :old('ac_voltage_pfl'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>AC Amp(10% OL)AVR 'OL' Pot Set <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="ac_amp_ol"
                                                           class="form-control"
                                                           placeholder="Enter AC Amp(10% OL)AVR 'OL' Pot Set"
                                                           name="ac_amp_ol"
                                                           value="{{ ((!empty($generator_testing->ac_amp_ol)) ?$generator_testing->ac_amp_ol :old('ac_amp_ol'))}}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>(R.F.L) <span class="text-danger">*</span></label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="rfl"
                                                               placeholder="Enter (R.F.L)" id="rfl"
                                                               value="{{ ((!empty($generator_testing->rfl)) ?$generator_testing->rfl :old('rfl'))}}"/>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>V.R.%(I.F.L) <span class="text-danger">*</span></label>
                                                    <input type="text" id="vr_ifl"
                                                           class="form-control " placeholder="Enter V.R.%(I.F.L)"
                                                           name="vr_ifl"
                                                           value="{{ ((!empty($generator_testing->vr_ifl)) ?$generator_testing->vr_ifl :old('vr_ifl'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>Rotor Winding Resistance in <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="regi"
                                                           class="form-control"
                                                           placeholder="Enter Rotor Winding Resistance in"
                                                           name="regi"
                                                           value="{{ ((!empty($generator_testing->regi)) ?$generator_testing->regi :old('regi'))}}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">

                                                <div class="form-group">
                                                    <label>Brand <span class="text-danger">*</span></label>
                                                    <select type="text" id="kbl" name="kbl"
                                                            class="form-control ">
                                                        <option value="">Select Brand</option>
                                                        <option value="topland" selected>Topland</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(in_array($category_id, array(5)))
                                <h3>Alternator Testing :</h3>
                                <div class="separator separator-dashed my-10"></div>
                                <div id="welding_generator_testing">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 ">Temperature
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-4 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="temperature" required
                                                           placeholder="0"
                                                           class="form-control" name="temperature"
                                                           value="{{ ((!empty($welding_testing->temperature)) ?$welding_testing->temperature :old('temperature'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">Voltage
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Low <span class="text-danger">*</span></label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="voltage_low"
                                                               placeholder="0" id='voltage_low'
                                                               value="{{ ((!empty($welding_testing->voltage_low)) ?$welding_testing->voltage_low :old('voltage_low'))}}"/>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>High <span class="text-danger">*</span></label>
                                                    <input type="text" id="voltage_high"
                                                           class="form-control " placeholder="0"
                                                           name="voltage_high"
                                                           value="{{ ((!empty($welding_testing->voltage_high)) ?$welding_testing->voltage_high :old('voltage_high'))}}"/>

                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Lighting <span class="text-danger">*</span></label>
                                                    <input type="text" id="voltage_lighting"
                                                           class="form-control " placeholder="0"
                                                           name="voltage_lighting"
                                                           value="{{ ((!empty($welding_testing->voltage_lighting)) ?$welding_testing->voltage_lighting :old('voltage_lighting'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 ">No Load <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="no_load1"
                                                           placeholder="0"
                                                           class="form-control" name="no_load1"
                                                           value="{{ ((!empty($welding_testing->no_load1)) ?$welding_testing->no_load1 :old('no_load1'))}}"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="no_load2"
                                                           placeholder="0"
                                                           class="form-control" name="no_load2"
                                                           value="{{ ((!empty($welding_testing->no_load2)) ?$welding_testing->no_load2 :old('no_load2'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="no_load3"
                                                           placeholder="0"
                                                           class="form-control" name="no_load3"
                                                           value="{{ ((!empty($welding_testing->no_load3)) ?$welding_testing->no_load3 :old('no_load3'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="no_load4"
                                                           placeholder="0"
                                                           class="form-control" name="no_load4"
                                                           value="{{ ((!empty($welding_testing->no_load4)) ?$welding_testing->no_load4 :old('no_load4'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="no_load5"
                                                           placeholder="0"
                                                           class="form-control" name="no_load5"
                                                           value="{{ ((!empty($welding_testing->no_load5)) ?$welding_testing->no_load5 :old('no_load5'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="no_load6"
                                                           placeholder="0"
                                                           class="form-control" name="no_load6"
                                                           value="{{ ((!empty($welding_testing->no_load6)) ?$welding_testing->no_load6 :old('no_load6'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="no_load7"
                                                           placeholder="0"
                                                           class="form-control" name="no_load7"
                                                           value="{{ ((!empty($welding_testing->no_load7)) ?$welding_testing->no_load7 :old('no_load7'))}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 ">Resistive Load <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="resistive_load1"
                                                           placeholder="0"
                                                           class="form-control" name="resistive_load1"
                                                           value="{{ ((!empty($welding_testing->resistive_load1)) ?$welding_testing->resistive_load1 :old('resistive_load1'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="resistive_load2"
                                                           placeholder="0"
                                                           class="form-control" name="resistive_load2"
                                                           value="{{ ((!empty($welding_testing->resistive_load2)) ?$welding_testing->resistive_load2 :old('resistive_load2'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="resistive_load3"
                                                           placeholder="0"
                                                           class="form-control" name="resistive_load3"
                                                           value="{{ ((!empty($welding_testing->resistive_load3)) ?$welding_testing->resistive_load3 :old('resistive_load3'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="resistive_load4"
                                                           placeholder="0"
                                                           class="form-control" name="resistive_load4"
                                                           value="{{ ((!empty($welding_testing->resistive_load4)) ?$welding_testing->resistive_load4 :old('resistive_load4'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="resistive_load5"
                                                           placeholder="0"
                                                           class="form-control" name="resistive_load5"
                                                           value="{{ ((!empty($welding_testing->resistive_load5)) ?$welding_testing->resistive_load5 :old('resistive_load5'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="resistive_load6"
                                                           placeholder="0"
                                                           class="form-control" name="resistive_load6"
                                                           value="{{ ((!empty($welding_testing->resistive_load6)) ?$welding_testing->resistive_load6 :old('resistive_load6'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="resistive_load7"
                                                           placeholder="0"
                                                           class="form-control" name="resistive_load7"
                                                           value="{{ ((!empty($welding_testing->resistive_load7)) ?$welding_testing->resistive_load7 :old('resistive_load7'))}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 ">Welding Low <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_low1"
                                                           placeholder="0"
                                                           class="form-control" name="welding_low1"
                                                           value="{{ ((!empty($welding_testing->welding_low1)) ?$welding_testing->welding_low1 :old('welding_low1'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_low2"
                                                           placeholder="0"
                                                           class="form-control" name="welding_low2"
                                                           value="{{ ((!empty($welding_testing->welding_low2)) ?$welding_testing->welding_low2 :old('welding_low2'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_low3"
                                                           placeholder="0"
                                                           class="form-control" name="welding_low3"
                                                           value="{{ ((!empty($welding_testing->welding_low3)) ?$welding_testing->welding_low3 :old('welding_low3'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_low4"
                                                           placeholder="0"
                                                           class="form-control" name="welding_low4"
                                                           value="{{ ((!empty($welding_testing->welding_low4)) ?$welding_testing->welding_low4 :old('welding_low4'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_low5"
                                                           placeholder="0"
                                                           class="form-control" name="welding_low5"
                                                           value="{{ ((!empty($welding_testing->welding_low5)) ?$welding_testing->welding_low5 :old('welding_low5'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_low6"
                                                           placeholder="0"
                                                           class="form-control" name="welding_low6"
                                                           value="{{ ((!empty($welding_testing->welding_low6)) ?$welding_testing->welding_low6 :old('welding_low6'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_low7"
                                                           placeholder="0"
                                                           class="form-control" name="welding_low7"
                                                           value="{{ ((!empty($welding_testing->welding_low7)) ?$welding_testing->welding_low7 :old('welding_low7'))}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 ">Welding High <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_high1"
                                                           placeholder="0"
                                                           class="form-control" name="welding_high1"
                                                           value="{{ ((!empty($welding_testing->welding_high1)) ?$welding_testing->welding_high1 :old('welding_high1'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_high2"
                                                           placeholder="0"
                                                           class="form-control" name="welding_high2"
                                                           value="{{ ((!empty($welding_testing->welding_high2)) ?$welding_testing->welding_high2 :old('welding_high2'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_high3"
                                                           placeholder="0"
                                                           class="form-control" name="welding_high3"
                                                           value="{{ ((!empty($welding_testing->welding_high3)) ?$welding_testing->welding_high3 :old('welding_high3'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_high4"
                                                           placeholder="0"
                                                           class="form-control" name="welding_high4"
                                                           value="{{ ((!empty($welding_testing->welding_high4)) ?$welding_testing->welding_high4 :old('welding_high4'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_high5"
                                                           placeholder="0"
                                                           class="form-control" name="welding_high5"
                                                           value="{{ ((!empty($welding_testing->welding_high5)) ?$welding_testing->welding_high5 :old('welding_high5'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_high6"
                                                           placeholder="0"
                                                           class="form-control" name="welding_high6"
                                                           value="{{ ((!empty($welding_testing->welding_high6)) ?$welding_testing->welding_high6 :old('welding_high6'))}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="input-group">
                                                    <input style="width: 100%" id="welding_high7"
                                                           placeholder="0"
                                                           class="form-control" name="welding_high7"
                                                           value="{{ ((!empty($welding_testing->welding_high7)) ?$welding_testing->welding_high7 :old('welding_high7'))}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(in_array($category_id, array(11)))
                                <h3>Borewell  Testing :</h3>
                                <div class="separator separator-dashed my-10"></div>
                                <div id="borewell_testing">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">Voltage
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" name="voltage1"
                                                           placeholder="0" id='voltage1'
                                                           value="{{ ((!empty($borewell_testing->voltage1)) ?$borewell_testing->voltage1 :old('voltage1'))}}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="voltage2"
                                                       class="form-control " placeholder="0"
                                                       name="voltage2"
                                                       value="{{ ((!empty($borewell_testing->voltage2)) ?$borewell_testing->voltage2 :old('voltage2'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="voltage3"
                                                       class="form-control " placeholder="0"
                                                       name="voltage3"
                                                       value="{{ ((!empty($borewell_testing->voltage3)) ?$borewell_testing->voltage3 :old('voltage3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">N.L Amp
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <input type="text" class="form-control" name="nl_amp1"
                                                       placeholder="0" id='nl_amp1'
                                                       value="{{ ((!empty($borewell_testing->nl_amp1)) ?$borewell_testing->nl_amp1 :old('nl_amp1'))}}"/>

                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="nl_amp2"
                                                       class="form-control " placeholder="0"
                                                       name="nl_amp2"
                                                       value="{{ ((!empty($borewell_testing->nl_amp2)) ?$borewell_testing->nl_amp2 :old('nl_amp2'))}}"/>

                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="nl_amp3"
                                                       class="form-control " placeholder="0"
                                                       name="nl_amp3"
                                                       value="{{ ((!empty($borewell_testing->nl_amp3)) ?$borewell_testing->nl_amp3 :old('nl_amp3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">S/O. Head
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <input type="text" class="form-control" name="so_head1"
                                                       placeholder="0" id='so_head1'
                                                       value="{{ ((!empty($borewell_testing->so_head1)) ?$borewell_testing->so_head1 :old('so_head1'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="so_head2"
                                                       class="form-control " placeholder="0"
                                                       name="so_head2"
                                                       value="{{ ((!empty($borewell_testing->so_head2)) ?$borewell_testing->so_head2 :old('so_head2'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="so_head3"
                                                       class="form-control " placeholder="0"
                                                       name="so_head3"
                                                       value="{{ ((!empty($borewell_testing->so_head3)) ?$borewell_testing->so_head3 :old('so_head3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">Max. Amp.
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <input type="text" class="form-control" name="max_amp1"
                                                       placeholder="0" id='max_amp1'
                                                       value="{{ ((!empty($borewell_testing->max_amp1)) ?$borewell_testing->max_amp1 :old('max_amp1'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="max_amp2"
                                                       class="form-control " placeholder="0"
                                                       name="max_amp2"
                                                       value="{{ ((!empty($borewell_testing->max_amp2)) ?$borewell_testing->max_amp2 :old('max_amp2'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="max_amp3"
                                                       class="form-control " placeholder="0"
                                                       name="max_amp3"
                                                       value="{{ ((!empty($borewell_testing->max_amp3)) ?$borewell_testing->max_amp3 :old('max_amp3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">HZ
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <input type="text" class="form-control" name="hz1"
                                                       placeholder="0" id='hz1'
                                                       value="{{ ((!empty($borewell_testing->hz1)) ?$borewell_testing->hz1 :old('hz1'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="hz2"
                                                       class="form-control " placeholder="0"
                                                       name="hz2"
                                                       value="{{ ((!empty($borewell_testing->hz2)) ?$borewell_testing->hz2 :old('hz2'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="hz3"
                                                       class="form-control " placeholder="0"
                                                       name="hz3"
                                                       value="{{ ((!empty($borewell_testing->hz3)) ?$borewell_testing->hz3 :old('hz3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">PF
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <input type="text" class="form-control" name="pf1"
                                                       placeholder="0" id='pf1'
                                                       value="{{ ((!empty($borewell_testing->pf1)) ?$borewell_testing->pf1 :old('pf1'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="pf2"
                                                       class="form-control " placeholder="0"
                                                       name="pf2"
                                                       value="{{ ((!empty($borewell_testing->pf2)) ?$borewell_testing->pf2 :old('pf2'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="pf3"
                                                       class="form-control " placeholder="0"
                                                       name="pf3"
                                                       value="{{ ((!empty($borewell_testing->pf3)) ?$borewell_testing->pf3 :old('pf3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">KW
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <input type="text" class="form-control" name="kw1"
                                                       placeholder="0" id='kw1'
                                                       value="{{ ((!empty($borewell_testing->kw1)) ?$borewell_testing->kw1 :old('kw1'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="kw2"
                                                       class="form-control " placeholder="0"
                                                       name="kw2"
                                                       value="{{ ((!empty($borewell_testing->kw2)) ?$borewell_testing->kw2 :old('kw2'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="kw3"
                                                       class="form-control " placeholder="0"
                                                       name="kw3"
                                                       value="{{ ((!empty($borewell_testing->kw3)) ?$borewell_testing->kw3 :old('kw3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">D.P. Amp.
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <input type="text" class="form-control" name="dp_amp1"
                                                       placeholder="0" id='dp_amp1'
                                                       value="{{ ((!empty($borewell_testing->dp_amp1)) ?$borewell_testing->dp_amp1 :old('dp_amp1'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="dp_amp2"
                                                       class="form-control " placeholder="0"
                                                       name="dp_amp2"
                                                       value="{{ ((!empty($borewell_testing->dp_amp2)) ?$borewell_testing->dp_amp2 :old('dp_amp2'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="dp_amp3"
                                                       class="form-control " placeholder="0"
                                                       name="dp_amp3"
                                                       value="{{ ((!empty($borewell_testing->dp_amp3)) ?$borewell_testing->dp_amp3 :old('dp_amp3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">D.P. Head.
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <input type="text" class="form-control" name="dp_head1"
                                                       placeholder="0" id='dp_head1'
                                                       value="{{ ((!empty($borewell_testing->dp_head1)) ?$borewell_testing->dp_head1 :old('dp_head1'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="dp_head2"
                                                       class="form-control " placeholder="0"
                                                       name="dp_head2"
                                                       value="{{ ((!empty($borewell_testing->dp_head2)) ?$borewell_testing->dp_head2 :old('dp_head2'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="dp_head3"
                                                       class="form-control " placeholder="0"
                                                       name="dp_head3"
                                                       value="{{ ((!empty($borewell_testing->dp_head3)) ?$borewell_testing->dp_head3 :old('dp_head3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label  col-lg-2 ">Disch.
                                                <span class="text-danger">*</span></label>
                                            <div class="col-xl-3">
                                                <input type="text" class="form-control" name="disch1"
                                                       placeholder="0" id='disch1'
                                                       value="{{ ((!empty($borewell_testing->disch1)) ?$borewell_testing->disch1 :old('disch1'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="disch2"
                                                       class="form-control " placeholder="0"
                                                       name="disch2"
                                                       value="{{ ((!empty($borewell_testing->disch2)) ?$borewell_testing->disch2 :old('disch2'))}}"/>
                                            </div>
                                            <div class="col-xl-3">
                                                <input type="text" id="disch3"
                                                       class="form-control " placeholder="0"
                                                       name="disch3"
                                                       value="{{ ((!empty($borewell_testing->disch3)) ?$borewell_testing->disch3 :old('disch3'))}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 ">Remark
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-4 ">
                                        <textarea style="width: 100%" id="remark" required
                                                  placeholder="Enter Remark"
                                                  class="form-control"
                                                  name="remark">{{ ((!empty($borewell_testing->remark)) ?$borewell_testing->remark :old('remark')) }}
                                        </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="container">
                            <div class="d-flex justify-content-between border-top mt-5 pt-10 card-footer">
                                <div class="mr-2">
                                    <a href="{{ url('challan-product-create/'.$challan_id->challan_id) }}"
                                       class="btn btn-light-danger font-weight-bold mr-2">
                                        <i class="la la-arrow-left"></i>
                                        <span class="kt-hidden-mobile">Previous</span>
                                    </a>
                                </div>
                                <div>
                                    @if($action=='INSERT')
                                        <button type="submit"
                                                class="btn btn-success">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                        <a href="{{url('challan-product-create/'.$challan_id->challan_id)}}"
                                           class="btn btn-light-primary font-weight-bold">
                                            Cancel
                                        </a>
                                    @else
                                        <button type="submit"
                                                class="btn btn-warning">
                                            Update Product
                                        </button>
                                    @endif
                                    <a href="{{url('challan')}}"
                                       class="btn btn-danger">
                                        Finish
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-widgets.js')}}?v=7.0.4"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
@endpush
