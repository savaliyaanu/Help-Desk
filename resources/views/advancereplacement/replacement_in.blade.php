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
                        <h3 class="subheader-title text-dark font-weight-bold my-2 mr-3">Advance Replacement Product
                            Inward</h3>
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
                                  action="{{($action=='INSERT')? url('advance-replacement-in'):route('advance-replacement-in.update','')}}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Bill No</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                       name="bill_no" placeholder="Enter Bill No"
                                                       id="bill_no"
                                                       value="{{ ((!empty($replacement_in->bill_no)) ?$replacement_in->bill_no :old('bill_no')) }}">
                                            </div>
                                        </div>
                                        <label class="col-form-label text-right col-lg-2 ">Transport Name
                                            *</label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select id="transport_id"
                                                        class="form-control kt_select2_5" name="transport_id">
                                                    <option value="">Select Transport Name</option>
                                                    @foreach($transport_list as $key=>$value)
                                                        <option
                                                            value="{{$value->transport_id}}">{{$value->transport_name}}</option>
                                                    @endforeach
                                                </select>
                                                <?php if(!empty($replacement_in->transport_id)){ ?>
                                                <script>document.getElementById("transport_id").value = '<?php echo $replacement_in->transport_id; ?>';</script>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Billty No
                                            *</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input style="width: 100%" id="billty_no" class="form-control"
                                                       name="billty_no" placeholder="Enter Billty No"
                                                       value="{{ ((!empty($replacement_in->billty_no)) ?$replacement_in->billty_no :old('billty_no')) }}">
                                            </div>
                                        </div>
                                        <label class="col-form-label text-right col-lg-2 ">Inward Date*</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control"
                                                       name="inward_date" placeholder="Select Date" id="kt_datepicker_3"
                                                       value="{{ ((!empty($replacement_in->inward_date)) ?$replacement_in->inward_date :old('inward_date')) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10 card-footer">
                                        <div class="mr-2">
                                            <a href="{{ url('advance-replacement') }}"
                                               class="btn btn-light-danger font-weight-bold mr-2">
                                                <i class="la la-arrow-left"></i>
                                                <span class="kt-hidden-mobile">Previous</span>
                                            </a>
                                        </div>
                                        <div>
                                            @if($action=='INSERT')
                                                <button type="submit"
                                                        class="btn btn-success">
                                                    <i class="fas fa-save"></i>   Save
                                                </button>
                                                <a href="{{url('advance-replacement')}}"
                                                   class="btn btn-light-primary font-weight-bold">
                                                    Cancel
                                                </a>
                                            @else
                                                <button type="submit"
                                                        class="btn btn-warning">
                                                    <i class="fas fa-save"></i> Update
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
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
@endpush
