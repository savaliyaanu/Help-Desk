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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Challan Report</h2>
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
                                  action="{{($action=='INSERT')? route('challan-report.store'):''}}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Branch Name
                                            <span class="text-danger"> *</span> </label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="branch_id" required
                                                        class="form-control kt_select2_5" name="branch_id">
                                                    <option value="">Select Branch Name</option>
                                                    @foreach($branch as $key=>$items)
                                                        <option
                                                            value="{{$items->branch_id}}">{{$items->branch_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Date Range
                                            <span class="text-danger"> *</span></label>
                                        <div class="col-lg-4 ">
                                            <div class="input-daterange input-group" id="kt_datepicker_5">
                                                <input type="text" class="form-control" required
                                                       name="from_date" placeholder="Enter Date"
                                                       autocomplete="off"/>
                                                <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-ellipsis-h"></i>
															</span>
                                                </div>
                                                <input type="text" class="form-control" name="to_date" required
                                                       placeholder="Enter Date"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Client Name
                                         </label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="client_id" required
                                                        class="form-control kt_select2_5" name="client_id">
                                                    <option value="">Select Client Name</option>
                                                    @foreach($clientDetail as $key=>$items)
                                                        <option
                                                            value="{{$items->client_id}}">{{$items->client_name.' ('.$items->city_name.')'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Report Type</label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="report_type" required
                                                        class="form-control kt_select2_5" name="report_type">
                                                    <option value="All">ALL</option>
                                                    <option value="Pending">PENDING</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4 ml-lg-auto">
                                            <button type="submit" class="btn btn-primary font-weight-bold mr-2" formtarget="_blank"
                                                    name="submitButton"><i class="flaticon2-printer"></i>Generate Statement
                                            </button>
                                            <button type="reset" class="btn btn-light-primary font-weight-bold">Cancel
                                            </button>
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
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>

        $(document).ready(function () {


            $('#generate_drive_control_report').click(function () {
                $('#drive_control_report_form').submit();
            });
            $('#k_timepicker_2, #k_timepicker_2_modal').timepicker();
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
            // range picker
            $('#kt_datepicker_5').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                templates: arrows
            });

        });

    </script>
@endpush
