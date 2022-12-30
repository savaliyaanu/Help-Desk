@extends('layouts.metronic')
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline mr-5">
                        <!--begin::Page Title-->
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Register Complain
                            *</h2>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
                            <li class="breadcrumb-item">
                                <a href="" class="text-muted">Complain</a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
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
                <div class="card card-custom">
                    <div class="card-body p-0">
                        <!--begin: Wizard-->
                        <div class="wizard wizard-2" id="kt_wizard_v2" data-wizard-state="step-first"
                             data-wizard-clickable="false">
                            <!--begin: Wizard Nav-->
                            <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
                                <!--begin::Wizard Step 1 Nav-->
                                <div class="wizard-steps">
                                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                        <div class="wizard-wrapper">
                                            <div class="wizard-icon">
																<span class="svg-icon svg-icon-2x">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<polygon points="0 0 24 0 24 24 0 24"/>
																			<path
                                                                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3"/>
																			<path
                                                                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                                                fill="#000000" fill-rule="nonzero"/>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
                                            </div>
                                            <div class="wizard-label">
                                                <h3 class="wizard-title">Complain Type</h3>
                                                <div class="wizard-desc">Select Complain Type</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-wizard-type="step">
                                        <div class="wizard-wrapper">
                                            <div class="wizard-icon">
                                                <span class="svg-icon svg-icon-2x">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Thunder-move.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                         version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path
                                                                d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z"
                                                                fill="#000000"/>
                                                            <path
                                                                d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z"
                                                                fill="#000000" opacity="0.3"/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </div>
                                            <div class="wizard-label">
                                                <h3 class="wizard-title">Complain Details</h3>
                                                <div class="wizard-desc">Add Problems</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Wizard Step 1 Nav-->
                                    <!--begin::Wizard Step 2 Nav-->
                                    <div class="wizard-step" data-wizard-type="step">
                                        <div class="wizard-wrapper">
                                            <div class="wizard-icon">
                                                <span class="svg-icon svg-icon-2x">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Compass.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                         version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path
                                                                d="M12,21 C7.02943725,21 3,16.9705627 3,12 C3,7.02943725 7.02943725,3 12,3 C16.9705627,3 21,7.02943725 21,12 C21,16.9705627 16.9705627,21 12,21 Z M14.1654881,7.35483745 L9.61055177,10.3622525 C9.47921741,10.4489666 9.39637436,10.592455 9.38694497,10.7495509 L9.05991526,16.197949 C9.04337012,16.4735952 9.25341309,16.7104632 9.52905936,16.7270083 C9.63705011,16.7334903 9.74423017,16.7047714 9.83451193,16.6451626 L14.3894482,13.6377475 C14.5207826,13.5510334 14.6036256,13.407545 14.613055,13.2504491 L14.9400847,7.80205104 C14.9566299,7.52640477 14.7465869,7.28953682 14.4709406,7.27299168 C14.3629499,7.26650974 14.2557698,7.29522855 14.1654881,7.35483745 Z"
                                                                fill="#000000"/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </div>
                                            <div class="wizard-label">
                                                <h3 class="wizard-title">Customer Details</h3>
                                                <div class="wizard-desc">Add Customer Details</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Wizard Step 2 Nav-->
                                    <!--begin::Wizard Step 5 Nav-->
                                    <div class="wizard-step" data-wizard-type="step">
                                        <div class="wizard-wrapper">
                                            <div class="wizard-icon">
                                                <span class="svg-icon svg-icon-2x">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Like.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                         version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path
                                                                d="M9,10 L9,19 L10.1525987,19.3841996 C11.3761964,19.7920655 12.6575468,20 13.9473319,20 L17.5405883,20 C18.9706314,20 20.2018758,18.990621 20.4823303,17.5883484 L21.231529,13.8423552 C21.5564648,12.217676 20.5028146,10.6372006 18.8781353,10.3122648 C18.6189212,10.260422 18.353992,10.2430672 18.0902299,10.2606513 L14.5,10.5 L14.8641964,6.49383981 C14.9326895,5.74041495 14.3774427,5.07411874 13.6240179,5.00562558 C13.5827848,5.00187712 13.5414031,5 13.5,5 L13.5,5 C12.5694044,5 11.7070439,5.48826024 11.2282564,6.28623939 L9,10 Z"
                                                                fill="#000000"/>
                                                            <rect fill="#000000" opacity="0.3" x="2"
                                                                  y="9" width="5" height="11" rx="1"/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </div>
                                            <div class="wizard-label">
                                                <h3 class="wizard-title">Completed!</h3>
                                                <div class="wizard-desc">Review and Submit</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Wizard Step 5 Nav-->
                                </div>
                            </div>
                            <!--end: Wizard Nav-->
                            <!--begin: Wizard Body-->
                            <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
                                <!--begin: Wizard Form-->
                                <div class="row">
                                    <div class="col-xxl-12">
                                        <form class="form" id="kt_form" method="post"
                                              action="{{($action=='INSERT')?route('complain-detail.store'):route('complain-detail.update', $complain[0]['complain_id']) }}">
                                        @if ($action=='UPDATE')
                                            {{ method_field('PUT') }}
                                        @endif
                                        {{ csrf_field() }}
                                        <!--begin: Wizard Step 1-->
                                            <div class="pb-5" data-wizard-type="step-content"
                                                 data-wizard-state="current">
                                                <h4 class="mb-10 font-weight-bold text-dark">Enter Complain Type</h4>
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Complain Type</label>
                                                    {{--<input type="text"--}}
                                                    {{--class="form-control form-control-solid form-control-lg"--}}
                                                    {{--name="fname" placeholder="First Name" value=""/>--}}
                                                    <select
                                                        class="form-control form-control-lg kt-select2 medium_id {{ $errors->has('medium_id') ? ' is-invalid' : '' }}"
                                                        required title="Select Complain Type"
                                                        name="complain_type" id="complain_type">
                                                        <option value="Product Complain">Product Complain</option>
                                                        <option value="Account Complain">Account Complain</option>
                                                        <option value="Marketing Complain">Marketing Complain</option>
                                                    </select>
                                                    <?php if(!empty($complain[0]['complain_type'])){ ?>
                                                    <script>document.getElementById("complain_type").value = '<?php echo $complain[0]['complain_type']; ?>';</script>
                                                    <?php } ?>
                                                </div>
                                                <!--end::Input-->
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Medium</label>
                                                    <select
                                                        class="form-control form-control-lg kt-select2 medium_id {{ $errors->has('medium_id') ? ' is-invalid' : '' }}"
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
                                                </div>
                                                <div class="form-group hide_whatsapp_no" style="display: none">
                                                    <label>Whatsapp No</label>
                                                    <input
                                                        class="form-control {{ $errors->has('whatsapp_no') ? ' is-invalid' : '' }}"
                                                        title="Enter Whatsapp No" number="true"
                                                        id="whatsapp_no" name="whatsapp_no"
                                                        placeholder="Enter Whatsapp No"
                                                        value="{{ ((!empty($complainMedium[0]['whatsapp_no'])) ?$complainMedium[0]['whatsapp_no'] :old('whatsapp_no')) }}">
                                                </div>
                                                <div class="form-group hide_email" style="display: none">
                                                    <label>Email</label>
                                                    <input
                                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        title="Enter Email"
                                                        id="email" name="email" placeholder="Enter Email"
                                                        value="{{ ((!empty($complainMedium[0]['email'])) ?$complainMedium[0]['email'] :old('email')) }}">
                                                </div>
                                                <div class="form-group hide_voucher_no" style="display: none">
                                                    <label>In/Out Internal Voucher No</label>
                                                    <input
                                                        class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                                        title="Enter In/Out Internal Voucher No"
                                                        id="voucher_no" name="voucher_no"
                                                        placeholder="Enter In/Out Internal Voucher No"
                                                        value="{{ ((!empty($complainMedium[0]['voucher_no'])) ?$complainMedium[0]['voucher_no'] :old('voucher_no')) }}">
                                                </div>
                                                <div class="form-group hide_mobile_no" style="display: none">
                                                    <label>Mobile No</label>
                                                    <input
                                                        class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                                        title="Enter Mobile Number" number="true"
                                                        id="mobile_no" name="mobile_no"
                                                        placeholder="Enter Mobile Number"
                                                        value="{{ ((!empty($complainMedium[0]['mobile_no'])) ?$complainMedium[0]['mobile_no'] :old('mobile_no')) }}">
                                                </div>
                                                <div class="form-group hide_staff_name" style="display: none">
                                                    <label>Staff Name</label>
                                                    <input
                                                        class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                                        title="Enter Staff Name"
                                                        id="staff_name" name="staff_name" placeholder="Enter Staff Name"
                                                        value="{{ ((!empty($complainMedium[0]['staff_name'])) ?$complainMedium[0]['staff_name'] :old('staff_name')) }}">
                                                </div>
                                                <div class="form-group hide_vehicle_no" style="display: none">
                                                    <label>Vehicle No</label>
                                                    <input
                                                        class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                                        title="Enter Vehicle No"
                                                        id="vehicle_no" name="vehicle_no" placeholder="Enter Vehicle No"
                                                        value="{{ ((!empty($complainMedium[0]['vehicle_no'])) ?$complainMedium[0]['vehicle_no'] :old('vehicle_no')) }}">
                                                </div>

                                                <!--end::Input-->
                                            </div>

                                            <div class="pb-5" data-wizard-type="step-content">
                                                <h4 class="mb-10 font-weight-bold text-dark">Complain Details</h4>
                                                <!--begin::Select-->
                                                <div class="form-group hide_account">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <!--begin::Input-->
                                                            <div class="form-group">
                                                                <label>Problem</label>
                                                                <textarea
                                                                    class="form-control {{ $errors->has('problem') ? ' is-invalid' : '' }}"
                                                                    title="Enter Problem"
                                                                    id="problem" name="problem" rows="3"
                                                                    placeholder="Enter Problem">{{ ((!empty($complain[0]['problem'])) ?$complain[0]['problem'] :old('problem')) }}</textarea>
                                                            </div>
                                                            <!--end::Input-->
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group hide_product">
                                                    <input type="hidden" id="current_table_row" required
                                                           class="{{ $errors->has('$complain_detail') ? ' is-invalid' : '' }}"
                                                           value="<?php echo empty($complain_detail) ? 2 : (count($complain_detail) + 1); ?>">
                                                    @if ($errors->has('$complain_detail'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('$complain_detail') }}</strong>
                                                        </span>
                                                    @endif
                                                    <div id="kt_repeater_1">
                                                        <div class="form-group row">
                                                            <div data-repeater-list="data" class="col-lg-12">
                                                                <?php if (!empty($complain_detail)) {
                                                                $temp = 0;
                                                                foreach ($complain_detail as $item) { ?>
                                                                <input type="hidden" name="cid_id[]"
                                                                       value="<?php echo $item['cid_id']; ?>">

                                                                <div data-repeater-item=""
                                                                     class="form-group row align-items-center">
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Category <span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <select
                                                                                    class="form-control category-select2 chosen"
                                                                                    style="width: 300px"
                                                                                    data-live-search="true"
                                                                                    id="category_id_2"
                                                                                    onchange="getproduct(this.value,this.name)"
                                                                                    name="category_id">
                                                                                    <option value="">Select Category
                                                                                    </option>
                                                                                    <?php foreach ($categoryMaster as $row){ ?>
                                                                                    <option
                                                                                        value="<?php echo $row['category_id']; ?>" <?php echo ($item['category_id'] == $row['category_id']) ? 'selected' : ''; ?>><?php echo $row['category_name']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <?php if(!empty($item['category_id'])){ ?>
                                                                                <script>document.getElementById("category_id").value = '<?php echo $item['category_id']; ?>';</script>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Model <span
                                                                                        class="text-danger">*</span></label>
                                                                                <select
                                                                                    class="form-control select2-control chosen"
                                                                                    style="width:300px;"
                                                                                    id="product_id_2"
                                                                                    name="product_id">
                                                                                    <option value="">Select</option>
                                                                                </select>
                                                                                <script>
                                                                                    document.getElementById('product_id_<?php echo $temp; ?>').value = '<?php echo $item['product_id']; ?>';
                                                                                </script>
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Serial No <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control"
                                                                                       style="width: 300px"
                                                                                       placeholder="Enter Serial No"
                                                                                       onchange="getLastComplainBySr(this.name,'<?php echo $item['cid_id']; ?>')"
                                                                                       id="sr_no_2"
                                                                                       value="<?php echo $item['serial_no']; ?>"
                                                                                       name="sr_no">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Production No</label>
                                                                                <input type="text" class="form-control"
                                                                                       style="width: 300px"
                                                                                       placeholder="Enter Production No"
                                                                                       name="production_no"
                                                                                       id="production_no_2"
                                                                                       value="<?php echo $item['production_no']; ?>">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Invoice No</label>
                                                                                <input type="text" class="form-control"
                                                                                       style="width: 300px"
                                                                                       placeholder="Enter Invoice No"
                                                                                       id="invoice_no_2"
                                                                                       name="invoice_no"
                                                                                       value="<?php echo $item['invoice_no']; ?>">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Invoice Date</label>
                                                                                <input type="text"
                                                                                       class="date-picker form-control"
                                                                                       style="width: 300px"
                                                                                       placeholder="Select Invoice Date"
                                                                                       id="invoice_date"
                                                                                       name="invoice_date"
                                                                                       value="<?php echo $item['invoice_date']; ?>">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Complain</label>
                                                                                <select
                                                                                    class="form-control select2-control"
                                                                                    style="width: 300px"
                                                                                    name="complain[]" multiple
                                                                                    id="complain_2">
                                                                                    <option value="">Select Complain
                                                                                    </option>
                                                                                    <?php foreach ($ComplainList as $row){ ?>
                                                                                    <option
                                                                                        value="<?php echo $row['questions']; ?>" <?php echo (!empty($item['complain']) AND $item['complain'] == $row['questions']) ? 'selected' : '';?>><?php echo $row['questions']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Application</label>
                                                                                <input type="text" class="form-control"
                                                                                       style="width: 300px"
                                                                                       placeholder="Enter Application"
                                                                                       id="application_2"
                                                                                       name="application"
                                                                                       value="<?php echo $item['application']; ?>">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Warranty</label>
                                                                                <select
                                                                                    class="form-control"
                                                                                    style="width: 300px"
                                                                                    data-live-search="true"
                                                                                    id="warranty"
                                                                                    name="warranty">
                                                                                    <option
                                                                                        value="No" <?php echo (!empty($item['warranty'] == 'No')) ? 'selected' : ''; ?>>
                                                                                        No
                                                                                    </option>
                                                                                    <option
                                                                                        value="Yes" <?php echo (!empty($item['warranty'] == 'Yes')) ? 'selected' : ''; ?>>
                                                                                        Yes
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Qty</label>
                                                                                <input type="text" class="form-control"
                                                                                       style="width: 300px"
                                                                                       placeholder="Enter Qty"
                                                                                       id="qty_2"
                                                                                       name="qty"
                                                                                       value="<?php echo $item['qty']; ?>">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Product Remark</label>
                                                                                <textarea type="text"
                                                                                          placeholder="Enter Remark"
                                                                                          class="form-control"
                                                                                          style="width: 300px"
                                                                                          id="pro_remark_2"
                                                                                          name="pro_remark"><?php echo $item['pro_remark']; ?></textarea>
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>&nbsp;</label>
                                                                                <a href="javascript:;"
                                                                                   style="width: 300px;"
                                                                                   name="viewDetails"
                                                                                   onclick="getLastComplainDetail(this.name,'<?php echo $item['cid_id']; ?>')"
                                                                                   class="btn btn-sm font-weight-bolder btn-light-info open-last-complain">
                                                                                    <i class="fas fa-info-circle"></i>View
                                                                                    Information</a>
                                                                            </div>
                                                                        </div>
                                                                        @if($action!='UPDATE')
                                                                            <div class="col-xl-6">
                                                                                <div class="form-group">
                                                                                    <label>&nbsp;</label>
                                                                                    <a href="javascript:;"
                                                                                       style="width: 300px;"
                                                                                       data-repeater-delete=""
                                                                                       class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                                        <i class="la la-trash-o"></i>Delete</a>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <?php $temp++;
                                                                } ?>
                                                                <?php } else { ?>

                                                                <div data-repeater-item=""
                                                                     class="form-group row align-items-center">
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Category <span
                                                                                        class="text-danger">*</span></label>
                                                                                <select
                                                                                    class="form-control category-select2 chosen"
                                                                                    style="width: 300px"
                                                                                    id="category_id_2"
                                                                                    onchange="getproduct(this.value,this.name)"
                                                                                    name="category_id">
                                                                                    <option value="">Select Category
                                                                                    </option>
                                                                                </select>

                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Model <span
                                                                                        class="text-danger">*</span></label>
                                                                                <select
                                                                                    class="form-control select2-control chosen"
                                                                                    style="width: 300px"
                                                                                    data-live-search="true"
                                                                                    id="product_id_2"
                                                                                    name="product_id">
                                                                                    <option value="">Select</option>

                                                                                </select>
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Serial No <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       style="width: 300px"
                                                                                       placeholder="Enter Serial No"
                                                                                       id="sr_no_2"
                                                                                       onchange="getLastComplainBySr(this.name,'0')"
                                                                                       name="sr_no">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Production No</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       style="width: 300px"
                                                                                       placeholder="Enter Production No"
                                                                                       name="production_no"
                                                                                       id="production_no_2"
                                                                                       value="">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Invoice No</label>
                                                                                <input type="text"
                                                                                       placeholder="Enter Invoice No"
                                                                                       class="form-control"
                                                                                       style="width: 300px"
                                                                                       id="invoice_n2"
                                                                                       name="invoice_no">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Invoice Date</label>
                                                                                <input type="text"
                                                                                       class="form-control date-picker"
                                                                                       style="width: 300px"
                                                                                       placeholder="Select Invoice Date"
                                                                                       id="invoice_date"
                                                                                       name="invoice_date">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Complain</label>
                                                                                <select
                                                                                    class="form-control select2-control"
                                                                                    style="width: 300px"
                                                                                    name="complain[]" multiple
                                                                                    id="complain_2">
                                                                                    <option value="">Select Complain
                                                                                    </option>
                                                                                    <?php foreach ($ComplainList as $row){ ?>
                                                                                    <option
                                                                                        value="<?php echo $row['questions']; ?>" <?php echo (!empty($ComplainList['complain']) AND $ComplainList['complain'] == $row['questions']) ? 'selected' : '';?>><?php echo $row['questions']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Application</label>
                                                                                <input type="text"
                                                                                       placeholder="Enter Application"
                                                                                       class="form-control"
                                                                                       style="width: 300px"
                                                                                       id="application_2"
                                                                                       name="application">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Warranty</label>
                                                                                <select
                                                                                    class="form-control"
                                                                                    style="width: 300px"
                                                                                    data-live-search="true"
                                                                                    id="warranty"
                                                                                    name="warranty">
                                                                                    <option value="No">No</option>
                                                                                    <option value="Yes">Yes</option>
                                                                                </select>
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Qty</label>
                                                                                <input type="text"
                                                                                       placeholder="Enter Qty"
                                                                                       class="form-control"
                                                                                       style="width: 300px"
                                                                                       id="qty_2"
                                                                                       name="qty">
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>Product Remark</label>
                                                                                <textarea type="text"
                                                                                       placeholder="Enter Remark"
                                                                                       class="form-control"
                                                                                       style="width: 300px"
                                                                                       id="pro_remark_2"
                                                                                       name="pro_remark"></textarea>
                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <!--begin::Input-->
                                                                            <div class="form-group">
                                                                                <label>&nbsp;</label>
                                                                                <a href="javascript:;"
                                                                                   style="width: 300px;"
                                                                                   name="viewDetails"
                                                                                   onclick="getLastComplainDetail(this.name,'0')"
                                                                                   class="btn btn-sm font-weight-bolder btn-light-info open-last-complain">
                                                                                    <i class="fas fa-info-circle"></i>View
                                                                                    Last Complain</a>

                                                                            </div>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        @if($action!='UPDATE')
                                                                            <div class="col-xl-6">
                                                                                <!--begin::Input-->
                                                                                <div class="form-group">
                                                                                    <label>&nbsp;</label>
                                                                                    <a href="javascript:;"
                                                                                       style="width: 300px;"
                                                                                       data-repeater-delete=""
                                                                                       class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                                        <i class="la la-trash-o"></i>Delete</a>
                                                                                </div>
                                                                                <!--end::Input-->
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-lg-2 col-form-label text-right"></label>
                                                            <div class="col-lg-4">
                                                                <a href="javascript:;" data-repeater-create=""
                                                                   onclick="getItem()"
                                                                   class="btn btn-sm font-weight-bolder btn-light-success">
                                                                    <i class="la la-plus"></i>Add New Product</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--end: Wizard Step 1-->
                                            <!--begin: Wizard Step 2-->
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <h4 class="mb-10 font-weight-bold text-dark">Client Details</h4>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Distributor Name</label>
                                                            <select style="width: 100%" id="distributor_id"
                                                                    class="form-control distributor-select2 client_id  {{ $errors->has('client_id') ? ' is-invalid' : '' }}"
                                                                    name="distributor_id"
                                                                    onchange="getClientDetails(this.value)"
                                                                    data-live-search="true"
                                                                    title="Select Client Name">
                                                                <option value="">Select Distributor Name</option>
                                                                <?php
                                                                if(isset($complain)){ ?>
                                                                @foreach ($clientMaster as $row)
                                                                    <option
                                                                        value="{{ $row->client_id }}">{{ $row->client_name }}</option>
                                                                @endforeach
                                                                <?php } ?>
                                                            </select>
                                                            <?php if(!empty($complain[0]['distributor_id'])){ ?>
                                                            <script>document.getElementById("distributor_id").value = '<?php echo $complain[0]['distributor_id']; ?>';</script>
                                                            <?php } ?>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Dealer Name</label>
                                                            <select style="width: 100%" id="client_id"
                                                                    class="form-control dealer-select2 client_id  {{ $errors->has('client_id') ? ' is-invalid' : '' }}"
                                                                    name="client_id"
                                                                    onchange="getClientDetails(this.value)"
                                                                    data-live-search="true"
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
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Client Name</label>
                                                            <input
                                                                class="form-control {{ $errors->has('client_name') ? ' is-invalid' : '' }}"
                                                                required
                                                                id="client_name" name="client_name"
                                                                placeholder="Enter Client"
                                                                value="{{ ((!empty($complain[0]['client_name'])) ?$complain[0]['client_name'] :old('client_name')) }}">
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Address *</label>
                                                            <textarea
                                                                class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                                required title="Enter Address"
                                                                id="address" name="address" rows="3"
                                                                placeholder="Enter Address">{{ ((!empty($complain[0]['address'])) ?$complain[0]['address'] :old('address')) }}</textarea>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Mobile *</label>
                                                            <input
                                                                class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                                                required title="Enter Mobile Number" number="true"
                                                                id="mobile" name="mobile" placeholder="Enter Mobile"
                                                                value="{{ ((!empty($complain[0]['mobile'])) ?$complain[0]['mobile'] :old('mobile')) }}">
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Mobile *</label>
                                                            <input number="true"
                                                                   class="form-control {{ $errors->has('mobile2') ? ' is-invalid' : '' }}"
                                                                   name="mobile2"
                                                                   placeholder="Enter Mobile"
                                                                   value="{{ ((!empty($complain[0]['mobile2'])) ?$complain[0]['mobile2'] :old('mobile2')) }}">
                                                            @if ($errors->has('mobile2'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('mobile2') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Email *</label>
                                                            <input type="text"
                                                                   class="form-control {{ $errors->has('email_address') ? ' is-invalid' : '' }}"
                                                                   title="Enter Email"
                                                                   id="email_address" name="email_address"
                                                                   placeholder="Enter Valid Email"
                                                                   value="{{ ((!empty($complain[0]['email_address'])) ?$complain[0]['email_address'] :old('email_address')) }}">
                                                            @if ($errors->has('email_address'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('email_address') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>City</label>
                                                            <select style="width: 100%"
                                                                    class="form-control city-select2 {{ $errors->has('city_id') ? ' is-invalid' : '' }}"
                                                                    required data-live-search="true"
                                                                    id="city_id" name="city_id"
                                                                    title="Select City Name"
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
                                                            <?php if(!empty($complain[0]['city_id'])){ ?>
                                                            <script>document.getElementById("city_id").value = '<?php echo $complain[0]['city_id']; ?>';</script>
                                                            <?php } ?>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <!--begin::Select-->
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <input
                                                                class="form-control {{ $errors->has('district') ? ' is-invalid' : '' }}"
                                                                title="Enter District" readonly
                                                                id="district" name="district"
                                                                placeholder="Enter District"
                                                                value="{{ ((!empty($complain[0]['district'])) ?$complain[0]['district'] :old('district')) }}">
                                                        </div>

                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>State</label>
                                                            <input
                                                                class="form-control {{ $errors->has('state') ? ' is-invalid' : '' }}"
                                                                title="Enter State" readonly
                                                                id="state" name="state" placeholder="Enter State"
                                                                value="{{ ((!empty($complain[0]['state'])) ?$complain[0]['state'] :old('state')) }}">
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>GST No.</label>
                                                            <input type="text"
                                                                   class="form-control {{ $errors->has('complain_gst') ? ' is-invalid' : '' }}"
                                                                   title="Enter GST"
                                                                   id="complain_gst" name="complain_gst"
                                                                   placeholder="Enter GST No."
                                                                   value="{{ ((!empty($complain[0]['complain_gst'])) ?$complain[0]['complain_gst'] :old('complain_gst')) }}">
                                                            @if ($errors->has('complain_gst'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('complain_gst') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>PinCode</label>
                                                            <input type="text"
                                                                   class="form-control {{ $errors->has('complain_pincode') ? ' is-invalid' : '' }}"
                                                                   title="Enter PinCode"
                                                                   id="complain_pincode" name="complain_pincode"
                                                                   placeholder="Enter GST No."
                                                                   value="{{ ((!empty($complain[0]['complain_pincode'])) ?$complain[0]['complain_pincode'] :old('complain_pincode')) }}">
                                                            @if ($errors->has('complain_pincode'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('complain_pincode') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>
                                                <div class="row" style="display: none" id="no_warranty">
                                                    <div class="col-xl-12">
                                                        <div class="form-group form-group-last">
                                                            <div class="alert alert-custom alert-default"
                                                                 role="alert">
                                                                <div class="alert-icon">
                                                                    <i class="flaticon-alert"></i>
                                                                </div>
                                                                <div class="alert-text"><code> Dealer take
                                                                        <strong>3%</strong> discount on all <strong>SUBMERSIBLE
                                                                            PRODUCTS-NO WARRANTY</strong></code></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!--end: Wizard Step 2-->
                                            <!--begin: Wizard Step 3-->
                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                <div class="mr-2">
                                                    <button type="button"
                                                            class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"
                                                            data-wizard-type="action-prev">Previous
                                                    </button>
                                                </div>
                                                <div>
                                                    <button type="submit" name="save" value="save"
                                                            class="btn btn-success font-weight-bold text-uppercase px-9 py-4"
                                                            data-wizard-type="action-submit"><i
                                                            class="fas fa-save"></i> Save Complain
                                                    </button>
                                                    <button type="submit" name="next_assign" value="next_assign"
                                                            class="btn btn-info font-weight-bold text-uppercase px-9 py-4"
                                                            data-wizard-type="action-submit"><i
                                                            class="fas fa-save"></i>Save & Next Assign Complain
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-primary font-weight-bold text-uppercase px-9 py-4"
                                                            data-wizard-type="action-next">Next
                                                    </button>
                                                </div>
                                            </div>
                                            <!--end: Wizard Actions-->
                                        </form>
                                    </div>
                                    <!--end: Wizard-->
                                </div>
                                <!--end: Wizard Form-->
                            </div>
                            <!--end: Wizard Body-->
                        </div>
                        <!--end: Wizard-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                {{--<div class="modal-header">--}}
                {{--<h5 class="modal-title" id="exampleModalLongTitle">Last Complain Details</h5>--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                {{--<span aria-hidden="true"><i class="fa fa-times-circle"></i> </span>--}}
                {{--</button>--}}
                {{--</div>--}}
                <div class="modal-body resolved">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--end::Content-->
@endsection
@push('styles')
    <link href="{{ asset('metronic/assets/css/pages/wizard/wizard-2.css?v=7.0.4') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('scripts')
    <script src="{{ asset('metronic/assets/js/pages/custom/wizard/wizard-2.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/form-repeater.js?v=7.0.4')}}"></script>
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
            cell1.innerHTML = '<select class="form-control category-select2 chosen" id="category_id_' + current_table_row + '" required name="category_id[]"><?php foreach ($categoryMaster as $row){ ?> <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option> <?php } ?></select>';
            cell2.innerHTML = '<select class="form-control chosen" id="product_id_' + current_table_row + '" required name="product_id[]"></select>';
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
                    document.getElementById("email_address").value = obj['complain_email'];
                    document.getElementById("complain_gst").value = obj['complain_gst'];
                    document.getElementById("complain_pincode").value = obj['complain_pincode'];
                    var is_no_warranty = obj['is_no_warranty'];
                    if (is_no_warranty == 'Y') {
                        $("#no_warranty").show();
                    } else {
                        $("#no_warranty").hide();
                    }
                    document.getElementById("state").value = obj['state_id'];
                    var x = document.getElementById('city_id');
                    x.remove(x.selectedIndex);
                    var newOption = new Option(obj['city_name'], obj['city_id'], false, true);
                    $('#city_id').append(newOption).trigger('change');
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
                        $('.kt_select2_5').selectpicker();
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
                url: '{{ url('getCityDetails/') }}',
                data: {'city_id': city_id},
                success: function (data) {
                    var obj = JSON.parse(data);
                    document.getElementById("district").value = obj['district_id'];
                    document.getElementById("state").value = obj['state'];
                }
            });
        }

        $(".distributor-select2").select2({
            placeholder: "Select a Client",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-only-distributor') }}",
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
        $(".dealer-select2").select2({
            placeholder: "Select a Client",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('get-only-client') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        extraSearch: $("#distributor_id").val() // search term
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
        $("#medium_id").change(function () {
            var medium_id = ($("#medium_id").val());
            $(".hide_whatsapp_no").hide();
            $(".hide_email").hide();
            $(".hide_voucher_no").hide();
            $(".hide_mobile_no").hide();
            $(".hide_staff_name").hide();
            $(".hide_vehicle_no").hide();
            if (medium_id == 1) {
                $(".hide_mobile_no").show();
            } else if (medium_id == 2) {
                $(".hide_voucher_no").show();
            } else if (medium_id == 3) {
                $(".hide_whatsapp_no").show();
            } else if (medium_id == 4) {
                $(".hide_email").show();
            } else if (medium_id == 5) {
                $(".hide_vehicle_no").show();
            } else if (medium_id == 6) {
                $(".hide_staff_name").show();
            }
        });
        $('#medium_id').change();
        $("#complain_type").change(function () {
            var complain_type = ($("#complain_type").val());
            $(".hide_account").hide();
            $(".hide_product").hide();
            if (complain_type == 'Product Complain') {
                $(".hide_product").show();
            } else {
                $(".hide_account").show();
            }
        });
        $('#complain_type').change();

        function sentrequest(sr_no, product_id, current_complain_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-last-complain') }}',
                method: 'post',
                data: {
                    sr_no: sr_no,
                    current_complain_id: current_complain_id,
                    product_id: product_id
                }
            }).done(function (data) {
                $(".resolved").html(data);
                if (data) {
                    $("#exampleModalCenter").modal()
                }
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-client-info') }}',
                method: 'post',
                data: {
                    sr_no: sr_no,
                    current_complain_id: current_complain_id,
                    product_id: product_id
                }
            }).done(function (data) {
                var obj = JSON.parse(data);
                var dealerType = obj['c_type'];
                if (dealerType == 'DEALER') {
                    var x = document.getElementById('client_id');
                    x.remove(x.selectedIndex);
                    var newOption = new Option(obj['client_name'], obj['client_id'], false, true);
                    $('#client_id').append(newOption).trigger('change');
                } else {
                    var x = document.getElementById('distributor_id');
                    x.remove(x.selectedIndex);
                    var newOption = new Option(obj['client_name'], obj['client_id'], false, true);
                    $('#distributor_id').append(newOption).trigger('change');
                }
                getClientDetails(obj['client_id']);
            });
        }

        function getLastComplainDetail(name, current_complain_id) {
            var sr_no = name.replace('viewDetails', "sr_no");
            var sr_no = $('input[name="' + sr_no + '"]').val();
            var product_id = name.replace('viewDetails', "product_id");
            var product_id = $('select[name="' + product_id + '"]').val();
            sentrequest(sr_no, product_id, current_complain_id)
        }

        function getLastComplainBySr(name, current_complain_id) {
            var serial_no = name.replace('sr_no', "sr_no");
            var serial_no = $('input[name="' + serial_no + '"]').val();
            var product_id = name.replace('sr_no', "product_id");
            var product_id = $('select[name="' + product_id + '"]').val();
            sentrequest(serial_no, product_id, current_complain_id)
        }
    </script>

    <script>
        function getproduct(value, id, product_id) {
            var id = id.replace('data[', "");
            var id = id.replace(']', "");
            var id = id.replace('category_id', "");
            var id = id.replace('[]', "");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-products') }}',
                method: 'post',
                data: {
                    category_id: value,
                    product_id: product_id
                }
            }).done(function (data) {
                $('select[name="data[' + id + '][product_id]"]').empty();
                $('select[name="data[' + id + '][product_id]"]').append(data);
                $('select[name="data[' + id + '][product_id]"]').trigger("chosen:updated");
            });
        }
    </script>

    <?php if (!empty($complain_detail)) {
    $temp = 0;
    foreach ($complain_detail as $item) { ?>
    <script>
        getproduct('<?php echo $item['category_id']; ?>', "data[<?php echo $temp; ?>][category_id]", "<?php echo $item['product_id']; ?>");
    </script>
    <?php
    $temp++;
    }} ?>
    <script>
        function getCategory() {
            $(".category-select2").select2({
                placeholder: "Select a Category",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('get-category') }}",
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
        }

        function getItem() {
            setTimeout(function () {
                getCategory();
            }, 1200);

            jQuery(document).ready(function ($) {
                $('.date-picker').datepicker({
                    format: 'dd-mm-yyyy', //maybe you want something like this
                    showButtonPanel: true
                });
            });
            $(document).ready(function () {
                $('.select2-control').select2({
                    placeholder: "Select ...",
                    allowClear: true
                });
            });
            jQuery(document).ready(function () {
                jQuery(".chosen").chosen();
            });
        }

        getItem()
    </script>

@endpush
