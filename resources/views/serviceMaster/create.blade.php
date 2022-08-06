@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Service Station Master</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom example example-compact">
                            <form class="form" id="kt_form_1" method="post"
                                  action="{{($action=='INSERT')? route('service-station-detail.store'):route('service-station-detail.update',$station->station_id) }}">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Station Name
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <input type="text"
                                                   class="form-control {{ $errors->has('station_name') ? ' is-invalid' : '' }}"
                                                   name="station_name"
                                                   placeholder="Enter Station Name"
                                                   value="{{ ((!empty($station->station_name)) ?$station->station_name :old('station_name')) }}"/>
                                            @if ($errors->has('station_name'))
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('station_name') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Station Address <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <textarea type="text"
                                                          class="form-control {{ $errors->has('station_address') ? ' is-invalid' : '' }}"
                                                          name="station_address"
                                                          placeholder="Enter Address">{{ ((!empty($station->station_address)) ?$station->station_address :old('station_address')) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Contact Person<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control  {{ $errors->has('contact_person_name') ? ' is-invalid' : '' }}"
                                                       name="contact_person_name" placeholder="Person Name" required
                                                       value="{{ ((!empty($station->contact_person_name)) ?$station->contact_person_name :old('contact_person_name')) }}"/>
                                                @if ($errors->has('contact_person_name'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact_person_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Contact Number<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control  {{ $errors->has('contact_no') ? ' is-invalid' : '' }}"
                                                       name="contact_no" placeholder="Contact Number"
                                                       value="{{ ((!empty($station->contact_no)) ?$station->contact_no :old('contact_no')) }}"/>
                                                @if ($errors->has('contact_no'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact_no') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">E-Mail<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <input type="email"
                                                       class="form-control  {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                       name="email" placeholder="E-Mail"
                                                       value="{{ ((!empty($station->email)) ?$station->email :old('email')) }}"/>
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10  card-footer">
                                        <div class="mr-2">
                                        </div>
                                        <div>
                                            @if($action=='INSERT')
                                                <button type="submit"
                                                        class="btn btn-success">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                            @else
                                                <button type="submit"
                                                        class="btn btn-warning">
                                                    <i class="fas fa-save"></i>Update
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
@endpush
