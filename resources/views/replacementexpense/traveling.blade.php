@extends('layouts.metronic')
@push('styles')
    <link href="{{asset('metronic/assets/css/pages/wizard/wizard-1.css?v=7.0.4')}}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
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
                <div class="card card-custom">
                    <div class="card-body p-0">
                        <!--begin::Wizard-->
                        <div class="wizard wizard-1" id="kt_wizard_v1" data-wizard-state="step-first"
                             data-wizard-clickable="false">
                            <!--begin::Wizard Nav-->
                        @include('replacementexpense.header')
                        <!--end::Wizard Nav-->
                            <!--begin::Wizard Body-->
                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                <div class="col-xl-8">
                                    <!--begin::Wizard Form-->
                                    <form class="form" id="kt_form"
                                          action="{{($action=='INSERT')? url('traveling-expense'):route('traveling-expense.update',$travelingExpense->traveling_expense_id) }}"
                                          method="post">
                                    @if ($action=='UPDATE')
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ csrf_field() }}
                                    <!--begin::Wizard Step 1-->
                                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">

                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Traveling Date <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <input type="text"
                                                                   class="form-control {{ $errors->has('travel_date') ? 'is-invalid' : '' }}"
                                                                   name="travel_date" placeholder="Select Date"
                                                                   id="kt_datepicker_3"
                                                                   value="{{ !empty(old('travel_date'))?old('travel_date'):(!empty($travelingExpense->travel_date)?date('d-m-Y',strtotime($travelingExpense->travel_date)):date('d-m-Y')) }}"/>
                                                            <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar"></i>
                                                    </span>
                                                            </div>
                                                            @if ($errors->has('travel_date'))
                                                                <div class="invalid-feedback">
                                                                    <strong>{{ $errors->first('travel_date') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Night Hault City <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="place" placeholder="Enter City Name"
                                                               name="place"
                                                               class="form-control {{ $errors->has('place') ? 'is-invalid' : '' }}"
                                                               value="{{ ((!empty($travelingExpense->place)) ?$travelingExpense->place :old('place')) }}">
                                                        @if ($errors->has('place'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('place') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Traveling From Time <span
                                                                class="text-danger">*</span></label>
                                                        <input
                                                            class="form-control {{ $errors->has('time_from') ? 'is-invalid' : '' }}"
                                                            id="kt_timepicker_1"
                                                            name="time_from"
                                                            placeholder="Select time"
                                                            type="text"
                                                            value="{{ ((!empty($travelingExpense->time_from)) ?$travelingExpense->time_from :old('time_from'))}}"/>
                                                        @if ($errors->has('time_from'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('time_from') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Traveling To Time <span
                                                                class="text-danger">*</span></label>
                                                        <input
                                                            class="form-control {{ $errors->has('time_to') ? 'is-invalid' : '' }}"
                                                            id="kt_timepicker_1" name="time_to"
                                                            placeholder="Select time"
                                                            type="text"
                                                            value="{{ ((!empty($travelingExpense->time_to)) ?$travelingExpense->time_to :old('time_to'))}}"/>
                                                        @if ($errors->has('time_to'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('time_to') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Traveling Detail <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="traveling_detail" id="traveling_detail"
                                                               class="form-control {{ $errors->has('traveling_detail') ? 'is-invalid' : '' }}"
                                                               placeholder="Enter Traveling Detail"
                                                               value="{{ ((!empty($travelingExpense->traveling_detail)) ?$travelingExpense->traveling_detail :old('traveling_detail'))}}">
                                                        @if ($errors->has('traveling_detail'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('traveling_detail') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Hault <span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Enter Haut " name="hault"
                                                               class="form-control {{ $errors->has('hault') ? 'is-invalid' : '' }}"
                                                               value="{{ ((!empty($travelingExpense->hault)) ?$travelingExpense->hault :old('hault'))}}">
                                                        @if ($errors->has('hault'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('hault') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Journey<span class="text-danger">*</span></label>
                                                        <select type="text" name="journey"
                                                                id="journey"
                                                                class="form-control kt_select2_5 {{ $errors->has('journey') ? 'is-invalid' : '' }}">
                                                            <option value="">Select Journey</option>
                                                            <option
                                                                value="-"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='-' ? 'selected':''}} {{ ((old('journey')=='-')?'selected': '') }}>
                                                                -
                                                            </option>
                                                            <option
                                                                value="TRAIN"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='TRAIN' ? 'selected':''}} {{ ((old('journey')=='TRAIN')?'selected': '') }}>
                                                                TRAIN
                                                            </option>
                                                            <option
                                                                value="AUTO"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='AUTO' ? 'selected':''}} {{ ((old('journey')=='AUTO')?'selected': '') }}>
                                                                AUTO
                                                            </option>
                                                            <option
                                                                value="BUS"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='BUS' ? 'selected':''}} {{ ((old('journey')=='BUS')?'selected': '') }}>
                                                                BUS
                                                            </option>
                                                            <option
                                                                value="JEEP"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='JEEP' ? 'selected':''}} {{ ((old('journey')=='JEEP')?'selected': '') }}>
                                                                JEEP
                                                            </option>
                                                            <option
                                                                value="PRIVATE"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='PRIVATE' ? 'selected':''}} {{ ((old('journey')=='PRIVATE')?'selected': '') }}>
                                                                PRIVATE
                                                            </option>
                                                            <option
                                                                value="VAN"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='VAN' ? 'selected':''}} {{ ((old('journey')=='VAN')?'selected': '') }}>
                                                                VAN
                                                            </option>
                                                            <option
                                                                value="P.CAR"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='P.CAR' ? 'selected':''}} {{ ((old('journey')=='P.CAR')?'selected': '') }}>
                                                                P.CAR
                                                            </option>
                                                            <option
                                                                value="C.CAR"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='C.CAR' ? 'selected':''}} {{ ((old('journey')=='C.CAR')?'selected': '') }}>
                                                                C.CAR
                                                            </option>
                                                            <option
                                                                value="D.CAR"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='D.CAR' ? 'selected':''}} {{ ((old('journey')=='D.CAR')?'selected': '') }}>
                                                                D.CAR
                                                            </option>
                                                            <option
                                                                value="BIKE"{{ !empty($travelingExpense->journey) && $travelingExpense->journey=='BIKE' ? 'selected':''}} {{ ((old('journey')=='BIKE')?'selected': '') }}>
                                                                BIKE
                                                            </option>

                                                        </select>
                                                        @if ($errors->has('journey'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('journey') }}</strong>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Amount <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <input type="text" name="amount" placeholder="Enter Amount"
                                                                   class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                                                   value="{{ ((!empty($travelingExpense->amount)) ?$travelingExpense->amount :old('amount'))}}">
                                                            @if ($errors->has('amount'))
                                                                <div class="invalid-feedback">
                                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--begin::Wizard Actions-->
                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
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
                                                            <i class="fas fa-save"></i> Save Traveling Expense
                                                        </button>
                                                        <a href="{{url('service-expense')}}"
                                                           class="btn btn-light-primary font-weight-bold">
                                                            Cancel
                                                        </a>
                                                    @else
                                                        <button type="submit"
                                                                class="btn btn-warning">
                                                            <i class="fas fa-save"></i> Update
                                                        </button>
                                                    @endif
                                                    <a href="{{url('service-expense')}}" class="btn btn-danger">
                                                        Finish
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Wizard Actions-->
                                    </form>
                                </div>
                                <!--end::Wizard Form-->
                            </div>
                            <!--end::Wizard Body-->
                        </div>
                    </div>
                    <!--end::Wizard-->
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline mr-5">
                        <!--begin::Page Title-->
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Traveling Expense List</h2>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Dropdown-->
                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions"
                         data-placement="left">
                        <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-header font-weight-bold py-4">
                                    <span class="font-size-lg">Choose Label:</span>
                                    <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip"
                                       data-placement="right" title="Click to learn more..."></i>
                                </li>
                                <li class="navi-separator mb-3 opacity-70"></li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span
                                                                class="label label-xl label-inline label-light-success">Customer</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span
                                                                class="label label-xl label-inline label-light-danger">Partner</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span
                                                                class="label label-xl label-inline label-light-warning">Suplier</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span
                                                                class="label label-xl label-inline label-light-primary">Member</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-dark">Staff</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-separator mt-3 opacity-70"></li>
                                <li class="navi-footer py-4">
                                    <a class="btn btn-clean font-weight-bold btn-sm" href="#">
                                        <i class="ki ki-plus icon-sm"></i>Add new</a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                    <!--end::Dropdown-->
                    <!--begin::Button-->

                    <!--end::Button-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="mb-7">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-xl-8">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 my-2 my-md-0">
                                            <div class="input-icon">
                                                <input type="text" class="form-control" placeholder="Search..."
                                                       id="kt_datatable_search_query"/>
                                                <span>
																	<i class="flaticon2-search-1 text-muted"></i>
																</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2 my-md-0">
                                            <div class="d-flex align-items-center">
                                                <label class="mr-3 mb-0 d-none d-md-block">Place:</label>
                                                <select class="form-control kt_select2_5"
                                                        id="kt_datatable_search_status">
                                                    <option value="">All</option>
                                                    @foreach($expenseDetail as $value)
                                                        <option value="{{$value->place}}">{{$value->place}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                            <tr>
                                <th>SR. No</th>
                                <th>Traveling date</th>
                                <th>Traveling Detail</th>
                                <th>Time From</th>
                                <th>Time To</th>
                                <th>Place</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($expenseDetail))
                                @php $i=1 @endphp
                                @foreach ($expenseDetail as $key=>$item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ date('d-m-Y',strtotime($item->travel_date))}}</td>
                                        <td>{{ $item->traveling_detail}}</td>
                                        <td>{{ $item->time_from}}</td>
                                        <td>{{ $item->time_to}}</td>
                                        <td>{{ $item->place}}</td>
                                        <td>{{ $item->amount}}</td>
                                        <td>
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                               href="{{url('traveling-expense/'.$item->traveling_expense_id.'/edit')}}">
                                                <i class="flaticon2-pen"></i>
                                            </a>
                                            <form method="POST" style="display:inline;"
                                                  action="{{ route('traveling-expense.destroy',$item->traveling_expense_id)  }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/custom/wizard/wizard-1.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-timepicker.js?v=7.0.4')}}"></script>
@endpush
