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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Service Station</h2>
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
                                  action="{{($action=='INSERT')? route('service-station.store'):route('service-station.update', $serviceStation->service_id) }}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Company List
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" class="form-control kt_select2_5 "
                                                        id="company_id" name="company_id" required
                                                        title="Please Select Company"
                                                        onchange="getBranchDetails(this.value)">
                                                    <option value="">Select Company</option>
                                                    @foreach($companyDetail as $key=>$items)
                                                        <option
                                                            value="{{$items->company_id}}">{{$items->company_name}}</option>
                                                    @endforeach
                                                </select>
                                                <?php if(!empty($serviceStation->company_id)){ ?>
                                                <script>document.getElementById("company_id").value = '{{ $serviceStation->company_id }}';</script>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <label class="col-form-label text-right col-lg-2 ">Branch Name
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <select style="width: 100%" class="form-control kt_select2_5"
                                                        name="branch_id" id="branch_id">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Service Station Name
                                            <span class="text-danger">*</span> </label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input style="width: 100%" id="service_station_name"
                                                       placeholder="Enter Address"
                                                       class="form-control " name="service_station_name"
                                                       value="{{ ((!empty($serviceStation->service_station_name)) ?$serviceStation->service_station_name :old('service_station_name')) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top mt-5 pt-10  card-footer">
                                    <div class="mr-2">
                                    </div>
                                    <div>
                                        @if($action=='INSERT')
                                            <button type="submit"
                                                    class="btn btn-success">
                                                <i class="fas fa-save"></i>Add Service Station
                                            </button>
                                        @else
                                            <button type="submit"
                                                    class="btn btn-warning">
                                                <i class="fas fa-save"></i>Update
                                            </button>
                                        @endif
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
        function getBranchDetails(id) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-Branch-Details') }}',
                data: {'company_id': id},
                success: function (data) {
                    $("#branch_id").html(data);
                    <?php if(!empty($serviceStation['branch_id'])){ ?>
                    document.getElementById("branch_id").value = '<?php echo $serviceStation['branch_id']; ?>';
                    <?php } ?>


                }
            });
        }
        <?php if(!empty($serviceStation['company_id'])){ ?>
        getBranchDetails(<?php echo $serviceStation['company_id']; ?>);
        <?php } ?>
    </script>
@endpush
