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
                        @include('destroy.header')
                        <!--end::Wizard Nav-->
                            <!--begin::Wizard Body-->
                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                <div class="col-xl-8">
                                    <!--begin::Wizard Form-->
                                    <form class="form" id="kt_form"
                                          action="{{($action=='INSERT')? url('destroy-items'):route('destroy-items.update',$destroyItem->destroy_item_id) }}"
                                          method="post">
                                    @if ($action=='UPDATE')
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ csrf_field() }}
                                    <!--begin::Wizard Step 1-->
                                        <div class="pb-5" data-wizard-type="step-content">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Product Name<span class="text-danger">*</span> </label>
                                                        <select type="text" id="product_id" name="product_id"
                                                                class="form-control kt_select2_5"
                                                                data-live-search="true"
                                                                title="Select Product Name">
                                                            <option value="">Select Product Name</option>
                                                            @foreach ($challanDetails as $key=>$item)
                                                                <option
                                                                    value="{{$item->challan_product_id}}">{{$item->getProduct->product_name}} ({{$item->serial_no}})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Spare Name<span class="text-danger">*</span> </label>
                                                        <select type="text" id="challan_optional_id"
                                                                name="challan_optional_id"
                                                                class="form-control kt_select2_5"
                                                                data-live-search="true"
                                                                title="Select Product Name">
                                                            <option value="">Select Spare Name</option>
                                                            @foreach($spareDetail as $key=>$items)
                                                                <option
                                                                    value="{{$items->challan_optional_id}}">{{$items->getProduct->product_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Remark <span class="text-danger">*</span></label>
                                                        <textarea type="text" name="remark" id="remark"
                                                                  placeholder="Enter Remark"
                                                                  class="form-control">{{ ((!empty($destroyItem->remark)) ?$destroyItem->remark :old('remark')) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--begin::Wizard Actions-->
                                            <div class="container">
                                                <div
                                                    class="d-flex justify-content-between border-top mt-5 pt-10  card-footer">
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
                                                                <i class="fas fa-save"></i> Save Product
                                                            </button>
                                                            <a href="{{route('destroy.index')}}"
                                                               class="btn btn-light-primary font-weight-bold">
                                                                Cancel
                                                            </a>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn-warning">
                                                                <i class="fas fa-save"></i>Update
                                                            </button>
                                                        @endif
                                                        <a href="{{url('destroy')}}"
                                                           class="btn btn-danger">
                                                            Finish
                                                        </a>
                                                    </div>
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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Item List</h2>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
                            <li class="breadcrumb-item">
                                <a href="" class="text-muted">Transaction</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('destroy.index')}}" class="text-muted">Destroy</a>
                            </li>

                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="">
                            <thead>
                            <tr>
                                <th class="text-center">Sr</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Type Name</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($destroyList))
                                @php $i=1 @endphp
                                @foreach ($destroyList as $key=>$item)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-center">{{ $item->product_name }}</td>
                                        <td class="text-center">{{ $item->type }}</td>
                                        <td class="text-center">{{ $item->remark }}</td>
                                        <td class="text-center">
                                            <form method="POST" style="display:inline;"
                                                  action="{{ route('destroy-items.destroy',$item->destroy_item_id)  }}">
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
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
@endpush
