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
                        @include('creditnote.header')
                        <!--end::Wizard Nav-->
                            <!--begin::Wizard Body-->
                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                <div class="col-xl-8">
                                    <!--begin::Wizard Form-->
                                    <form class="form" id="kt_form"
                                          action="{{($action=='INSERT')? url('credit-note'):route('credit-note.update',$creditDetail->credit_note_id) }}"
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
                                                               value="{{$creditDetail->challan_id}}">
                                                    @endif
                                                    <div class="form-group">
                                                        <label>Complain No <span class="text-danger">*</span> </label>
                                                        <select type="text" id="challan_id" name="challan_id"
                                                                class="form-control kt_select2_5"
                                                                data-live-search="true" {{ !empty($creditDetail->challan_id)?'disabled':''}}
                                                                onchange="getChallanDetails(this.value)" required
                                                                title="Select Challan Number">
                                                            <option value="">Select Complain</option>
                                                            @foreach($challanDetail as $key=>$items)
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
                                                        <?php if(!empty($creditDetail->challan_id)){ ?>
                                                        <script>document.getElementById("challan_id").value = '<?php echo $creditDetail->challan_id; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="client_id" id="client_id" class="form-control">
                                                <div class="col-xl-4">
                                                    <!--begin::Input-->
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Challan date <span class="text-danger">*</span></label>
                                                        <input type="text" id="created_at" placeholder="Read Date"
                                                               readonly
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Client Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="client_name"  name="client_name" readonly
                                                               placeholder="Read Client Name"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Remark <span class="text-danger">*</span></label>
                                                        <textarea id="remark"
                                                               placeholder="Enter a Remark" rows="3"
                                                               class="form-control" name="remark">{{ ((!empty($creditDetail->remark)) ?$creditDetail->remark :old('remark')) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--begin::Wizard Actions-->
                                            <div
                                                class="d-flex justify-content-between border-top mt-5 pt-10  card-footer">
                                                <div class="mr-2">
                                                </div>
                                                <div>
                                                    @if($action=='INSERT')
                                                        <button type="submit"
                                                                class="btn btn-success"><i class="fa fa-save"></i>
                                                            Save & Next
                                                        </button>
                                                        <a href="{{url('credit-note')}}"
                                                           class="btn btn-light-primary font-weight-bold">
                                                            Cancel
                                                        </a>
                                                    @else
                                                        <button type="submit"
                                                                class="btn btn-warning">
                                                            Update Credit Note
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
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>
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

        <?php if(!empty($creditDetail->challan_id)){ ?>
        getChallanDetails(<?php echo $creditDetail->challan_id; ?>);
        <?php } ?>
    </script>
@endpush
