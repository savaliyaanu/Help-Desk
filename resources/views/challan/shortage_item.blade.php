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
                                          action="{{($action=='INSERT')? route('challan-shortage-item.store'):route('challan-shortage-item.update',$shortage_item->challan_shortage_item_id) }}"
                                          method="post">
                                        @if ($action=='UPDATE')
                                            {{ method_field('PUT') }}
                                        @endif
                                        {{ csrf_field() }}
                                        <!--begin::Wizard Step 1-->
                                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                            <!--begin::Input-->
                                            <input type="hidden" name="challan_product_id"
                                                   value="{{ $challan_product_id }}">
                                            <input type="hidden" name="challan_id"
                                                   value="{{ $category_id->challan_id }}">
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-lg-2">Shortage List</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <select class="form-control kt_select2_5"
                                                            id="shortage_item_master_id"
                                                            name="shortage_item_master_id">
                                                        <option value="">Select Shortage List</option>
                                                        @foreach ($shortageList as $key=>$item)
                                                            <option value="{{$item->shortage_item_master_id }}">{{$item->shortage_name}} ({{$item->particulars}})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <?php if(!empty($shortage_item->shortage_item_master_id)){ ?>
                                                    <script>document.getElementById("shortage_item_master_id").value = '{{ $shortage_item->shortage_item_master_id }}';</script>
                                                    <?php } ?>
                                                </div>
                                                <label class="col-form-label text-right col-lg-2">Qty</label>
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    <input class="form-control "
                                                           id="shortage_qty" placeholder="Qty"
                                                           name="shortage_qty"
                                                           value="{{ ((!empty($shortage_item->shortage_qty)) ?$shortage_item->shortage_qty :old('shortage_qty'))}}"/>

                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Wizard Step 5-->
                                        <!--begin::Wizard Actions-->
                                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                            <div class="mr-2">
                                            </div>
                                            <div>
                                                @if($action=='INSERT')
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save"></i> Add Shortage Item
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fas fa-save"></i> Update Shortage Item
                                                    </button>
                                                @endif
                                                <a href="{{url('challan-shortage-item/'.$challan_product_id)}}"
                                                   class="btn btn-light-primary font-weight-bold">
                                                    Cancel
                                                </a>
                                                <a href="{{ url('challan-product-create/'.$category_id->challan_id) }}"
                                                   class="btn btn-danger">
                                                    Back Challan
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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Item List</h2>
                        <!--end::Page Title-->
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
                                <th>Sr. No.</th>
                                <th class="text-center">Shortage Item Name</th>
                                <th class="text-center">Shortage Qty</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($shortageListTable as $key => $value){
                                ?>
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$value->shortage_name}}</td>
                                <td>{{$value->shortage_qty}}</td>
                                <td>

                                    <a class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Edit Product"
                                       href="{{ url('challan-shortage-item/'.$value->challan_shortage_item_id.'/edit') }}">
                                        <i class="flaticon2-pen"></i>
                                    </a>

                                    <form method="POST" style="display:inline;"
                                          action="{{ route('challan-shortage-item.destroy',$value->challan_shortage_item_id)  }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                                title="Delete Product">
                                            <i class="flaticon2-rubbish-bin-delete-button"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            <?php } ?>
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
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
@endpush
