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
                @if (session('create-status'))
                    <div class="alert alert-custom alert-notice alert-light-success fade show mb-5" role="alert">
                        <div class="alert-icon">
                            <i class="flaticon2-check-mark"></i>
                        </div>
                        <div class="alert-text">{{ session('create-status') }}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
																	<span aria-hidden="true">
																		<i class="ki ki-close"></i>
																	</span>
                            </button>
                        </div>
                    </div>
                @endif
                @if (session('update-status'))
                    <div class="alert alert-custom alert-notice alert-light-warning fade show mb-5" role="alert">
                        <div class="alert-icon">
                            <i class="flaticon-warning"></i>
                        </div>
                        <div class="alert-text">{{ session('update-status') }}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
																	<span aria-hidden="true">
																		<i class="ki ki-close"></i>
																	</span>
                            </button>
                        </div>
                    </div>
                @endif
                @if (session('delete-status'))
                    <div class="alert alert-custom alert-notice alert-light-primary fade show mb-5" role="alert">
                        <div class="alert-icon">
                            <i class="flaticon-delete-1"></i>
                        </div>
                        <div class="alert-text">{{ session('delete-status') }}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
																	<span aria-hidden="true">
																		<i class="ki ki-close"></i>
																	</span>
                            </button>
                        </div>
                    </div>
                @endif
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
                                <div class="col-xl-12">
                                    <!--begin::Wizard Form-->
                                    <form class="form" id=""
                                          action="{{($action=='INSERT')? url('party'):route('party.update',$partyDetail->expense_item_id) }}"
                                          method="post">
                                    @if ($action=='UPDATE')
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ csrf_field() }}
                                    <!--begin::Wizard Step 1-->
                                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                            <div class="form-group row">
                                                <div class="col-xl-4">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Party Name <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <input type="text" name="party_name" id="party_name" placeholder="Enter Client Name"
                                                                   class="form-control"  value="{{ ((!empty($partyDetail->party_name)) ?$partyDetail->party_name :old('party_name'))}}">
                                                            <?php if(!empty($partyDetail->party_name)){ ?>
                                                            <script>document.getElementById("party_name").value = '{{ $partyDetail->party_name }}';</script>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 ">
                                                    <!--begin::Input-->
                                                    <label >City Name <span class="text-danger ">*</span></label>
                                                    <div class="form-group ">
                                                        <input type="text" placeholder="Enter City Name" name="city_name"
                                                               class="form-control"
                                                               id="city_name"
                                                               value="{{ ((!empty($partyDetail->city_name)) ?$partyDetail->city_name :old('city_name'))}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 ">
                                                    <!--begin::Input-->
                                                    <label >Address <span class="text-danger ">*</span></label>
                                                    <div class="form-group ">
                                                        <input type="text" placeholder="Enter Address" name="address"
                                                               class="form-control"
                                                               id="address"
                                                               value="{{ ((!empty($partyDetail->address)) ?$partyDetail->address :old('address'))}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 ">
                                                    <!--begin::Input-->
                                                    <label >Mobile No <span class="text-danger ">*</span></label>
                                                    <div class="form-group ">
                                                        <input type="text" placeholder="Enter Number" name="mobile_no"
                                                               class="form-control"
                                                               id="mobile_no"
                                                               value="{{ ((!empty($partyDetail->mobile_no)) ?$partyDetail->mobile_no :old('mobile_no'))}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 ">
                                                    <!--begin::Input-->
                                                    <label >Serial No <span class="text-danger ">*</span></label>
                                                    <div class="form-group ">
                                                        <input type="text" placeholder="Enter Serial No" name="sr_no"
                                                               class="form-control"
                                                               id="sr_no"
                                                               value="{{ ((!empty($partyDetail->sr_no)) ?$partyDetail->sr_no :old('sr_no'))}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-5">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Model Item <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <select type="text" name="product_id" id="product_id"
                                                                    class="form-control kt_select2_5">
                                                                <option value="">Select Spare Item</option>
                                                                @foreach($spare_detail as $key=>$value)
                                                                    <option
                                                                        value="{{$value->product_id}}">{{$value->product_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <?php if(!empty($partyDetail->product_id)){ ?>
                                                            <script>document.getElementById("product_id").value = '{{ $partyDetail->product_id }}';</script>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 ">
                                                    <!--begin::Input-->
                                                    <label >Quantity <span class="text-danger ">*</span></label>
                                                    <div class="form-group ">
                                                        <input type="text" placeholder="0" name="qty"
                                                               class="form-control"
                                                               id="qty"
                                                               value="{{ ((!empty($partyDetail->qty)) ?$partyDetail->qty :old('qty'))}}">
                                                    </div>
                                                </div>
                                             9   <div class="col-3 text-right">
                                                    <label></label>
                                                    <div class="form-group">
                                                        @if($action=='INSERT')
                                                            <button type="submit"
                                                                    class="btn btn-success">
                                                                <i class="fas fa-save"></i> Save Item Expense
                                                            </button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn-warning">
                                                                <i class="fas fa-save"></i> Update Item Expense
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!--begin::Wizard Actions-->
                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                <div class="mr-2">
                                                    <a href="{{ url('service-expense/'.$expense_id.'/edit') }}"
                                                       class="btn btn-light-danger font-weight-bold mr-2">
                                                        <i class="la la-arrow-left"></i>
                                                        <span class="kt-hidden-mobile">Previous</span>
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="{{url('service-expense')}}"
                                                       class="btn btn-light-primary font-weight-bold">
                                                        Cancel
                                                    </a>
                                                    <a href="{{url('other-expense/create')}}"
                                                       class="btn btn-light-dark font-weight-bold"><span
                                                            class="kt-hidden-mobile">Next</span>
                                                        <i class="la la-arrow-right"></i>
                                                    </a>
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
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline mr-5">
                        <!--begin::Page Title-->
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Item List</h2>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Dropdown-->
                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions"
                         data-placement="left">
                        <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-header font-weight-bold py-4">
                                    <span class="font-size-lg">Choose Label:</span>
                                    <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip"
                                       data-placement="right" title="Click to learn more..."></i>
                                </li>
                                <li class="navi-separator mb-3 opacity-70"></li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span
                                                                class="label label-xl label-inline label-light-success">Customer</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span
                                                                class="label label-xl label-inline label-light-danger">Partner</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span
                                                                class="label label-xl label-inline label-light-warning">Suplier</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span
                                                                class="label label-xl label-inline label-light-primary">Member</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-dark">Staff</span>
														</span>
                                    </a>
                                </li>
                                <li class="navi-separator mt-3 opacity-70"></li>
                                <li class="navi-footer py-4">
                                    <a class="btn btn-clean font-weight-bold btn-sm" href="#">
                                        <i class="ki ki-plus icon-sm"></i>Add new</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="mb-7">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-xl-8">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 my-2 my-md-0">
                                            <div class="input-icon">
                                                <input type="text" class="form-control" placeholder="Search..."
                                                       id="kt_datatable_search_query"/>
                                                <span>
																	<i class="flaticon2-search-1 text-muted"></i>
																</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                            <tr>
                                <th>SR. No</th>
                                <th>Party Name</th>
                                <th>City Name</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($party))
                                @php $i=1 @endphp
                                @foreach ($party as $key=>$item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->party_name }}</td>
                                        <td>{{ $item->city_name }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                               href="{{url('party/'.$item->expense_item_id.'/edit')}}">
                                                <i class="flaticon2-pen"></i>
                                            </a>
                                            <form method="POST" style="display:inline;"
                                                  action="{{ route('party.destroy',$item->expense_item_id)  }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/custom/wizard/wizard-1.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script>
        $(".spare-product").select2({
            placeholder: "Select Product Name",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-spare') }}",
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
@endpush
