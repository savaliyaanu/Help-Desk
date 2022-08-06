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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Product Wise Report</h2>
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
                    <div class="col-lg-8">
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <!--begin::Form-->
                            <form class="form" id="kt_form_1" method="post"
                                  action="{{($action=='INSERT')? route('product-wise-report.store'):''}}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Complain List <span class="text-danger">*</span></label>
                                                <select type="text" id="complain_service"
                                                        data-live-search="true"
                                                        class="complain-list-select2 form-control  {{ $errors->has('complain_service') ? 'is-invalid' : '' }}"
                                                        name="complain_service">
                                                    <option value="">Select </option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Product Name <span class="text-danger">*</span></label>
                                                <select type="text" id="product_id"
                                                        data-live-search="true"
                                                        class="product-name-select2 form-control  {{ $errors->has('product_id') ? 'is-invalid' : '' }}"
                                                        name="product_id">
                                                    <option value="">Select Product Name</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4 ml-lg-auto">
                                            <button type="submit" class="btn btn-primary font-weight-bold mr-2" target="_blank"
                                                    name="submitButton"><i class="flaticon2-printer"></i>Generate
                                                Report
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
    <script>
        $(".product-name-select2").select2({
            placeholder: "Select Model Name",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-product-name') }}",
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
        $(".complain-list-select2").select2({
            placeholder: "Select Model Name",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-complain-list') }}",
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
