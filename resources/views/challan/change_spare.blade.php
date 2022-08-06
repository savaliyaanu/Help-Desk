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
                        @include('challan.header')
                        <!--end::Wizard Nav-->
                            <!--begin::Wizard Body-->
                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                <div class="col-xl-12 col-xxl-7">
                                    <!--begin::Wizard Form-->
                                    <!--begin::Wizard Step 1-->
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        <!--begin::Input-->
                                        <input type="hidden" id="challan_id" name="challan_id" value="{{$challan_id}}">
                                        <div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__body">
                                                <!--begin: Datatable -->
                                                <table class="table table-sm" id="">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center"><b>SR</b></th>
                                                        <th class=""><b>PRODUCT NAME</b></th>
                                                        <th class=""><b>CHARGE</b></th>
                                                        <th class="text-center"><b>ACTION</b></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($challanItem as $key=>$value){
                                                    ?>
                                                    <tr>
                                                        <td class="text-center">{{ $i++ }}</td>
                                                        <td>{{ $value->getProduct->product_name }}({{$value->serial_no}}
                                                            )
                                                            <table width="100%" class="">
                                                                <?php if(isset($value->getChangeSpareInfo[0])){ ?>
                                                                <tr>
                                                                    <th class="text-center">Item Name</th>
                                                                    <th class="text-center">Qty</th>
                                                                    <th class="text-center">Unit</th>
                                                                    <th class="text-center">Price</th>
                                                                    <th class="text-center">Amount</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                                <?php } ?>
                                                                <?php $amount = 0; ?>
                                                                @foreach($value->getChangeSpareInfo as $keys=>$values)
                                                                    <tr>
                                                                        <td style="vertical-align: middle;">
                                                                            @if(!empty($values->product_id))
                                                                                {{ $values->getProduct->product_name}}
                                                                                ({{ $values->getProduct->part_code}})
                                                                            @else
                                                                                {{$values->missing_spare}}
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center"> {{ $values->qty}} </td>
                                                                        <td class="text-center"> {{ $values->unit_name}} </td>
                                                                        <td class="text-center"> {{ $values->rate}} </td>
                                                                        <td class="text-center"> {{ $values->qty*$values->rate }} </td>
                                                                        <td class="text-center">
                                                                            <form method="POST" style="display:inline;"
                                                                                  action="{{ route('change-spare-save.destroy',$values->challan_change_spare_id)  }}">
                                                                                {{ csrf_field() }}
                                                                                {{ method_field('DELETE') }}
                                                                                <button type="submit"
                                                                                        class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $amount += $values->qty * $values->rate ?>
                                                                @endforeach
                                                                @if($amount)
                                                                    <tr>
                                                                        <th colspan="3" class="text-center"> Total</th>
                                                                        <th class="text-center"> {{ $amount + $value->product_charge }} </th>
                                                                        <th class="text-center"></th>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                        </td>
                                                        <td style="color: red">
                                                            {{$value->product_charge}}
                                                        </td>
                                                        <td class="text-center" style="vertical-align: middle;">
                                                            <a href="#" class="open-charge-dialog btn-sm"
                                                               data-id="{{$value->challan_product_id}}"
                                                               data-toggle="modal" data-target="#chargeModel">
                                                                Charge </a>
                                                            <a href="#" class="open-copy-dialog btn-sm"
                                                               data-id="{{$value->challan_product_id}}"
                                                               data-toggle="modal" data-target="#spareModel">
                                                                <i class="la la-plus"></i>
                                                            </a>
                                                            <a href="#" class="open-missing-spare-dialog btn-sm"
                                                               data-id="{{$value->challan_product_id}}"
                                                               data-toggle="modal" data-target="#newSpareModel">
                                                                <i class="fas fa-tools"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                            <a href="{{ url('challan-panel-create/'.$challan_id) }}"
                                               class="btn btn-light-primary font-weight-bold mr-2">
                                                <i class="la la-arrow-left"></i>
                                                <span class="kt-hidden-mobile">Previous</span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{url('challan')}}" class="btn btn-danger ">
                                                Finish
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="spareModel" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Spare</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle"></i> </span>
                    </button>
                </div>
                @csrf
                <form class="kt-form"
                      action="{{ route('change-spare-save.store') }}"
                      method="post">
                    <div class="modal-body resolved">
                        <div class="kt-portlet__body">
                            <input type="hidden" id="item_ids" name="item_ids" value="">
                            {{ csrf_field() }}
                            <div class="kt-portlet__body">
                                <div class="kt-form kt-form--fit kt-form--label-right">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Product Name :</label>
                                        <div class="col-lg-8">
                                            <select class="form-control kt_select2_5" data-live-search="true" required
                                                    title="select" name="product_id" style="width: 100%;">
                                                <option value="">Select Product Name</option>
                                                @foreach($spare as $item)
                                                    <option value="{{$item->product_id}}">{{$item->product_name}}
                                                        ({{$item->part_code}})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label   text-right">Qty :</label>
                                        <div class="col-lg-3">
                                            <input type="text" name="spareQty" number="true" class="form-control"
                                                   required
                                                   placeholder="Enter Qty"
                                                   value="">
                                        </div>
                                        <label class="col-lg-2 col-form-label   text-right">Unit :</label>
                                        <div class="col-lg-3">
                                            <select type="text" name="unit_name" class="kt_select2_5 form-control">
                                                <option value="">Select</option>
                                                @foreach($unitMaster as $item)
                                                    <option value="{{$item->unit_name}}">{{$item->unit_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>Add Spare
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="chargeModel" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Product Charges</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle"></i> </span>
                    </button>
                </div>
                @csrf
                <form class="kt-form"
                      action="{{ route('change-spare-save.store') }}"
                      method="post">
                    <div class="modal-body resolved">
                        <div class="kt-portlet__body">
                            <input type="hidden" id="challan_product_ids" name="challan_product_ids" value="">
                            {{ csrf_field() }}
                            <div class="kt-portlet__body">
                                <div class="kt-form kt-form--fit kt-form--label-right">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label   text-right">Charges :</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="product_charge" class="form-control"
                                                   required
                                                   placeholder="Enter Amount"
                                                   value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>Save
                        </button>
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="newSpareModel" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Missing Spare</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle"></i> </span>
                    </button>
                </div>
                @csrf
                <form class="kt-form"
                      action="{{ route('change-spare-save.store') }}"
                      method="post">
                    <div class="modal-body resolved">
                        <div class="kt-portlet__body">
                            <input type="hidden" id="challan_item_ids" name="challan_item_ids" value="">
                            {{ csrf_field() }}
                            <div class="kt-portlet__body">
                                <div class="kt-form kt-form--fit kt-form--label-right">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Product Name :</label>
                                        <div class="col-lg-5">
                                            <input class="form-control " data-live-search="true"
                                                   placeholder="Enter Product Name"
                                                   name="missing_spare" id="missing_spare" style="width: 100%;">
                                        </div>
                                        <label class="col-lg-1 col-form-label">Price :</label>
                                        <div class="col-lg-2">
                                            <input class="form-control " data-live-search="true"
                                                   placeholder="Enter Price"
                                                   name="price" id="price" style="width: 100%;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label   text-right">Qty :</label>
                                        <div class="col-lg-3">
                                            <input type="text" name="spareQty" number="true" class="form-control"
                                                   required
                                                   placeholder="Enter Qty"
                                                   value="">
                                        </div>
                                        <label class="col-lg-2 col-form-label   text-right">Unit :</label>
                                        <div class="col-lg-3">
                                            <select type="text" name="unit_name" class="kt_select2_5 form-control">
                                                <option value="">Select</option>
                                                @foreach($unitMaster as $item)
                                                    <option value="{{$item->unit_name}}">{{$item->unit_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>Add Spare
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/custom/wizard/wizard-1.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>
        $(".spare-product").select2({
            placeholder: "Select a Spare Name",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-spare') }}",
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

        $(document).on("click", ".open-copy-dialog", function () {
            var item_id = $(this).data('id');
            $("#item_ids").val(item_id);
        });
        $(document).on("click", ".open-missing-spare-dialog", function () {
            var challan_item_id = $(this).data('id');
            $("#challan_item_ids").val(challan_item_id);
        });
        $(document).on("click", ".open-charge-dialog", function () {
            var challan_product_id = $(this).data('id');
            $("#challan_product_ids").val(challan_product_id);
        });
    </script>
@endpush
