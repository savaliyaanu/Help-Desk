@extends('layouts.app')
@section('content')
    <script>
        function getproduct(value, id) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-products') }}',
                method: 'post',
                data: {
                    category_id: value
                }
            }).done(function (data) {
                $("#product_id_" + id).empty();
                $("#product_id_" + id).append(data);
                $("#product_id_" + id).trigger("chosen:updated");

            });
        }
    </script>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Subheader -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Complain </h3>
                </div>
            </div>
        </div>
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon kt-hidden">
											<i class="la la-gear"></i>
										</span>
                        <h3 class="kt-portlet__head-title">
                            Complain
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                {{--                                        @if ($errors->any())--}}
                {{--                                            <div class="alert alert-danger">--}}
                {{--                                                <ul>--}}
                {{--                                                    @foreach ($errors->all() as $error)--}}
                {{--                                                        <li>{{ $error }}</li>--}}
                {{--                                                    @endforeach--}}
                {{--                                                </ul>--}}
                {{--                                            </div>--}}
                {{--                                        @endif--}}
                <form class="kt-form kt-form--label-right" id="kt_form_2"
                      method="post"
                      action="{{($action=='INSERT')?route('complain-detail.store'):route('complain-detail.update', $complain[0]['complain_id']) }}">
                    @if ($action=='UPDATE')
                        {{ method_field('PUT') }}
                    @endif
                    {{ csrf_field() }}
                    <div class="kt-portlet__body">
                        <div class="kt-form__section kt-form__section--first">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Complain Type</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <select
                                            class="form-control kt-select2 kt_select2_5 medium_id {{ $errors->has('medium_id') ? ' is-invalid' : '' }}"
                                            required title="Select Complain Type"
                                            name="complain_type" id="complain_type">
                                        <option value="Product Complain">Product Complain</option>
                                        <option value="Account Complain">Account Complain</option>
                                    </select>
                                    <?php if(!empty($complain[0]['complain_type'])){ ?>
                                    <script>document.getElementById("complain_type").value = '<?php echo $complain[0]['complain_type']; ?>';</script>
                                    <?php } ?>

                                    @if ($errors->has('medium_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('medium_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Medium</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <select
                                            class="form-control kt-select2 kt_select2_5 medium_id {{ $errors->has('medium_id') ? ' is-invalid' : '' }}"
                                            required title="Select Medium Name"
                                            name="medium_id" id="medium_id">
                                        <option value="">Select Medium</option>
                                        @foreach ($medium as $row)
                                            <option
                                                    value="{{ $row->medium_id }}">{{ $row->medium_name }}</option>
                                        @endforeach
                                    </select>
                                    <?php if(!empty($complain[0]['medium_id'])){ ?>
                                    <script>document.getElementById("medium_id").value = '<?php echo $complain[0]['medium_id']; ?>';</script>
                                    <?php } ?>

                                    @if ($errors->has('medium_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('medium_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleTextarea" class="col-form-label col-lg-3 col-sm-12">Mobile</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <input class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                           required title="Enter Mobile Number" number="true"
                                           id="mobile" name="mobile" placeholder="Enter Mobile"
                                           value="{{ ((!empty($complain[0]['mobile'])) ?$complain[0]['mobile'] :old('mobile')) }}">
                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Client Name</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <select id="client_id"
                                            class="form-control customer-select2 kt_select2_5 client_id  {{ $errors->has('client_id') ? ' is-invalid' : '' }}"
                                            name="client_id" onchange="getClientDetails(this.value)" required data-live-search="true"
                                            title="Select Client Name">
                                        <option value="">Select Client Name</option>
                                        <?php
                                        if(isset($complain)){ ?>
                                    @foreach ($clientMaster as $row)
                                            <option
                                                value="{{ $row->client_id }}">{{ $row->client_name }}</option>
                                        @endforeach
                                        <?php } ?>
                                    </select>
                                    <?php if(!empty($complain[0]['client_id'])){ ?>
                                    <script>document.getElementById("client_id").value = '<?php echo $complain[0]['client_id']; ?>';</script>
                                    <?php } ?>
                                    @if ($errors->has('client_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('client_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row clientHide" style="display: none">
                                <label class="col-form-label col-lg-3 col-sm-12">Client Name</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <input class="form-control {{ $errors->has('client_name') ? ' is-invalid' : '' }}"
                                           required
                                           id="client_name" name="client_name" placeholder="Enter Client"
                                           value="{{ ((!empty($complain[0]['client_name'])) ?$complain[0]['client_name'] :old('client_name')) }}">
                                    @if ($errors->has('client_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('client_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="complain_id"
                                   value="{{ ((!empty($complain[0]['complain_id'])) ?$complain[0]['complain_id'] :old('complain_id')) }}">
                            <div class="form-group row">
                                <label for="exampleTextarea" class="col-form-label col-lg-3 col-sm-12">Address</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <textarea class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                              required title="Enter Address"
                                              id="address" name="address" rows="3"
                                              placeholder="Enter Address">{{ ((!empty($complain[0]['address'])) ?$complain[0]['address'] :old('address')) }}</textarea>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleTextarea" class="col-form-label col-lg-3 col-sm-12">City</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <select class="form-control city-select2 kt_select2_5 {{ $errors->has('city_id') ? ' is-invalid' : '' }}"
                                            required data-live-search="true"
                                            id="city_id" name="city_id" title="Select City Name"
                                            onchange="getCityDetails(this.value)">
                                        <option value="">Select City</option>
                                        <?php
                                        if(isset($complain)){ ?>
                                        @foreach ($cityMaster as $row)
                                            <option
                                                value="{{ $row->city_id }}">{{ $row->city_name }}</option>
                                        @endforeach
                                        <?php }?>
                                    </select>
                                    @if ($errors->has('city_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city_id') }}</strong>
                                    </span>
                                    @endif
                                    <?php if(!empty($complain[0]['city_id'])){ ?>
                                    <script>document.getElementById("city_id").value = '<?php echo $complain[0]['city_id']; ?>';</script>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleTextarea" class="col-form-label col-lg-3 col-sm-12">District</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <input class="form-control {{ $errors->has('district') ? ' is-invalid' : '' }}"
                                           title="Enter District" readonly
                                           id="district" name="district" placeholder="Enter District"
                                           value="{{ ((!empty($complain[0]['district'])) ?$complain[0]['district'] :old('district')) }}">
                                    @if ($errors->has('district'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('district') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleTextarea" class="col-form-label col-lg-3 col-sm-12">State</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <input class="form-control {{ $errors->has('state') ? ' is-invalid' : '' }}"
                                           title="Enter State" readonly
                                           id="state" name="state" placeholder="Enter State"
                                           value="{{ ((!empty($complain[0]['state'])) ?$complain[0]['state'] :old('state')) }}">
                                    @if ($errors->has('state'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Seller Name</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <select id="seller_id"
                                            class="form-control customer-select2 kt_select2_5 client_id  {{ $errors->has('client_id') ? ' is-invalid' : '' }}"
                                            name="seller_id" data-live-search="true"
                                            title="Select Client Name">
                                        <option value="">Select Seller Name</option>
                                        <?php
                                        if(isset($complain)){ ?>
                                        @foreach ($clientMaster as $row)
                                            <option
                                                    value="{{ $row->client_id }}">{{ $row->client_name }}</option>
                                        @endforeach
                                        <?php } ?>
                                    </select>
                                    <?php if(!empty($complain[0]['client_id'])){ ?>
                                    <script>document.getElementById("client_id").value = '<?php echo $complain[0]['client_id']; ?>';</script>
                                    <?php } ?>
                                    @if ($errors->has('client_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('client_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleTextarea" class="col-form-label col-lg-3 col-sm-12">Seller Address</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <textarea class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                              required title="Enter Address"
                                              id="seller_address" name="seller_address" rows="3"
                                              placeholder="Enter Address">{{ ((!empty($complain[0]['address'])) ?$complain[0]['address'] :old('address')) }}</textarea>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="hidden" id="current_table_row" required
                                       class="{{ $errors->has('$complain_detail') ? ' is-invalid' : '' }}"
                                       value="<?php echo empty($complain_detail) ? 2 : (count($complain_detail) + 1); ?>">
                                @if ($errors->has('$complain_detail'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('$complain_detail') }}</strong>
                                    </span>
                                @endif
                                <table id="ConInvoice" class="table table-striped table-bordered table-vcenter">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Model No</th>
                                        <th class="text-center" width="20%">Serial No</th>
                                        <th class="text-center" width="20%">Complain</th>
                                        <th class="text-center" width="20%">Application</th>
                                        <th class="text-center" width="5%">
                                            <button accesskey="a" class="btn btn-info btn-xs" type="button"
                                                    onclick="InsertTableRow()">
                                                <i class="fa fa-plus"></i></button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($complain_detail)) {
                                    $temp = 2;
                                    foreach ($complain_detail as $item) { ?>
                                    <tr>
                                        <input type="hidden" name="cid_id[]" value="<?php echo $item['cid_id']; ?>">
                                        <td><select class="form-control select-chosen kt_select2_5"
                                                    id="category_id_<?php echo $temp; ?>"
                                                    required title="Select Category"
                                                    onchange="getproduct(this.value,2)"
                                                    name="category_id[]">
                                                <option value="">Select</option>
                                                <?php foreach ($categoryMaster as $row){ ?>
                                                <option
                                                    value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                                                <?php } ?></select>
                                        </td>
                                        <script>
                                            document.getElementById('category_id_<?php echo $temp; ?>').value = '<?php echo $item['category_id']; ?>';
                                            getproduct('<?php echo $item['category_id']; ?>', '<?php  echo $temp; ?>');
                                        </script>
                                        <td><select class="form-control select-chosen"
                                                    id="product_id_<?php echo $temp; ?>"
                                                    required title="Select Product"
                                                    name="product_id[]">
                                                <option value="">Select</option>
                                            </select>
                                        </td>
                                        <script>
                                            document.getElementById('product_id_<?php echo $temp; ?>').value = '<?php echo $item['product_id']; ?>';
                                        </script>
                                        <td><input type="text" class="form-control" id="sr_no_<?php echo $temp; ?>"
                                                   required title="Enter Serial Number" placeholder="Enter Erial No"
                                                   name="sr_no[]" value="<?php echo $item['serial_no']; ?>"></td>
                                        <td><input type="text" class="form-control" name="complain[]" required
                                                   title="Enter Complain Detail"
                                                   id="complain_<?php echo $temp; ?>"
                                                   value="<?php echo $item['complain']; ?>"></td>
                                        <td><input type="text" class="form-control" name="application[]" required
                                                   title="Enter Appliction"
                                                   id="application_<?php echo $temp; ?>"
                                                   value="<?php echo $item['application']; ?>"></td>
                                        <td>
                                            <button class="btn btn-danger btn-xs" type="button"
                                                    onclick="DeleteTableRow(this)">
                                                <i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php $temp++;
                                    } ?>
                                    <?php } else { ?>
                                    <tr>
                                        <td><select class="form-control select-chosen" id="category_id_2" required
                                                    onchange="getproduct(this.value,2)"
                                                    name="category_id[]"><?php foreach ($categoryMaster as $row){ ?>
                                                <option
                                                    value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                                                <?php } ?></select>
                                        </td>
                                        <td><select class="form-control select-chosen" id="product_id_2" required
                                                    name="product_id[]"></select>
                                        </td>
                                        <td><input type="text" class="form-control" id="sr_no_2" required
                                                   name="sr_no[]"></td>
                                        <td><input type="text" class="form-control" name="complain[]" id="complain_2"
                                                   value=""></td>
                                        <td><input type="text" class="form-control" name="application[]"
                                                   id="application_2"
                                                   value=""></td>
                                        <td></td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-2">
                                    <input type="submit" value="Save" class="btn btn-primary">
                                </div>
                                <div class="col-lg-2">
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function DeleteTableRow(r) {

            var i = r.parentNode.parentNode.rowIndex;
            document.getElementById("ConInvoice").deleteRow(i);
        }

        function InsertTableRow() {

            var current_table_row = parseInt($('#current_table_row').val());
            current_table_row = current_table_row + 1;
            var table = document.getElementById("ConInvoice");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            cell1.innerHTML = '<select class="form-control select-chosen" onchange="getproduct(this.value,' + current_table_row + ')" id="category_id_' + current_table_row + '" required name="category_id[]"><?php foreach ($categoryMaster as $row){ ?> <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option> <?php } ?></select>';
            cell2.innerHTML = '<select class="form-control select-chosen" id="product_id_' + current_table_row + '" required name="product_id[]"></select>';
            cell3.innerHTML = '<input type="text" class="form-control" id="sr_no_' + current_table_row + '" required name="sr_no[]">';
            cell4.innerHTML = '<input type="text" class="form-control" name="complain[]" id="complain_' + current_table_row + '" value=""></td>';
            cell5.innerHTML = '<input type="text" class="form-control" name="application[]" id="application_' + current_table_row + '" value=""></td>';
            cell6.innerHTML = '<button class="btn btn-danger btn-xs" type="button" onclick="DeleteTableRow(this)"><i class="fa fa-trash"></i></button>';
            $('#current_table_row').val(current_table_row);
        }

        function getClientDetails(client_id) {

            if (client_id == 247) {
                $(".clientHide").show();
            } else {
                $(".clientHide").hide();
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('getClientDetails') }}',
                data: {'client_id': client_id},
                success: function (data) {
                    var obj = JSON.parse(data);
                    document.getElementById("address").value = obj['address1'] + ' ' + obj['address2'] + ' ' + obj['address3'];
                    document.getElementById("client_name").value = obj['client_name'];
                    document.getElementById("mobile").value = obj['mobile'];
                    document.getElementById("city_id").value = obj['city_id'];
                    document.getElementById("district").value = obj['district_id'];
                    document.getElementById("state").value = obj['state_id'];
                }
            });
        }

        <?php if(!empty($complain[0]['client_id'])){ ?>
        if ('<?php echo $complain[0]['client_id'] ?>' == 247) {
            $(".clientHide").show();
        } else {
            $(".clientHide").hide();
        }
        <?php } ?>

        $(document).ready(function () {
            $(document).on('change', "select.category", function () {
                var categoryName = $(this).attr('name');
                var productName = categoryName.replace('category_id', 'product_id');
                var categoryId = $(this).val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url('get-products') }}',
                    data: {'category_id': categoryId},
                    success: function (data) {
                        $("select[name='" + productName + "']").html(data).selectpicker('refresh');
                        $('.kt-selectpicker').selectpicker();
                    }
                });

            });

        });

        function getCityDetails(city_id) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('getCityDetails') }}',
                data: {'city_id': city_id},
                success: function (data) {
                    var obj = JSON.parse(data);
                    document.getElementById("district").value = obj['district_id'];
                    document.getElementById("state").value = obj['state'];
                }
            });
        }

        $(".customer-select2").select2({
            placeholder: "Select a Client",
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
@endsection
