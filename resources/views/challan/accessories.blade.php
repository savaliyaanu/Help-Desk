@extends('layouts.metronic')
@push('styles')
    <link href="{{asset('metronic/assets/css/pages/wizard/wizard-1.css?v=7.0.4')}}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">`
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
                        @include('challan.header')
                        <!--end::Wizard Nav-->
                            <!--begin::Wizard Body-->
                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                <div class="col-xl-8">
                                    <!--begin::Wizard Form-->
                                    <form class="form" id="kt_form"
                                          action="{{($action=='INSERT')? url('challan-accessories'):route('challan-accessories.update',$accessoriesChallan->challan_accessories_id) }}"
                                          method="post">
                                        @if ($action=='UPDATE')
                                            {{ method_field('PUT') }}
                                        @endif
                                            {{ csrf_field() }}

                                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                            <div class="row">
                                                <input type="hidden" name="challan_id" id="challan_id" value="{{ $challan_id }}">
                                                <div class="col-xl-8">
                                                    <div class="form-group">
                                                        <label>Accessories Name <span class="text-danger">*</span>
                                                        </label>
                                                        <select type="text" required
                                                                class="form-control kt_select2_5" id="accessories_id"
                                                                name="accessories_id" data-live-search="true">
                                                            <option value="">Select Accessories Name</option>
                                                            @foreach ($accessories_master as $key=>$item)
                                                                <option
                                                                    value="{{$item->accessories_id}}">{{$item->accessories_name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <?php if(!empty($accessoriesChallan->accessories_id)){ ?>
                                                        <script>document.getElementById("accessories_id").value = '{{ $accessoriesChallan->accessories_id }}';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-4">
                                                    <div class="form-group">
                                                        <label>Quantity <span class="text-danger">*</span> </label>
                                                        <input type="text"
                                                               class="form-control" id="accessories_qty"
                                                               name="accessories_qty"
                                                               placeholder="Enter Quantity in Digit" required
                                                               value="{{ ((!empty($accessoriesChallan->accessories_qty)) ?$accessoriesChallan->accessories_qty :old('accessories_qty'))}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="form-group">
                                                        <label>Unit <span class="text-danger">*</span> </label>
                                                        <select type="text"
                                                                class="form-control kt_select2_5"
                                                                id="accessories_unit_name"
                                                                name="accessories_unit_name">
                                                            <option></option>
                                                            @foreach($unitMaster as $item)
                                                                <option
                                                                    value="{{$item->unit_name}}">{{$item->unit_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <?php if(!empty($accessoriesChallan->accessories_unit_name)){ ?>
                                                        <script>document.getElementById("accessories_unit_name").value = '{{ $accessoriesChallan->accessories_unit_name }}';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                            <div class="mr-2">
                                                <a href="{{ url('challan-product-create/'.$challan_id) }}"
                                                   class="btn btn-light-primary font-weight-bold mr-2">
                                                    <i class="la la-arrow-left"></i>
                                                    <span class="kt-hidden-mobile">Previous</span>
                                                </a>
                                            </div>
                                            <div class="text-left">
                                                @if($action=='INSERT')
                                                    <button type="submit"
                                                            class="btn btn-success">
                                                        <i class="fas fa-save"></i>Add Accessories
                                                    </button>
                                                @else
                                                    <button type="submit"
                                                            class="btn btn-warning">
                                                        <i class="fas fa-save"></i> Update Accessories
                                                    </button>
                                                @endif
                                                    <a href="{{ url('challan-accessories-create/'.$challan_id) }}"
                                                       class="btn btn-light-primary font-weight-bold">
                                                        <span class="kt-hidden-mobile">Cancel</span>
                                                    </a>
                                                <a href="{{url('challan-panel-create/'.$challan_id)}}"
                                                   class="btn btn-light-dark font-weight-bold">
                                                    <span class="kt-hidden-mobile">Next</span>
                                                    <i class="la la-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!--end::Wizard Actions-->
                                    </form>
                                    <!--end::Wizard Form-->
                                </div>
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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Accessories List</h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <!--end::Toolbar-->
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">


                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                            <tr>
                                <th>Accessories Name</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($challanAccessories))
                                @foreach ($challanAccessories as $key=>$item)
                                    <tr>
                                        <td>{{ $item->accessories_name }}</td>
                                        <td class="text-center">{{ $item->accessories_qty }}</td>
                                        <td class="text-center">{{ $item->accessories_unit_name }}</td>
                                        <td class="text-center">
                                            {{--                                            @if (Auth::user()->can('update', $item))--}}
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                               href="{{ url('challan-accessories/'.$item->challan_accessories_id.'/edit') }}">
                                                <i class="flaticon2-pen"></i>
                                            </a>
                                            {{--                                            @endif--}}
                                            {{--                                            @if (Auth::user()->can('delete', $item))--}}
                                            <form method="POST" style="display:inline;"
                                                  action="{{ route('challan-accessories.destroy',$item->challan_accessories_id)  }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit"
                                                        class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                                </button>
                                            </form>
                                            {{--                                            @endif--}}
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
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
@endpush
