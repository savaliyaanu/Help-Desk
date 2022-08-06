@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Credit Note Report</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-custom example example-compact">
                            <!--begin::Form-->
                            <form class="form" id="kt_form_1" method="post"
                                  action="{{($action=='INSERT')? route('credit-note-report.store'):''}}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Date Range</label>
                                        <div class="col-lg-4 ">
                                            <div class="input-daterange input-group" id="kt_datepicker_5">
                                                <input type="text" class="form-control {{ $errors->has('from_date') ? ' is-invalid' : '' }}"
                                                       name="from_date" placeholder="Enter Date"
                                                       autocomplete="off"/>
                                                <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-ellipsis-h"></i>
															</span>
                                                </div>
                                                <input type="text" class="form-control {{ $errors->has('to_date') ? ' is-invalid' : '' }}" name="to_date"
                                                       placeholder="Enter Date"/>
                                            </div>
                                            @if ($errors->has('from_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('from_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Client Name </label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="client_id"
                                                        class="form-control  kt_select2_5 {{ $errors->has('client_id') ? ' is-invalid' : '' }}" name="client_id">
                                                    <option value="">Select Client Name</option>
                                                    @foreach($clientDetail as $key=>$items)
                                                        <option
                                                            value="{{$items->client_id}}">{{$items->client_name.' ('.$items->city_name.')'}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('client_id'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('client_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4 ml-lg-auto">
                                            <button type="submit" class="btn btn-primary font-weight-bold mr-2" traget="_blank"
                                                    name="submitButton"><i class="flaticon2-printer"></i>Print Pdf
                                            </button>
                                            <button type="reset" class="btn btn-light-primary font-weight-bold">Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>
        $(".client-select2").select2({
            placeholder: "Select a Client",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-client-name') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    </script>
@endpush
