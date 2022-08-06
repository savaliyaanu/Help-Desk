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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Advance Replacement</h2>
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
                <!--begin::Card-->
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <!--begin::Form-->
                            <form class="form" id="kt_form_1" method="post"
                                  action="{{($action=='INSERT')? url('advance-replacement'):route('advance-replacement.update',$companyItem->replacement_out_id)}}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    @if ($action=='UPDATE')
                                        <input type="hidden" name="complain_id"
                                               value="{{$companyItem->complain_id}}">
                                    @endif
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Complain List
                                            *</label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="complain_id"
                                                        {{ !empty($companyItem->complain_id)?'disabled':''}}
                                                        class="form-control kt_select2_5" name="complain_id">
                                                    <option value="">Select Complain-</option>
                                                    @foreach($complain as $key=>$item)
                                                        @if($item->branch_id == 1)
                                                            <?php  $complains_no = 'PF-TKT/' . $item->fyear . '/' . $item->complain_no;?>
                                                        @elseif($item->branch_id == 3)
                                                            <?php $complains_no = 'TE-TKT/' . $item->fyear . '/' . $item->complain_no;?>
                                                        @elseif($item->branch_id == 4)
                                                            <?php  $complains_no = 'TP-TKT/' . $item->fyear . '/' . $item->complain_no;?>
                                                        @endif
                                                        <option
                                                            value="{{$item->complain_id  }}">{{$complains_no.' - '.$item->client_name}}</option>
                                                    @endforeach
                                                </select>
                                                <?php if(!empty($companyItem->complain_id)){ ?>
                                                <script>document.getElementById("complain_id").value = '<?php echo $companyItem->complain_id; ?>';</script>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <label class="col-form-label text-right col-lg-2 ">Financial Year</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <select type="text" class="form-control kt_select2_5"
                                                        name="financial_id"
                                                        id="financial_id">
                                                    <option value="">Select Financial Year</option>
                                                    @foreach($financial_year as $key=>$value)
                                                        <option
                                                            value="{{$value->financial_id}}">{{ $value->fyear }}</option>
                                                    @endforeach
                                                </select>
                                                <?php if(!empty($companyItem->financial_year)){ ?>
                                                <script>document.getElementById("financial_id").value = '<?php echo $companyItem->financial_year; ?>';</script>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Company Name
                                            *</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <select style="width: 100%" id="company_name"
                                                        onchange="getOrderNo(this.value)"
                                                        class="form-control kt_select2_5" name="company_name">
                                                    <option value="">Select Company Name</option>
                                                    <option value="PFMA">PFMA</option>
                                                    <option value="TEPL">TEPL</option>
                                                    <option value="TPPL">TPPL</option>
                                                </select>
                                                <?php if(!empty($companyItem->company_name)){ ?>
                                                <script>document.getElementById("company_name").value = '<?php echo $companyItem->company_name; ?>';</script>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <label class="col-form-label text-right col-lg-2 ">Order No*</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <select type="text" class="form-control kt_select2_5"
                                                        name="order_auto_id" onchange="getItems(this.value)"
                                                        id="order_auto_id">
                                                    <option value="">Select Order No</option>

                                                </select>
                                                <?php if(!empty($companyItem->order_id)){ ?>
                                                <script>document.getElementById("order_auto_id").value = '<?php echo $companyItem->order_id; ?>';</script>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row jumbotron" id="products">
                                        <table>

                                        </table>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Billty No. *</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control"
                                                       name="billty_no" placeholder="Enter Billty No" id=""
                                                       value="{{ ((!empty($companyItem->billty_no)) ?$companyItem->billty_no :old('billty_no')) }}">
                                            </div>
                                        </div>
                                        <label class="col-form-label text-right col-lg-2 ">Transport Name*</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <select id="transport_id"
                                                        class="form-control kt_select2_5" name="transport_id">
                                                    <option value="">Select Transport Name</option>
                                                    @foreach($transport_list as $key=>$value)
                                                        <option
                                                            value="{{$value->transport_id}}">{{$value->transport_name}}</option>
                                                    @endforeach
                                                </select>
                                                <?php if(!empty($companyItem->transport_id)){ ?>
                                                <script>document.getElementById("transport_id").value = '<?php echo $companyItem->transport_id; ?>';</script>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Mobile No. *</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control"
                                                       name="mobile_no" placeholder="Enter Phone Number" id="mobile_no"
                                                       value="{{ ((!empty($companyItem->mobile_no)) ?$companyItem->mobile_no :old('mobile_no')) }}">
                                            </div>
                                        </div>
                                        <label class="col-form-label text-right col-lg-2 ">LR. No. *</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control"
                                                       name="lr_no" placeholder="Enter LR. No" id=""
                                                       value="{{ ((!empty($companyItem->lr_no)) ?$companyItem->lr_no :old('lr_no')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-form-label text-right col-lg-2 ">Lory No. *</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control"
                                                       name="lory_no" placeholder="Enter Lory No" id=""
                                                       value="{{ ((!empty($companyItem->lory_no)) ?$companyItem->lory_no :old('lory_no')) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10 card-footer">
                                        <div class="mr-2">

                                        </div>
                                        <div>
                                            @if($action=='INSERT')
                                                <button type="submit"
                                                        class="btn btn-success">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                                <a href="{{url('advance-replacement')}}"
                                                   class="btn btn-light-primary font-weight-bold">
                                                    Cancel
                                                </a>
                                            @elseif($action == 'UPDATE')
                                                <button type="submit"
                                                        class="btn btn-warning">
                                                    <i class="fas fa-save"></i> Update
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
    <script>
        function getOrderNo(company_name) {
            var financial_id = $("#financial_id").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-order-no/') }}',
                data: {'company_name': company_name, 'financial_id': financial_id},
                success: function (data) {
                    $("#order_auto_id").html(data);
                    <?php if(!empty($companyItem->order_id)){ ?>
                    document.getElementById("order_auto_id").value = '<?php echo $companyItem->order_id; ?>';
                    getItems(<?php echo $companyItem->order_id; ?>);
                    <?php } ?>
                }
            });
        }

        function getItems(order_id) {
            var financial_id = $("#financial_id").val();
            var company_name = $("#company_name").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-order-items/') }}',
                data: {'order_id': order_id, 'company_name': company_name, 'financial_id': financial_id},
                success: function (data) {
                    $("#products").html(data);

                }
            });
        }

        <?php if(!empty($companyItem->company_name)){ ?>
        getOrderNo('<?php echo $companyItem->company_name; ?>');
        <?php } ?>
    </script>
@endpush
