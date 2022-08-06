@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Mechanic Wise Report</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom example example-compact">
                            <form class="form" id="kt_form_1" method="post"
                                  action="{{($action=='INSERT')? route('mechanic-wise-report.store'):''}}"
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
                                        <label class="col-form-label text-right col-lg-2 ">Mechanic Name
                                        </label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="mechanic_id" required
                                                        class="form-control kt_select2_5" name="mechanic_id">
                                                    <option value="">Select Mechanic Name</option>
                                                    @foreach($mechanicList as $key=>$items)
                                                        <option
                                                            value="{{$items->mechanic_id}}">{{$items->mechanic_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4 ml-lg-auto">
                                            <button type="submit" class="btn btn-primary font-weight-bold mr-2" target="_blank"
                                                    name="submitButton"><i class="flaticon2-printer"></i>Generate Statement
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
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
