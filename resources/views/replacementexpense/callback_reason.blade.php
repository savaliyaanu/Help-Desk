@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
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
            <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
                <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center flex-wrap mr-1">
                        <!--begin::Page Heading-->
                        <div class="d-flex align-items-baseline mr-5">
                            <!--begin::Page Title-->
                            <h3 class="subheader-title text-dark font-weight-bold my-2 mr-3">Service Station
                                Callback</h3>
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
                                      action="{{($action=='INSERT')? url('callback-reason'):route('callback-reason.update','') }}">
                                    @if ($action=='UPDATE')
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="form-group row">
                                            {{--                                        <input type="hidden" name="expense_id" value="{{ $expense_id }}">--}}
                                            <label class="col-form-label text-right col-lg-2">Reason For Callback <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                                <select type="text" id="reason_for_callback" name="reason_for_callback"
                                                        class="form-control kt_select2_5">
                                                    <option value="">Select Reason</option>
                                                    <option
                                                        value="Poor Site Condition"{{ !empty($callback->reason_for_callback) && $callback->reason_for_callback=='Poor Site Condition' ? 'selected':''}} {{ ((old('reason_for_callback')=='Poor Site Condition')?'selected': '') }}>
                                                        Poor Site Condition
                                                    </option>
                                                    <option
                                                        value=" Wrong Product Selection"{{ !empty($callback->reason_for_callback) && $callback->reason_for_callback==' Wrong Product Selection' ? 'selected':''}} {{ ((old('reason_for_callback')==' Wrong Product Selection')?'selected': '') }}>
                                                        Wrong Product Selection
                                                    </option>
                                                    <option
                                                        value="Wrong Communication by Dealer"{{ !empty($callback->reason_for_callback) && $callback->reason_for_callback=='Wrong Communication by Dealer' ? 'selected':''}} {{ ((old('reason_for_callback')=='Wrong Communication by Dealer')?'selected': '') }}>
                                                        Wrong Communication by Dealer
                                                    </option>
                                                    <option
                                                        value="Wrong communication by Customer"{{ !empty($callback->reason_for_callback) && $callback->reason_for_callback=='Wrong communication by Customer' ? 'selected':''}} {{ ((old('reason_for_callback')=='Wrong communication by Customer')?'selected': '') }}>
                                                        Wrong communication by Customer
                                                    </option>
                                                    <option
                                                        value="Mechanic Not Able to Solve"{{ !empty($callback->reason_for_callback) && $callback->reason_for_callback=='Mechanic Not Able to Solve' ? 'selected':''}} {{ ((old('reason_for_callback')=='Mechanic Not Able to Solve')?'selected': '') }}>
                                                        Mechanic Not Able to Solve
                                                    </option>
                                                    <option
                                                        value="Other Reasons"{{ !empty($callback->reason_for_callback) && $callback->reason_for_callback=='Other Reasons' ? 'selected':''}} {{ ((old('reason_for_callback')=='Other Reasons')?'selected': '') }}>
                                                        Other Reasons
                                                    </option>
                                                </select>
                                                <?php if(!empty($callback->reason_for_callback)){ ?>
                                                <script>document.getElementById("reason_for_callback").value = '<?php echo $callback->reason_for_callback; ?>';</script>
                                                <?php } ?>
                                            </div>
                                            <label class="col-form-label text-right col-lg-2 ">Remark
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-4 ">
                                                <div class="input-group">
                                                <textarea class="form-control" name="remark"
                                                          placeholder="Enter a Remark"
                                                          rows="3">{{ ((!empty($callback->remark)) ?$callback->remark :old('remark')) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container ">
                                        <div class="d-flex justify-content-between border-top mt-5 pt-10 card-footer">
                                            <div class="mr-2">
                                                <a href="{{ url()->previous() }}"
                                                   class="btn btn-light-danger font-weight-bold mr-2">
                                                    <i class="la la-arrow-left"></i>
                                                    <span class="kt-hidden-mobile">Previous</span>
                                                </a>
                                            </div>
                                            <div>
                                                @if($action=='INSERT')
                                                    <button type="submit"
                                                            class="btn btn-success">
                                                        <i class="fas fa-save"></i>Save
                                                    </button>
                                                    <a href="{{url('service-expense')}}"
                                                       class="btn btn-light-primary font-weight-bold">
                                                        Cancel
                                                    </a>
                                                @else
                                                    <button type="submit"
                                                            class="btn btn-warning">
                                                        <i class="fas fa-save"></i>Update
                                                    </button>
                                                @endif
                                                <a href="{{url('service-expense')}}" class="btn btn-danger">
                                                    Finish
                                                </a>
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
    </div>
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
@endpush
