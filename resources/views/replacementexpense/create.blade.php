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
                        @include('replacementexpense.header')
                        <!--end::Wizard Nav-->
                            <!--begin::Wizard Body-->
                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                <div class="col-lg-10">
                                    <!--begin::Wizard Form-->
                                    <form class="form" id="kt_form"
                                          action="{{($action=='INSERT')? url('service-expense'):route('service-expense.update',$expense->expense_id) }}"
                                          method="post">
                                    @if ($action=='UPDATE')
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ csrf_field() }}
                                    <!--begin::Wizard Step 1-->
                                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                            <div class="row">
                                                <div class="col-xl-4">
                                                    @if ($action=='UPDATE')
                                                        <input type="hidden" name="complain_id"
                                                               value="{{$expense->complain_id}}">
                                                    @endif
                                                    <div class="form-group">
                                                        <label>Complain No <span class="text-danger">*</span> </label>
                                                        <select type="text" id="complain_id" name="complain_id" {{ !empty($expense->complain_id)?'disabled':''}}
                                                                class="form-control kt_select2_5" required onchange="getComplainData(this.value)"
                                                                data-live-search="true">
                                                            <option value="">Select Complain</option>
                                                            @foreach($complainList as $item)
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
                                                        <?php if(!empty($expense->complain_id)){ ?>
                                                        <script>document.getElementById("complain_id").value = '<?php echo $expense->complain_id; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="form-group">
                                                        <label>Mechanic Name <span class="text-danger">*</span></label>
                                                        <select type="text" id="mechanic_id" name="mechanic_id"
                                                                class="form-control kt_select2_5" required
                                                                data-live-search="true">
                                                            <option value="">Select Mechanic Name</option>
                                                            @foreach($mechanicList as $item)
                                                                <option
                                                                    value="{{$item->mechanic_id  }}">{{$item->mechanic_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <?php if(!empty($expense->mechanic_id)){ ?>
                                                        <script>document.getElementById("mechanic_id").value = '<?php echo $expense->mechanic_id; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="form-group">
                                                        <label>Mechanic Name</label>
                                                        <select type="text" id="mechanic_id2"
                                                                class="form-control kt_select2_5"
                                                                name="mechanic_id2">
                                                            <option value="">Select Mechanic Name</option>
                                                            @foreach($mechanicList as $item)
                                                                <option
                                                                    value="{{$item->mechanic_id  }}">{{$item->mechanic_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <?php if(!empty($expense->mechanic_id2)){ ?>
                                                        <script>document.getElementById("mechanic_id2").value = '<?php echo $expense->mechanic_id2; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>D.A Amount </label>
                                                        <input type="text" id="ta_da_amount" placeholder="Enter Amount"
                                                               class="form-control" name="ta_da_amount"
                                                               value="{{ ((!empty($expense->ta_da_amount)) ?$expense->ta_da_amount :180)}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Traveling Date </label>
                                                        <div class="input-daterange input-group" id="kt_datepicker_5">
                                                            <input type="text" class="form-control"
                                                                   name="traveling_from" placeholder="Enter Date"
                                                                   value="{{ !empty(old('traveling_from'))?old('traveling_from'):(!empty($expense->traveling_from)?date('d-m-Y',strtotime($expense->traveling_from)):date('d-m-Y')) }}"
                                                                   autocomplete="off"/>
                                                            <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-ellipsis-h"></i>
															</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="traveling_to"
                                                                   placeholder="Enter Date"
                                                                   value="{{ !empty(old('traveling_to'))?old('traveling_to'):(!empty($expense->traveling_to)?date('d-m-Y',strtotime($expense->traveling_to)):date('d-m-Y')) }}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Days </label>
                                                        <input type="text" placeholder="Enter Days" required
                                                               class="form-control" id="traveling_days "
                                                               name="traveling_days"
                                                               value="{{ ((!empty($expense->traveling_days)) ?$expense->traveling_days :old('traveling_days'))}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Traveling State</label>
                                                        <select type="text" id="state_id" name="state_id"
                                                                class="form-control kt_select2_5" required
                                                                data-live-search="true">
                                                            <option value="">Select State</option>
                                                            @foreach($stateList as $item)
                                                                <option
                                                                    value="{{$item->state_id}}" {{(!empty($expense->state_id) AND$expense->state_id == $item->state_id) ? 'selected' : ''}} >{{$item->state_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <?php if(!empty($expense->state_id)){ ?>
                                                        <script>document.getElementById("state_id").value = '<?php echo $expense->state_id; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>City </label>
                                                        <input type="text" placeholder="Enter City Name" required
                                                               class="form-control" id="city_name"
                                                               name="city_name"
                                                               value="{{ ((!empty($expense->city_name)) ?$expense->city_name :old('city_name'))}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Traveling Reason <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control " placeholder="Traveling Reason"
                                                                id="traveling_reason" value="{{ ((!empty($expense->traveling_reason)) ?$expense->traveling_reason :old('traveling_reason'))}}"
                                                                name="traveling_reason" required>
                                                        <?php if(!empty($expense->traveling_reason)){ ?>
                                                        <script>document.getElementById("traveling_reason").value = '<?php echo $expense->traveling_reason; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Advance Amount </label>
                                                        <input type="text" placeholder="Enter Advance Amount"
                                                               class="form-control" id="advance_amount"
                                                               name="advance_amount"
                                                               value="{{ ((!empty($expense->advance_amount)) ?$expense->advance_amount :old('advance_amount'))}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Amount Taken From Dealer <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control " id="amount_taken_from_dealer"
                                                               name="amount_taken_from_dealer" required
                                                               placeholder="Enter Amount"
                                                               value="{{ ((!empty($expense->amount_taken_from_dealer)) ?$expense->amount_taken_from_dealer :old('amount_taken_from_dealer'))}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Party Name </label>
                                                        <input type="text" placeholder="Enter Party Name"
                                                               class="form-control" id="party_name"
                                                               name="party_name"
                                                               value="{{ ((!empty($expense->party_name)) ?$expense->party_name :old('party_name'))}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Wizard Actions-->
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
                                                        <i class="fas fa-save"></i> Save Expense
                                                    </button>
                                                    <a href="{{url('service-expense')}}"
                                                       class="btn btn-light-primary font-weight-bold">
                                                        Cancel
                                                    </a>
                                                @else
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fas fa-save"></i> Update Expense
                                                    </button>
                                                @endif

                                            </div>
                                        </div>
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
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>
        $(document).ready(function () {
            $('#generate_drive_control_report').click(function () {
                $('#drive_control_report_form').submit();
            });
            $('#k_timepicker_2, #k_timepicker_2_modal').timepicker();
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
            // range picker
            $('#kt_datepicker_5').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                templates: arrows
            });

        });

        function getComplainData(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-complain-data') }}',
                data: {
                    'complain_id': id,
                },
                success: function (data) {
                    var obj = JSON.parse(data)
                    document.getElementById("traveling_reason").value = obj['traveling_reason'];
                    document.getElementById("party_name").value = obj['party_name'];
                    document.getElementById("city_name").value = obj['city_name'];
                    document.getElementById("state_id").value = obj['state_id'];
                }
            });
        }
    </script>
@endpush
