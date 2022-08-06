@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Billty</h2>
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
                                  action="{{($action=='INSERT')? route('billty.store'):route('billty.update',$billty->billty_id) }}">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Complain List
                                            <span class="text-danger">*</span> </label>
                                        <div class="col-lg-5">
                                            @if ($action=='UPDATE')
                                                <input type="hidden" name="complain_id"
                                                       value="{{$billty->complain_id}}">
                                            @endif
                                            <select type="text"
                                                    class="form-control kt_select2_5 multiple-complain {{ $errors->has('complain_id') ? ' is-invalid' : '' }}"
                                                    id="complain_id"
                                                    name="complain_id[]" required multiple
                                                    style="" {{ !empty($billty->complain_id)?'disabled':''}}>
                                                <option value="">Select</option>
                                                @foreach ($complainList as $key=>$row)
                                                    @if($row->branch_id == 1)
                                                        <?php  $complains_no = 'PF-TKT/' . $row->fyear . '/' . $row->complain_no;?>
                                                    @elseif($row->branch_id == 3)
                                                        <?php $complains_no = 'TE-TKT/' . $row->fyear . '/' . $row->complain_no;?>
                                                    @elseif($row->branch_id == 4)
                                                        <?php  $complains_no = 'TP-TKT/' . $row->fyear . '/' . $row->complain_no;?>
                                                    @endif
                                                    <option
                                                        value="{{$row->complain_id}}">{{$complains_no.' - '.$row->client_name}}</option>
                                                @endforeach
                                            </select>
                                            <?php if(!empty($billty->complain_id)){ ?>
                                            <script>document.getElementById("complain_id").value = '{{ $billty->complain_id }}';</script>
                                            <?php } ?>
                                            @if ($errors->has('complain_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('complain_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-4">
                                            <select type="text" data-size="7" data-live-search="true"
                                                    class="form-control selectpicker {{ $errors->has('challan_type') ? ' is-invalid' : '' }}"
                                                    name="challan_type"
                                                    id="challan_type"
                                                    onchange="showOther(this.value)">
                                                <option value="">Select Type</option>
                                                <option
                                                    value="Billty" {{ !empty($billty->challan_type) && $billty->challan_type=='Billty' ? 'selected':''}} {{ ((old('challan_type')=='Billty')?'selected': '') }}>
                                                    Billty
                                                </option>
                                                <option
                                                    value="Letter Pad" {{!empty($billty->challan_type) && $billty->challan_type=='Letter Pad' ? 'selected':''}} {{ ((old('challan_type')=='Letter Pad')?'selected': '')}}>
                                                    Letter Pad
                                                </option>
                                                <option
                                                    value="Challan" {{!empty($billty->challan_type) && $billty->challan_type=='Challan' ? 'selected':''}} {{ ((old('challan_type')=='Challan')?'selected': '')}}>
                                                    Challan
                                                </option>
                                                <option
                                                    value="Letter" {{ !empty($billty->challan_type) && $billty->challan_type=='Letter' ? 'selected':''}} {{ ((old('challan_type')=='Letter')?'selected': '') }}>
                                                    Letter
                                                </option>
                                                <option
                                                    value="Other" {{ !empty($billty->challan_type) && $billty->challan_type=='Other' ? 'selected':''}} {{ ((old('challan_type')=='Other')?'selected': '') }}>
                                                    Other
                                                </option>
                                            </select>
                                            @if ($errors->has('challan_type'))
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('challan_type') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row" id="otherhide" style="display: none">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Other
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="other" id="other" required
                                                       placeholder="Enter value"
                                                       value="{{ ((!empty($billty->other)) ?$billty->other :old('other'))}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Good Receive Through
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-md-9 col-sm-12 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="transport_id" data-size="7"
                                                        data-live-search="true"
                                                        class="form-control transport-select2 transport_id selectpicker {{ $errors->has('transport_id') ? ' is-invalid' : '' }}"
                                                        name="transport_id" required
                                                        data-live-search="true">
                                                    <option value="">Select Transport Name</option>
                                                    @foreach($transportReceive as $key=>$item)
                                                        <option
                                                            value="{{ $item['transport_id'] }}">{{ $item['transport_name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <?php if(!empty($billty->transport_id)){ ?>
                                                <script>document.getElementById("transport_id").value = '{{ $billty->transport_id }}';</script>
                                                <?php } ?>
                                                @if ($errors->has('transport_id'))
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('transport_id') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Transport Charges By
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <select style="width: 100%" id="freight_rs_by"
                                                        class="form-control kt_select2_5 {{ $errors->has('freight_rs_by') ? ' is-invalid' : '' }}"
                                                        name="freight_rs_by" required
                                                        data-live-search="true"
                                                        title="Select Transport Charges By">
                                                    <option value="">Select</option>
                                                    <option
                                                        value="Company"{{ !empty($billty->freight_rs_by) && $billty->freight_rs_by=='Company' ? 'selected':''}} {{ ((old('freight_rs_by')=='Company')?'selected': '') }}>
                                                        COMPANY
                                                    </option>
                                                    <option
                                                        value="party"{{ !empty($billty->freight_rs_by) && $billty->freight_rs_by=='party' ? 'selected':''}} {{ ((old('freight_rs_by')=='party')?'selected': '') }}>
                                                        PARTY
                                                    </option>
                                                </select>
                                                <?php if(!empty($billty->freight_rs_by)){ ?>
                                                <script>document.getElementById("freight_rs_by").value = '{{ $billty->freight_rs_by }}';</script>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Transport Amount.
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span
                                                        class="input-group-text">
                                                        <i class="la la-sort-numeric-asc"></i>
                                                    </span>
                                                </div>
                                                <input type="text"
                                                       class="form-control {{ $errors->has('freight_rs') ? ' is-invalid' : '' }}"
                                                       name="freight_rs"
                                                       placeholder="Enter Freight Rupee" required
                                                       value="{{ ((!empty($billty->freight_rs)) ?$billty->freight_rs :old('freight_rs')) }}"/>
                                                @if ($errors->has('freight_rs'))
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('freight_rs') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">LR.NO. <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control {{ $errors->has('lr_no') ? ' is-invalid' : '' }}"
                                                       name="lr_no"
                                                       placeholder="Enter LR.No." required
                                                       value="{{ ((!empty($billty->lr_no)) ?$billty->lr_no :old('lr_no')) }}"/>
                                                @if ($errors->has('lr_no'))
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lr_no') }}</strong>
                                    </span>
                                                @endif
                                                <div class="input-group-prepend">
                                                    <span
                                                        class="input-group-text">
                                                        <i class="la la-sort-numeric-asc"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">LR. Date <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <div class="input-group date">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar"></i>
                                                    </span>
                                                </div>
                                                <input type="text"
                                                       class="form-control {{ $errors->has('lr_date') ? ' is-invalid' : '' }}"
                                                       name="lr_date" placeholder="Select Date" id="kt_datepicker_3"
                                                       value="{{ ((!empty($billty->lr_date)) ?$billty->lr_date :old('lr_date')) }}"/>
                                                @if ($errors->has('lr_date'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('lr_date') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Entry BY<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control  {{ $errors->has('entry_by') ? ' is-invalid' : '' }}"
                                                       name="entry_by" placeholder="Entry By" required
                                                       value="{{ ((!empty($billty->entry_by)) ?$billty->entry_by :old('entry_by')) }}"/>
                                                @if ($errors->has('entry_by'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('entry_by') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Remark <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <textarea class="form-control" name="remark" placeholder="Enter a Remark"
                                                      rows="3">{{ ((!empty($billty->remark)) ?$billty->remark :old('remark')) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                    @if($action!='UPDATE')
                                    <table class="datatable table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th></th>
                                            <th>Client Name</th>
                                            <th>Complain No</th>
                                            <th>Category Name</th>
                                            <th>Product Name</th>
                                            <th>Serial No</th>
                                            <th>Production No</th>
                                            <th>Invoice No</th>
                                            <th>Invoice Date</th>
                                            <th>Complain</th>
                                            <th>Application</th>
                                            <th>Warranty</th>

                                        </tr>
                                        </thead>
                                        <tbody id="LoanData">
                                        @if(isset($billty))
                                            @foreach($productList as $value)
                                                <tr>
                                                    <td><input type="checkbox" checked
                                                               name="multiple_complain[{{  $value->cid_id }}]">
                                                    </td>
                                                    <td><input type="text" name="client_name" readonly
                                                               autocomplete="off" id="client_name"
                                                               value="{{$value->client_name }}"
                                                               class=" form-control"></td>
                                                    <td><input type="text" name="complain_no" readonly
                                                               autocomplete="off" id="complain_no"
                                                               value="{{$value->complain_no }}"
                                                               class=" form-control"></td>
                                                    <td><input type="text" readonly autocomplete="off"
                                                               name="category_name"
                                                               id="category_name"
                                                               value="{{$value->category_name }}" class=" form-control">
                                                    </td>
                                                    <td><input type="text" readonly autocomplete="off"
                                                               name="category_name"
                                                               id="category_name"
                                                               value="{{$value->category_name }}" class=" form-control">
                                                    </td>
                                                    <td><input type="text" readonly autocomplete="off"
                                                               name="product_name"
                                                               id="product_name"
                                                               value="{{$value->product_name }}" class=" form-control">
                                                    </td>
                                                    <td><input type="text" readonly autocomplete="off" name="serial_no"
                                                               id="serial_no"
                                                               value="{{$value->serial_no }}" class=" form-control">
                                                    </td>
                                                    <td><input type="text" readonly autocomplete="off"
                                                               name="production_no"
                                                               id="production_no"
                                                               value="{{$value->production_no }}" class=" form-control">
                                                    </td>
                                                    <td><input type="text" readonly autocomplete="off" name="invoice_no"
                                                               id="invoice_no"
                                                               value="{{$value->invoice_no }}" class=" form-control">
                                                    </td>
                                                    <td><input type="text" readonly autocomplete="off"
                                                               name="invoice_date"
                                                               id="invoice_date"
                                                               value="{{$value->invoice_date }}" class=" form-control">
                                                    </td>
                                                    <td><input type="text" readonly autocomplete="off" name="complain"
                                                               id="complain"
                                                               value="{{$value->complain }}" class=" form-control"></td>
                                                    <td><input type="text" readonly autocomplete="off"
                                                               name="application"
                                                               id="application"
                                                               value="{{$value->application }}" class=" form-control">
                                                    </td>
                                                    <td><input type="text" readonly autocomplete="off" name="warranty"
                                                               id="warranty"
                                                               value="{{$value->warranty }}" class=" form-control">
                                                        <input type="hidden" readonly autocomplete="off" name="quantity"
                                                               id="quantity"
                                                               value="{{$value->quantity }}" class=" form-control">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                @endif
                                <div class="container">
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10  card-footer">
                                        <div class="mr-2">
                                        </div>
                                        <div>
                                            @if($action=='INSERT')
                                                <button type="submit"
                                                        class="btn btn-success">
                                                    <i class="fas fa-save"></i> Save Billty
                                                </button>
                                                <a href="{{route('billty.index')}}"
                                                   class="btn btn-light-primary font-weight-bold">
                                                    Cancel
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
    </div>
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>
        function showOther(value) {
            if (value === "Other") {
                $("#otherhide").show();
            } else {
                $("#otherhide").hide();
                $("#other").val(value);
            }
        }

        <?php if(!empty($billty->challan_type)){ ?>
        showOther('<?php echo $billty->challan_type; ?>');
        <?php } ?>


        $(".customer-select2").select2({
            placeholder: "Select a Client Name",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-client') }}",
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

        $(".transport-select2").select2({
            placeholder: "Select a Transport",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-transport') }}",
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

        function getComplainProductDetail(id) {
            var select = document.getElementById('complain_id');
            var selected = [...select.options]
                .filter(option => option.selected)
                .map(option => option.value);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-complain-product-detail') }}',
                data: {
                    'complain_id': selected,
                },
                success: function (data) {
                    $("#productsData").html(data);
                }
            });
        }

        $(document).on('change', "select.multiple-complain", function () {
            var complainID = (jQuery('select[name="complain_id[]"]').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-complain-product')}}',
                type: 'POST',
                data: {complain_id: complainID, cid_id: $(this).val()},
                success: function (data) {
                    $.each(data, function (key, value) {
                        $('#LoanData').append('<tr>' +
                            '<td><input type="checkbox" checked name="multiple_complain[' + value.cid_id + ']"></td>' +
                            '<td><input type="text" name="client_name" readonly autocomplete="off" value="' + value.client_name + '" class=" form-control"></td>' +
                            '<td><input type="text" name="complain_no" readonly autocomplete="off" value="' + value.complain_no + '" class=" form-control"></td>' +
                            '<td> <input type="text" readonly name="category_name" autocomplete="off" value="' + value.category_name + '" class=" form-control"></td>' +
                            '<td> <input type="text" name="product_name" readonly  autocomplete="off" value="' + value.product_name + '" class=" form-control"></td>' +
                            '<td> <input type="text" name="serial_no" readonly  autocomplete="off" value="' + value.serial_no + '" class=" form-control"></td>' +
                            '<td> <input type="text" name="production_no" readonly  autocomplete="off" value="' + value.production_no + '" class=" form-control"></td>' +
                            '<td> <input type="text" name="invoice_no" readonly  autocomplete="off" value="' + value.invoice_no + '" class=" form-control"></td>' +
                            '<td> <input type="text" name="invoice_date" readonly  autocomplete="off" value="' + value.invoice_date + '" class=" form-control"></td>' +
                            '<td> <input type="text" name="complain" readonly  autocomplete="off" value="' + value.complain + '" class=" form-control"></td>' +
                            '<td> <input type="text" name="application" readonly  autocomplete="off" value="' + value.application + '" class=" form-control"></td>' +
                            '<td> <input type="text" name="warranty" readonly  autocomplete="off" value="' + value.warranty + '" class=" form-control"></td>' +
                            '</tr>');
                    });
                }
            });
        });
    </script>
@endpush
