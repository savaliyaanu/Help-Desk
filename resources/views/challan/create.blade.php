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
                        @include('challan.header')
                        <!--end::Wizard Nav-->
                            <!--begin::Wizard Body-->
                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                <div class="col-xl-8">
                                    <!--begin::Wizard Form-->
                                    <form class="form" id="kt_form"
                                          action="{{ ($action=='INSERT')? route('challan.store'):route('challan.update',$challan->challan_id) }}"
                                          method="post">
                                    @if ($action=='UPDATE')
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ csrf_field() }}
                                    <!--begin::Wizard Step 1-->
                                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                            <!--begin::Input-->
                                            <div class="form-group row">
                                                @if ($action=='UPDATE')
                                                    <input type="hidden" name="billty_id"
                                                           value="{{$challan->billty_id}}">
                                                @endif
                                                <label>Complain List *</label>
                                                <select type="text"
                                                        class="form-control kt_select2_5 {{ $errors->has('billty_id') ? ' is-invalid' : '' }}"
                                                        name="billty_id" data-live-search="true" required
                                                        {{ !empty($challan->billty_id)?'disabled':''}}
                                                        onchange="billtyDetails(this.value)">
                                                    <option value="">Select Complain</option>
                                                    @foreach ($billty as $items=>$row)
                                                        @if($row->branch_id == 1)
                                                            <?php  $complains_no = 'PF-TKT/' . $row->fyear . '/' . $row->complain_no;?>
                                                        @elseif($row->branch_id == 3)
                                                            <?php $complains_no = 'TE-TKT/' . $row->fyear . '/' . $row->complain_no;?>
                                                        @elseif($row->branch_id == 4)
                                                            <?php  $complains_no = 'TP-TKT/' . $row->fyear . '/' . $row->complain_no;?>
                                                        @endif
                                                        <option
                                                            value="{{$row->billty_id}}"{{ (isset($row->billty_id) && $row->billty_id==$row->billty_id?'selected':'')}}>{{$complains_no.' - '.($row->client_name).' - '.($row->billty_no).'(Billty No)'}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('billty_id'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('billty_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group row jumbotron">
                                                <label class="col-md-2 col-form-label">Client Name*</label>
                                                <input type="hidden" name="client_id" id="client_id">
                                                <input type="hidden" name="client_name"  >
                                                <label class="col-md-4 col-form-label" id="client_name"></label>
                                                <label class="col-md-2 col-form-label">Transport Name*</label>
                                                <label class="col-md-4 col-form-label" id="transport_name"></label>
                                                <label class="col-md-2 col-form-label">Transport Amt By*</label>
                                                <label class="col-md-4 col-form-label" id="freight_rs_by"></label>
                                                <label class="col-md-2 col-form-label">Transport Rs*</label>
                                                <label class="col-md-4 col-form-label" id="freight_rs"></label>
                                                <label class="col-md-2 col-form-label">Lr No*</label>
                                                <label class="col-md-4 col-form-label" id="lr_no"></label>
                                                <label class="col-md-2 col-form-label">Lr Date*</label>
                                                <label class="col-md-4 col-form-label" id="lr_date"></label>
                                                <label class="col-md-2 col-form-label">Remark*</label>
                                                <label class="col-md-4 col-form-label" id="remark"></label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-3 col-form-label">Change Billing Address*</label>
                                                <div class="col-3">
                                                <span class="switch switch-outline switch-icon switch-danger">
                                                    <label>
                                                        <input type="checkbox" id="change_billing"
                                                               class="{{ $errors->has('change_bill_address') ? ' is-invalid' : '' }}"
                                                               name="change_bill_address" id="change_bill_address"
                                                               onclick="changeBilling()"
                                                                {{ ((isset($challan->change_bill_address) && $challan->change_bill_address=='Y') ?'checked':'') }}>
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
                                                    <label>Billing Name :</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           name="billing_name" data-live-search="true"
                                                           placeholder="Enter Bill Name"
                                                           value="{{ ((!empty($challan->billing_name)) ?$challan->billing_name :old('billing_name'))}}"/>

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
                                                            <label>Address1 *</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="address1" placeholder="Enter Address"
                                                                   value="{{ ((!empty($challan->address1)) ?$challan->address1 :old('address1'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Address2 *</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="address2" placeholder="Enter Address"
                                                                   value="{{ ((!empty($challan->address2)) ?$challan->address2 :old('address2'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Address3 *</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="address3" placeholder="Enter Address"
                                                                   value="{{ ((!empty($challan->address3)) ?$challan->address3 :old('address3'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>City *</label>
                                                            <select type="text" style="width: 100%;"
                                                                    class="form-control city-select2 city_id"
                                                                    name="city_id" id="city_id">
                                                                <option value="">Select City</option>
                                                                <?php
                                                                if(isset($challan)){ ?>
                                                                <?php foreach ($city_master as $row){ ?>
                                                                <option
                                                                    value="<?php echo $row['city_id']; ?>" <?php echo (!empty($challan->city_id) AND $challan->city_id == $row['city_id']) ? 'selected' : '';?>><?php echo $row['city_name']; ?></option>
                                                                <?php }} ?>
                                                            </select>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>PinCode *</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="pincode" placeholder="Enter PinCode"
                                                                   value="{{ ((!empty($challan->pincode)) ?$challan->pincode :old('pincode'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>GSTIN *</label>
                                                            <input type="text"
                                                                   class="form-control gstinnumber"
                                                                   name="gst_no" placeholder="Enter GST NO"
                                                                   value="{{ ((!empty($challan->gst_no)) ?$challan->gst_no :old('gst_no'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Contact Person *</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="contact_person" placeholder="Enter Name"
                                                                   value="{{ ((!empty($challan->contact_person)) ?$challan->contact_person :old('contact_person'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Phone No. *</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="phone" placeholder="Enter Number"
                                                                   value="{{ ((!empty($challan->phone)) ?$challan->phone :old('phone'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Mobile No. *</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="mobile" placeholder="Enter Mobile Number"
                                                                   value="{{ ((!empty($challan->mobile)) ?$challan->mobile :old('mobile'))}}"/>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Wizard Step 5-->
                                        <!--begin::Wizard Actions-->
                                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                            <div class="mr-2">
                                                {{--<button type="button"--}}
                                                {{--class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"--}}
                                                {{--data-wizard-type="action-prev">Previous--}}
                                                {{--</button>--}}
                                            </div>
                                            <div>
                                                @if($action=='INSERT')
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save"></i>Create Challan
                                                    </button>
                                                    <a href="{{route('challan.index')}}"
                                                       class="btn btn-light-primary font-weight-bold">
                                                        Cancel
                                                    </a>
                                                @else
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fas fa-save"></i> Update Challan
                                                    </button>
                                                @endif
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
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/custom/wizard/wizard-1.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>
        function billtyDetails(id) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('getBilltyDetails') }}',
                data: {'billty_id': id},
                success: function (data) {
                    var obj = JSON.parse(data);
                    $("#client_name").html(obj['client_name']);
                    // $("#client_id").html(obj['client_id']);
                    $("#transport_name").html(obj['transport_name']);
                    $("#freight_rs").html(obj['freight_rs']);
                    $("#freight_rs_by").html(obj['freight_rs_by']);
                    $("#lr_no").html(obj['lr_no']);
                    $("#lr_date").html(obj['lr_date']);
                    $("#remark").html(obj['remark']);
                    document.getElementById("client_name").value = obj['client_name'];
                    document.getElementById("client_id").value = obj['client_id'];
                }
            });
        }

        function changeBilling() {
            if (document.getElementById('change_billing').checked) {
                document.getElementById('billingInfo').setAttribute('style', 'display:block;');
            } else {
                document.getElementById('billingInfo').setAttribute('style', 'display:none');
            }
        }

        <?php if(!empty($challan->billty_id)){ ?>
        billtyDetails(<?php echo $challan->billty_id; ?>);
        changeBilling();
        <?php } ?>

        $(".city-select2").select2({
            placeholder: "Select a City",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-city') }}",
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
    </script>
    <script>
        $(document).on('change',".gstinnumber", function(){
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
