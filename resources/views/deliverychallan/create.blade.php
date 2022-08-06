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
                        <h3 class="subheader-title text-dark font-weight-bold my-2 mr-3">Delivery Challan Out </h3>
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
                @if (session('create-status'))
                    <div class="alert alert-success small  alert-dismissible" role="alert">
                        {{ session('create-status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                        </button>
                    </div>
                @endif
                @if (session('update-status'))
                    <div class="alert alert-warning small  alert-dismissible" role="alert">
                        {{ session('update-status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                        </button>
                    </div>
                @endif
                @if (session('delete-status'))
                    <div class="alert alert-danger small  alert-dismissible" role="alert">
                        {{ session('delete-status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                        </button>
                    </div>
            @endif
            <!--begin::Card-->
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <!--begin::Form-->
                            <form class="form" id="kt_form_1"
                                  action="{{($action=='INSERT')? url('delivery-out/'):route('delivery-out.update',$delivery_challan_out->delivery_challan_out_id)}}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    @if ($action=='UPDATE')
                                        <input type="hidden" name="challan_id"
                                               value="{{$delivery_challan_out->challan_id}}">
                                    @endif
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2">Complain No. <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <select type="text" id="challan_id"
                                                    {{ !empty($delivery_challan_out->challan_id)?'disabled':''}}
                                                    class="form-control kt_select2_5"
                                                    name="challan_id[]" multiple data-live-search="true">
                                                <option value="">Select Complain</option>
                                                @foreach($challan_list as $key=>$item)
                                                    @if($item->branch_id == 1)
                                                        <?php  $complains_no = 'PF-TKT/' . $item->fyear . '/' . $item->complain_no;?>
                                                    @elseif($item->branch_id == 3)
                                                        <?php $complains_no = 'TE-TKT/' . $item->fyear . '/' . $item->complain_no;?>
                                                    @elseif($item->branch_id == 4)
                                                        <?php  $complains_no = 'TP-TKT/' . $item->fyear . '/' . $item->complain_no;?>
                                                    @endif
                                                    <option
                                                        value="{{$item->challan_id}}">{{$complains_no.' - '.$item->client_name}}</option>
                                                @endforeach
                                            </select>
                                            <?php if(!empty($delivery_challan_out->challan_id)){ ?>
                                            <script>document.getElementById("challan_id").value = '{{ $delivery_challan_out->challan_id }}';</script>
                                            <?php } ?>
                                        </div>
                                        <label class="col-form-label text-right col-lg-2">Supplier Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <select type="text" id="supplier_id"
                                                    class="form-control kt_select2_5"
                                                    name="supplier_id" data-live-search="true">
                                                <option value="">Select Supplier Name</option>
                                                @foreach($supplier_list as $key=>$value)
                                                    <option
                                                        value="{{$value->supplier_id}}">{{$value->supplier_name}}</option>
                                                @endforeach
                                            </select>
                                            <?php if(!empty($delivery_challan_out->supplier_id)){ ?>
                                            <script>document.getElementById("supplier_id").value = '{{ $delivery_challan_out->supplier_id }}';</script>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2">Despatched Through <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <input type="text" id="despatched_through"
                                                   class="form-control " placeholder="Enter Despatched Through"
                                                   value="{{ ((!empty($delivery_challan_out->despatched_through)) ?$delivery_challan_out->despatched_through :old('despatched_through'))}}"
                                                   name="despatched_through">
                                        </div>
                                        <label class="col-form-label text-right col-lg-2">Destination <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <input type="text" id="destination"
                                                   class="form-control" placeholder="Enter Destination"
                                                   value="{{ ((!empty($delivery_challan_out->destination)) ?$delivery_challan_out->destination :old('destination'))}}"
                                                   name="destination">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2">Transport Vehicle No.<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <input type="text" id="transport_vehicle"
                                                   class="form-control " placeholder="Transport Vehicle"
                                                   value="{{ ((!empty($delivery_challan_out->transport_vehicle)) ?$delivery_challan_out->transport_vehicle :old('transport_vehicle'))}}"
                                                   name="transport_vehicle">
                                        </div>
                                        <label class="col-form-label text-right col-lg-2">Lr No <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <input type="text" id="lr_no"
                                                   class="form-control " placeholder="Enter Lr No"
                                                   value="{{ ((!empty($delivery_challan_out->lr_no)) ?$delivery_challan_out->lr_no :old('lr_no'))}}"
                                                   name="lr_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
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
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                                <a href="{{url('delivery-out')}}"
                                                   class="btn btn-light-primary font-weight-bold">
                                                    <span class="kt-hidden-mobile">Cancel</span>
                                                </a>
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
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
@endpush
