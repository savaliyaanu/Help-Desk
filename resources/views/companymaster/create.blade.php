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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Company Master</h2>
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
                                  action="{{($action=='INSERT')? url('company'):route('company.update',$companyItem->company_id)}}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Company Name
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 ">
                                            <div class="input-group">
                                                <input style="width: 100%" id="company_name" required
                                                       placeholder="Enter Company Name"
                                                       class="form-control" name="company_name"
                                                       value="{{ ((!empty($companyItem->company_name)) ?$companyItem->company_name :old('company_name')) }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Address
                                            <span class="text-danger">*</span> </label>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <input style="width: 100%" id="address1" placeholder="Enter Address"
                                                       class="form-control " name="address1" required
                                                       value="{{ ((!empty($companyItem->address1)) ?$companyItem->address1 :old('address1')) }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <input style="width: 100%" id="address2" placeholder="Enter Address"
                                                       class="form-control " name="address2"
                                                       value="{{ ((!empty($companyItem->address2)) ?$companyItem->address2 :old('address2')) }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <input style="width: 100%" id="address3" placeholder="Enter Address"
                                                       class="form-control " name="address3"
                                                       value="{{ ((!empty($companyItem->address3)) ?$companyItem->address3 :old('address3')) }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">City
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <select type="text" class="form-control kt_select2_5"
                                                        onchange="getCityDetails(this.value)" required
                                                        name="city_id" id="city_id" title="Please Enter City">
                                                    <option value="">Select City</option>
                                                    @foreach($cityList as $key=>$items)
                                                        <option
                                                            value="{{$items->city_id}}">{{$items->city_name}}</option>
                                                    @endforeach
                                                </select>
                                                <?php if(!empty($companyItem->city_id)){ ?>
                                                <script>document.getElementById("city_id").value = '<?php echo $companyItem->city_id; ?>';</script>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <label class="col-form-label text-right col-lg-1 ">District
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="district_id"
                                                       id="district_id" readonly
                                                       placeholder="Read District Name"
                                                       value="{{ ((!empty($companyItem->district_id)) ?$companyItem->district_id :old('district_id')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">State <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="state_id" readonly
                                                       placeholder="Read State Name" id="state_id"
                                                       value="{{ ((!empty($companyItem->state_id)) ?$companyItem->state_id :old('state_id')) }}"/>
                                            </div>
                                        </div>
                                        <label class="col-form-label text-right col-lg-1 ">PinCode <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="pincode"
                                                       placeholder="Enter PinCode" id="pincode" required
                                                       value="{{ ((!empty($companyItem->pincode)) ?$companyItem->pincode :old('pincode')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control" required
                                                       name="email" placeholder="Enter Email Address" id="email"
                                                       value="{{ ((!empty($companyItem->email)) ?$companyItem->email :old('email')) }}">
                                            </div>
                                        </div>
                                        <label class="col-form-label text-right col-lg-1 ">Contact No. <span
                                                class="text-danger">*</span> </label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <input type="text" class="form-control" required
                                                       name="phone" placeholder="Enter Phone Number" id="phone"
                                                       value="{{ ((!empty($companyItem->phone)) ?$companyItem->phone :old('phone')) }}">
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
                                                <i class="fas fa-save"></i>Add Company
                                            </button>
                                            <a href="{{route('company.index')}}"
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
        function getCityDetails(city_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('getCityDetails/') }}',
                data: {'city_id': city_id},
                success: function (data) {
                    var obj = JSON.parse(data);
                    document.getElementById("district_id").value = obj['district_id'];
                    document.getElementById("state_id").value = obj['state'];
                }
            });
        }
    </script>
@endpush
