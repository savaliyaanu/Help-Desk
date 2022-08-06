@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Distributor Wise Report</h2>
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
                                  action="{{($action=='INSERT')? route('distributor-wise-report.store'):''}}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Date</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="input-group date">
                                                <input type="text"
                                                       class="form-control {{ $errors->has('selected_date') ? ' is-invalid' : '' }}"
                                                       name="selected_date" placeholder="Select Date" id="kt_datepicker_3" required
                                                       value="{{ ((!empty($billty->selected_date)) ?$billty->selected_date :old('selected_date')) }}"/>
                                                @if ($errors->has('selected_date'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('selected_date') }}</strong>
                                                </span>
                                                @endif
                                                <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Type
                                        </label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select class="form-control " name="type" id="type"
                                                        onchange="chng(this.value)">
                                                    <option value="Distributor">Distributor</option>
                                                    <option value="Client">Client</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="hide_dis">
                                        <label class="col-form-label text-right col-lg-2 ">Distributor Name
                                        </label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="kt_select2_1" required
                                                        class="form-control select2 " name="distributor_id">
                                                    <option value="">Select Distributor Name</option>
                                                    @foreach($distributor as $key=>$items)
                                                        <option
                                                            value="{{$items->client_id}}">{{$items->client_name.'('.$items->city_name.')'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="hide_cli">
                                        <label class="col-form-label text-right col-lg-2 ">Client Name
                                        </label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="kt_select2_4" required
                                                        class="form-control select2" name="client_id">
                                                    <option value="">Select Client Name</option>
                                                    @foreach($client as $key=>$items)
                                                        <option
                                                            value="{{$items->client_id}}">{{$items->client_name.'('.$items->city_name.')'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4 ml-lg-auto">
                                            <button type="submit" class="btn btn-primary font-weight-bold mr-2"
                                                    target="_blank"
                                                    name="submitButton"><i class="flaticon2-printer"></i>Generate
                                                Statement
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
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>

    <script>
        function chng(value) {
            if (value == 'Client') {
                $("#hide_cli").show();
                $("#hide_dis").hide();
                $('#kt_select2_1, #kt_select2_1_validate').select2({
                    placeholder: "Select a Distributor"
                });
                $('#kt_select2_4').select2({
                    placeholder: "Select a Client",
                    allowClear: true
                });
            } else {
                $("#hide_cli").hide();
                $("#hide_dis").show();
                $('#kt_select2_1, #kt_select2_1_validate').select2({
                    placeholder: "Select a Distributor"
                });
                $('#kt_select2_4').select2({
                    placeholder: "Select a Client",
                    allowClear: true
                });
            }
        }
        chng('Distributor')
    </script>
@endpush
