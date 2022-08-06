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
                <div class="card card-custom">
                    <div class="card-body p-0">
                        <!--begin::Wizard-->
                        <div class="wizard wizard-1" id="kt_wizard_v1" data-wizard-state="step-first"
                             data-wizard-clickable="false">
                            <!--begin::Wizard Nav-->
                        @include('invoice.header')
                        <!--end::Wizard Nav-->
                            <!--begin::Wizard Body-->
                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                <div class="col-xl-8">
                                    <!--begin::Wizard Form-->
                                    <form class="form" id="kt_form"
                                          action="{{($action=='INSERT')? url('invoice'):route('invoice.update',$invoiceDetail->invoice_id) }}"
                                          method="post">
                                    @if ($action=='UPDATE')
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ csrf_field() }}
                                    <!--begin::Wizard Step 1-->
                                        <div class="pb-5" data-wizard-type="step-content">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <!--begin::Input-->
                                                    @if ($action=='UPDATE')
                                                        <input type="hidden" name="challan_id"
                                                               value="{{$invoiceDetail->challan_id}}">
                                                    @endif
                                                    <div class="form-group">
                                                        <label>Complain No <span class="text-danger">*</span></label>
                                                        <select type="text" id="challan_id" name="challan_id"
                                                                class="form-control kt_select2_5"
                                                                {{ !empty($invoiceDetail->challan_id)?'disabled':''}}
                                                                data-live-search="true"
                                                                onchange="getChallanDetails(this.value)" required
                                                                title="Select Challan Number">
                                                            <option value="">Select Complain</option>
                                                            @foreach($challanList as $key=>$items)
                                                                @if($items->branch_id == 1)
                                                                    <?php  $complains_no = 'PF-TKT/' . $items->fyear . '/' . $items->complain_no;?>
                                                                @elseif($items->branch_id == 3)
                                                                    <?php $complains_no = 'TE-TKT/' . $items->fyear . '/' . $items->complain_no;?>
                                                                @elseif($items->branch_id == 4)
                                                                    <?php  $complains_no = 'TP-TKT/' . $items->fyear . '/' . $items->complain_no;?>
                                                                @endif
                                                                <option
                                                                    value="{{$items->challan_id}}">{{$complains_no. ' - '.$items->client_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <?php if(!empty($invoiceDetail->challan_id)){ ?>
                                                        <script>document.getElementById("challan_id").value = '<?php echo $invoiceDetail->challan_id; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Invoice Date <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <input type="text" required class="form-control"
                                                                   name="invoice_date" placeholder="Select Invoice Date"
                                                                   id="kt_datepicker_3"
                                                                   value="{{ !empty(old('invoice_date'))?old('invoice_date'):(!empty($invoiceDetail->invoice_date)?date('d-m-Y',strtotime($invoiceDetail->invoice_date)):date('d-m-Y')) }}">
                                                            <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-calendar"></i>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Challan date<span class="text-danger">*</span></label>
                                                        <input type="text" id="created_at" placeholder="Read Date"
                                                               readonly
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="client_id" name="client_id">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Client Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="client_name" name="client_name" readonly
                                                               placeholder="Read Client Name"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Transport Name <span class="text-danger">*</span></label>
                                                        <select type="text" required
                                                                class="form-control kt_select2_5"
                                                                name="transport_id" id="transport_id"
                                                                data-live-search="true"
                                                                title="Select Transport Name">
                                                            <option value="">Select Transport</option>
                                                            @foreach($transportList as $key=>$items)
                                                                <option
                                                                    value="{{$items->transport_id}}">{{$items->transport_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <?php if(!empty($invoiceDetail->transport_id)){ ?>
                                                        <script>document.getElementById("transport_id").value = '<?php echo $invoiceDetail->transport_id; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <label>View Accessories <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4 ">
                                                        <span class="switch switch-icon">
                                                            <label>
                                                                <input type="checkbox" id="view_accessories"
                                                                       name="view_accessories"
                                                                        {{ ((isset($invoiceDetail->view_accessories) && $invoiceDetail->view_accessories=='Y')?'checked':'') }} >
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>LR. No <span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Enter LR.No." required
                                                               class="form-control" id="lr_no "
                                                               name="lr_no"
                                                               value="{{ ((!empty($invoiceDetail->lr_no)) ?$invoiceDetail->lr_no :old('lr_no'))}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>LR. Date <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <input type="text" required
                                                                   class="form-control"
                                                                   name="lr_date" placeholder="Select Invoice Date"
                                                                   id="kt_datepicker_3_modal"
                                                                   value="{{ !empty(old('lr_date'))?old('lr_date'):(!empty($invoiceDetail->lr_date)?date('d-m-Y',strtotime($invoiceDetail->lr_date)):date('d-m-Y')) }}">
                                                            <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-calendar"></i>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Lory No <span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Enter LR.No." required
                                                               class="form-control" id="lory_no "
                                                               name="lory_no"
                                                               value="{{ ((!empty($invoiceDetail->lory_no)) ?$invoiceDetail->lory_no :old('lory_no'))}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Remark <span class="text-danger">*</span></label>
                                                        <textarea type="text" placeholder="Enter Remark"
                                                                  class="form-control" id="remark" title="Enter Remark"
                                                                  name="remark">{{ ((!empty($invoiceDetail->remark)) ?$invoiceDetail->remark :old('remark'))}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-3 col-form-label">Change
                                                    Develiry Address<span class="text-danger">*</span></label>
                                                <div class="col-3">
                                                <span class="switch switch-outline switch-icon switch-danger">
                                                    <label>
                                                        <input type="checkbox" id="change_develiry"
                                                               class="{{ $errors->has('change_develiry_address') ? ' is-invalid' : '' }}"
                                                               name="change_develiry_address"
                                                               id="change_develiry_address"
                                                               onclick="changeDeveliry()"
                                                    {{ ((isset($invoiceDetail->change_develiry_address) && $invoiceDetail->change_develiry_address=='Y') ?'checked':'') }}>
                                                        @if ($errors->has('change_bill_address'))
                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('change_bill_address') }}</strong>
                                                               </span>
                                                        @endif
                                                        <span></span>
                                                    </label>
                                                </span>

                                                </div>
                                            </div>
                                            <div id="billingInfo" style="display: none">
                                                <div class="form-group row">
                                                    <label>Billing Name <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                           class="form-control"
                                                           name="billing_name"
                                                           placeholder="Enter Bill Name"
                                                           value="{{ ((!empty($invoiceDetail->billing_name)) ?$invoiceDetail->billing_name :old('billing_name'))}}"/>
                                                    @if ($errors->has('billing_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('billing_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Address1 <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="address1" placeholder="Enter Address"
                                                                   value="{{ ((!empty($invoiceDetail->address1)) ?$invoiceDetail->address1 :old('address1'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Address2 <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="address2" placeholder="Enter Address"
                                                                   value="{{ ((!empty($invoiceDetail->address2)) ?$invoiceDetail->address2 :old('address2'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Address3 <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="address3" placeholder="Enter Address"
                                                                   value="{{ ((!empty($invoiceDetail->address3)) ?$invoiceDetail->address3 :old('address3'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>City <span class="text-danger">*</span></label>
                                                            <select type="text" style="width: 100%;"
                                                                    class="form-control kt_select2_5"
                                                                    name="city_id" id="city_id">
                                                                <option value="">Select City</option>
                                                                @foreach($cityList as $key=>$items)
                                                                    <option
                                                                        value="{{$items->city_id}}">{{$items->city_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <?php if(!empty($invoiceDetail->city_id)){ ?>
                                                            <script>document.getElementById("city_id").value = '<?php echo $invoiceDetail->city_id; ?>';</script>
                                                            <?php } ?>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>PinCode <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="pincode" placeholder="Enter PinCode"
                                                                   value="{{ ((!empty($invoiceDetail->pincode)) ?$invoiceDetail->pincode :old('pincode'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>GST NO. <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control gstinnumber"
                                                                   name="gst_no" placeholder="Enter GST NO"
                                                                   value="{{ ((!empty($invoiceDetail->gst_no)) ?$invoiceDetail->gst_no :old('gst_no'))}}">
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Contact Person <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="contact_person" placeholder="Enter Name"
                                                                   value="{{ ((!empty($invoiceDetail->contact_person)) ?$invoiceDetail->contact_person :old('contact_person'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Phone No. <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="phone" placeholder="Enter Number"
                                                                   value="{{ ((!empty($invoiceDetail->phone)) ?$invoiceDetail->phone :old('phone'))}}">
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Mobile No. <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="mobile" placeholder="Enter Mobile Number"
                                                                   value="{{ ((!empty($invoiceDetail->mobile)) ?$invoiceDetail->mobile :old('mobile'))}}">
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Wizard Step 5-->
                                            <!--begin::Wizard Actions-->
                                            <div
                                                class="d-flex justify-content-between border-top mt-5 pt-10  card-footer">
                                                <div class="mr-2">
                                                </div>
                                                <div>
                                                    @if($action=='INSERT')
                                                        <button type="submit"
                                                                class="btn btn-success">
                                                            <i class="fas fa-save"></i>Save & Next
                                                        </button>
                                                        <a href="{{route('invoice.index')}}"
                                                           class="btn btn-light-primary font-weight-bold">
                                                            Cancel
                                                        </a>
                                                    @else
                                                        <button type="submit"
                                                                class="btn btn-warning">
                                                            <i class="fas fa-save"></i>Update Invoice
                                                        </button>
                                                    @endif

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
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/custom/wizard/wizard-1.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>
        function changeDeveliry() {
            if (document.getElementById('change_develiry').checked) {
                document.getElementById('billingInfo').setAttribute('style', 'display:block;');
            } else {
                document.getElementById('billingInfo').setAttribute('style', 'display:none');
            }
        }

        function getChallanDetails(challan_id) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('getChallanDetails/') }}',
                data: {'challan_id': challan_id},
                success: function (data) {
                    var obj = JSON.parse(data);
                    document.getElementById("created_at").value = obj['created_at'];
                    document.getElementById("client_name").value = obj['client_name'];
                    document.getElementById("client_id").value = obj['client_id'];
                }
            });
        }

        <?php if(!empty($invoiceDetail->challan_id)){ ?>
        getChallanDetails(<?php echo $invoiceDetail->challan_id; ?>);
        changeDeveliry();
        <?php } ?>
    </script>
    <script>
        $(document).on('change', ".gstinnumber", function () {
            var inputvalues = $(this).val();
            var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');

            if (gstinformat.test(inputvalues)) {
                return true;
            } else {
                alert('Please Enter Valid GSTIN Number');
                $(".gstinnumber").val('');
                $(".gstinnumber").focus();
            }
        });
    </script>

@endpush
