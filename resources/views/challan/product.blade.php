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
                        @include('challan.header')
                        <!--end::Wizard Nav-->
                            <!--begin::Wizard Body-->
                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                <div class="col-xl-8">
                                    <!--begin::Wizard Form-->
                                    <form class="form" id="kt_form"
                                          action="{{($action=='INSERT')? route('challan-product.store'):route('challan-product.update',$challanProduct['challan_product_id']) }}"
                                          method="post">
                                    @if ($action=='UPDATE')
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ csrf_field() }}
                                    <!--begin::Wizard Step 1-->
                                        <div class="pb-5" data-wizard-type="step-content">
                                            <input type="hidden" name="challan_id" id="challan_id"
                                                   value="<?php echo $challan_id ?>">
                                            <input type="hidden" name="challan_product_id" id="challan_product_id"
                                                   value="<?php echo (!empty($challanProduct['challan_product_id'])) ? $challanProduct['challan_product_id'] : ''; ?>">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Category Name <span class="text-danger">*</span> </label>
                                                        <select type="text" id="category_id" data-live-search="true"
                                                                class="form-control kt_select2_5 {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                                                                required
                                                                name="category_id">
                                                            <option value="">Select Category Name</option>
                                                            <?php foreach ($category_master as $row){ ?>
                                                            <option
                                                                value="<?php echo $row['category_id']; ?>" <?php echo (!empty($challanProduct['category_id']) AND $challanProduct['category_id'] == $row['category_id']) ? 'selected' : '';?>><?php echo $row['category_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        @if ($errors->has('category_id'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('category_id') }}</strong>
                                                            </div>
                                                        @endif
                                                        <?php if(!empty($challanProduct['category_id'])){ ?>
                                                        <script>document.getElementById("category_id").value = '<?php echo $challanProduct['category_id']; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Product Name <span class="text-danger">*</span></label>
                                                        <select type="text" id="complain_product_id"
                                                                data-live-search="true"
                                                                onchange="getComplainDetail(this.value,this.name)"
                                                                class="form-control kt_select2_5 {{ $errors->has('complain_product_id') ? 'is-invalid' : '' }}"
                                                                required
                                                                name="complain_product_id">
                                                            <option value="">Select Product Name</option>
                                                            <?php foreach ($complainProductData as $row){ ?>
                                                            <option
                                                                value="<?php echo $row->cid_id; ?>" <?php echo (!empty($challanProduct['complain_product_id']) AND $challanProduct['complain_product_id'] == $row->cid_id) ? 'selected' : '';?>><?php echo $row->product_name; ?>
                                                                (<?php echo $row->serial_no; ?>)
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                        @if ($errors->has('complain_product_id'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('complain_product_id') }}</strong>
                                                            </div>
                                                        @endif
                                                        <?php if(!empty($challanProduct['complain_product_id'])){ ?>
                                                        <script>document.getElementById("complain_product_id").value = '<?php echo $challanProduct['complain_product_id']; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Brand Name</label>
                                                        <select type="text" id="brand_id" data-size="7"
                                                                class="form-control selectpicker {{ $errors->has('brand_id') ? 'is-invalid' : '' }}"
                                                                required
                                                                name="brand_id" data-live-search="true">
                                                            <option value="">Select Brand Name</option>
                                                            <?php foreach ($brand_master as $row){ ?>
                                                            <option
                                                                value="<?php echo $row['brand_id']; ?>" <?php echo (!empty($challanProduct['brand_id']) AND $challanProduct['brand_id'] == $row['brand_id']) ? 'selected' : '';?>><?php echo $row['brand_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        @if ($errors->has('brand_id'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('brand_id') }}</strong>
                                                            </div>
                                                        @endif
                                                        <?php if(!empty($challanProduct['brand_id'])){ ?>
                                                        <script>document.getElementById("brand_id").value = '<?php echo $challanProduct['brand_id']; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Package Type </label>
                                                        <select type="text" data-live-search="true"
                                                                id="packing_type" required
                                                                class="form-control selectpicker {{ $errors->has('packing_type') ? 'is-invalid' : '' }}"
                                                                name="packing_type">
                                                            <option value="">Select Packing Type</option>
                                                            <option value="loose">Loose</option>
                                                            <option value="packing">Packing</option>
                                                            <option value="skd">Skd</option>
                                                        </select>
                                                        @if ($errors->has('packing_type'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('packing_type') }}</strong>
                                                            </div>
                                                        @endif
                                                        <?php if(!empty($challanProduct['packing_type'])){ ?>
                                                        <script>document.getElementById("packing_type").value = '<?php echo $challanProduct['packing_type']; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Warranty Period</label>
                                                        <select type="text" data-live-search="true"
                                                                id="warranty" required
                                                                class="form-control {{ $errors->has('warranty') ? 'is-invalid' : '' }}"
                                                                name="warranty">
                                                            <option value="">Select</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                        @if ($errors->has('warranty'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('warranty') }}</strong>
                                                            </div>
                                                        @endif
                                                        <?php if(!empty($challanProduct['warranty'])){ ?>
                                                        <script>document.getElementById("warranty").value = '<?php echo $challanProduct['warranty']; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Serial No</label>
                                                        <input type="text"
                                                               class="form-control {{ $errors->has('serial_no') ? 'is-invalid' : '' }}"
                                                               onchange="getBillDetail(this.value)"
                                                               placeholder="Enter Serial No." required
                                                               name="serial_no" id="serial_no"
                                                               value="<?php echo (!empty($challanProduct['serial_no'])) ? $challanProduct['serial_no'] : ''; ?>"/>
                                                        @if ($errors->has('serial_no'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('serial_no') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Production No </label>
                                                        <input type="text" placeholder="Enter Production No"
                                                               class="form-control {{ $errors->has('production_no') ? 'is-invalid' : '' }}"
                                                               required
                                                               name="production_no" id="production_no"
                                                               value="<?php echo (!empty($challanProduct['production_no'])) ? $challanProduct['production_no'] : ''; ?>"/>
                                                        @if ($errors->has('production_no'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('production_no') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Bill No </label>
                                                        <input type="text" placeholder="Enter Bill Number" required
                                                               class="form-control {{ $errors->has('bill_no') ? 'is-invalid' : '' }}"
                                                               id="bill_no"
                                                               name="bill_no"
                                                               value="<?php echo (!empty($challanProduct['bill_no'])) ? $challanProduct['bill_no'] : ''; ?>"/>
                                                        @if ($errors->has('bill_no'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('bill_no') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Bill Date </label>
                                                        <div class="input-group date">
                                                            <input type="text"
                                                                   class=" kt_datepicker_3 form-control {{ $errors->has('bill_date') ? 'is-invalid' : '' }}"
                                                                   name="bill_date" placeholder="Select Bill Date"
                                                                   id="bill_date"
                                                                   value="{{ !empty(old('bill_date'))?old('bill_date'):(!empty($challanProduct->bill_date)?date('d-m-Y',strtotime($challanProduct->bill_date)):date('d-m-Y')) }}"/>
                                                            @if ($errors->has('bill_date'))
                                                                <div class="invalid-feedback">
                                                                    <strong>{{ $errors->first('bill_date') }}</strong>
                                                                </div>
                                                            @endif
                                                            <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-calendar"></i>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Application </label>
                                                        <input type="text" placeholder="Enter Application"
                                                               class="form-control {{ $errors->has('application') ? 'is-invalid' : '' }}"
                                                               id="application" required
                                                               name="application"
                                                               value="<?php echo (!empty($challanProduct['application'])) ? $challanProduct['application'] : ''; ?>"/>
                                                        @if ($errors->has('application'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('application') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Hour Run</label>
                                                        <input type="text" placeholder="Enter Hour in Digit"
                                                               class="form-control {{ $errors->has('hour_run') ? 'is-invalid' : '' }}"
                                                               name="hour_run"
                                                               value="<?php echo (!empty($challanProduct['hour_run'])) ? $challanProduct['hour_run'] : ''; ?>"/>
                                                        @if ($errors->has('hour_run'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('hour_run') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Qty</label>
                                                        <input type="text" placeholder="Enter Qty"
                                                               id="quantity"
                                                               class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                                                               name="quantity"
                                                               value="<?php echo (!empty($challanProduct['quantity'])) ? $challanProduct['quantity'] : ''; ?>"/>
                                                        @if ($errors->has('quantity'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('quantity') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group">
                                                        <label>Mechanic Name <span class="text-danger">*</span> </label>
                                                        <select type="text" id="mechanic_id" data-live-search="true"
                                                                class="form-control kt_select2_5 {{ $errors->has('mechanic_id') ? 'is-invalid' : '' }}"
                                                                name="mechanic_id">
                                                            <option value="">Select Mechanic Name</option>
                                                            <?php foreach ($mechanicMaster as $row){ ?>
                                                            <option
                                                                value="<?php echo $row->mechanic_id; ?>" <?php echo (!empty($challanProduct->mechanic_id) AND $challanProduct->mechanic_id == $row->mechanic_id) ? 'selected' : '';?>><?php echo $row->mechanic_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        @if ($errors->has('mechanic_id'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('mechanic_id') }}</strong>
                                                            </div>
                                                        @endif
                                                        <?php if(!empty($challanProduct['category_id'])){ ?>
                                                        <script>document.getElementById("category_id").value = '<?php echo $challanProduct['category_id']; ?>';</script>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Wizard Step 5-->
                                            <!--begin::Wizard Actions-->

                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                <div class="mr-2">
                                                    <a href="{{ url('challan/'.$challan_id.'/edit') }}"
                                                       class="btn btn-light-danger font-weight-bold mr-2">
                                                        <i class="la la-arrow-left"></i>
                                                        <span class="kt-hidden-mobile">Previous</span>
                                                    </a>
                                                </div>
                                                <div>
                                                    @if($action=='INSERT')
                                                        <button type="submit"
                                                                class="btn btn-success">
                                                            <i class="fas fa-save"></i>Save
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                                class="btn btn-warning">
                                                            <i class="fas fa-save"></i>Update Product
                                                        </button>
                                                    @endif
                                                    <a href="{{ url('challan-product-create/'.$challan_id) }}"
                                                       class="btn btn-light-primary font-weight-bold">
                                                        <span class="kt-hidden-mobile">Cancel</span>
                                                    </a>
                                                    <a href="{{url('challan-accessories-create/'.$challan_id)}}"
                                                       class="btn btn-light-dark font-weight-bold">
                                                        <span class="kt-hidden-mobile">Next</span>
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
                    </div>
                    <!--end::Page Heading-->
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="">
                            <thead>
                            <tr>
                                <th class="text-center">Sr</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Shortage List</th>
                                <th class="text-center">Weight</th>
                                <th class="text-center">Brand Name</th>
                                <th class="text-center">Serial No</th>
                                <th class="text-center">Packing Type</th>
                                <th class="text-center">Bill No</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Charge</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($challanItem as $key=>$value){
                            ?>
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $value->product_name }}
                                    <table class="table-borderless">
                                        @foreach($value->getoptional as $keys=>$values)
                                            <tr>
                                                <td>
                                            <span
                                                style="color: {{ ($values->optional_status=='Remove')?'red':'blue' }}">{{ ($values->optional_status=='Remove')?'(-)':'(+)' }}</span> {{ $values->getProduct->product_name}}
                                                    ({{ $values->qty}} {{$values->unit_name}})
                                                    <a href="{{ url('delete-optional-item/'.$values->challan_optional_id) }}">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <table class="table-borderless">
                                        @foreach($value->getShortageList as $keys=>$values)
                                            <tr>
                                                <td>
                                                    {{ $values->getShortageName->shortage_name}}

                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="text-center">{{ $value->n_wt }}</td>
                                <td class="text-center">{{ $value->getBrand->brand_name }}</td>
                                <td class="text-center">{{ $value->serial_no }}</td>
                                <td class="text-center">{{ $value->packing_type }}</td>
                                <td class="text-center">{{ $value->bill_no }}</td>
                                <td class="text-center">{{ $value->quantity }}</td>
                                <td class="text-center">{{ $value->product_charge }}</td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Testing Form"
                                       target="_blank"
                                       href="{{url('challan-engine-testing/'.$value->challan_product_id)}}">
                                        <i class="fas fa-tools "></i>
                                    </a>
                                    <a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Product Image"
                                       href="{{url('challan-image/'.$value->challan_product_id)}}">
                                        <i class="flaticon2-image-file"></i>
                                    </a>
                                    <a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Shortage List"
                                       href="{{url('challan-shortage-item/'.$value->challan_product_id)}}">
                                        <i class="ki ki-bold-sort"></i>
                                    </a>
                                    <a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Inspection Report Form"
                                       target="_blank"
                                       href="{{url('inspection-report/'.$value->challan_product_id)}}">
                                        <i class="flaticon2-magnifier-tool"></i>
                                    </a>
                                    {{--<a href="javascript:void(0)" class="open-copy-dialog btn-sm"--}}
                                    {{--data-id="{{$value->challan_product_id}}"--}}
                                    {{--data-toggle="modal" data-target="#exampleModalCenter">O </a>--}}
                                    <a href="javascript:void(0)" class="open-copy-dialog btn-sm" title="Add Spare"
                                       data-id="{{$value->challan_product_id}}"
                                       data-toggle="modal" data-target="#spareModel"><i class="ki ki-plus"></i>
                                    </a>
                                    @can('update',$value)
                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Edit Product"
                                           href="{{ url('challan-product/'.$value->challan_product_id.'/edit') }}">
                                            <i class="flaticon2-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete',$value)
                                        <form method="POST" style="display:inline;"
                                              action="{{ route('challan-product.destroy',$value->challan_product_id)  }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" name="challan_product_id"
                                                   value="{{$value->challan_product_id}}">
                                            <input type="hidden" name="challan_id" value="{{$value->challan_id}}">
                                            <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                                    title="Delete Product">
                                                <i class="flaticon2-rubbish-bin-delete-button"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                            <?php } ?>
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Optional</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle"></i> </span>
                    </button>
                    <div class="input-icon">
                        <input type="text" class="form-control" placeholder="Search..."
                               id="kt_datatable_search_query"/>
                        <span>
																	<i class="flaticon2-search-1 text-muted"></i>
																</span>
                    </div>
                </div>
                @csrf
                <div class="modal-body resolved">
                    <div class="kt-portlet__body">
                        <input type="hidden" id="item_id" value="">
                        <table class="table table-separate table-head-custom table-checkable"
                               id="kt_datatable">
                            <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Product Name</th>
                                <th>Part Code</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($optional as $row){ ?>
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $row['product_name'] }}</td>
                                <td>{{ $row['part_code'] }}</td>
                                <td>
                                    <a href="#" class="btn btn-icon btn-light-success btn-sm mr-2"
                                       onclick="addOptional('<?php echo $row['product_id']; ?>','Add')"><i
                                            class="flaticon-plus"></i></a>
                                    <a href="#" class="btn btn-icon btn-light-danger btn-sm mr-2"
                                       onclick="addOptional('<?php echo $row['product_id']; ?>','Remove')"><i
                                            class="flaticon2-rubbish-bin-delete-button"></i></a>
                                </td>
                            </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="spareModel" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Spare</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle"></i> </span>
                    </button>
                </div>
                @csrf
                <form class="kt-form"
                      action="{{ url('save-spare') }}"
                      method="post">
                    <div class="modal-body resolved">
                        <div class="kt-portlet__body">
                            <input type="hidden" id="item_ids" name="item_ids" value="">

                            {{ csrf_field() }}
                            <div class="kt-portlet__body">
                                <div class="kt-form kt-form--fit kt-form--label-right">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Product Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control kt_select2_5" data-live-search="true"
                                                    style="width: 100%;"
                                                    title="select" name="product_id">
                                                <option value="">Select Product Name</option>
                                                @foreach ($spare as $key=>$item)
                                                    <option
                                                        value="{{$item->product_id}}">{{$item->product_name}}
                                                        ({{$item->part_code}})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label   text-right">Qty :</label>
                                        <div class="col-lg-3">
                                            <input type="text" name="spareQty" number="true" class="form-control"
                                                   required
                                                   placeholder="Enter Qty"
                                                   value="">
                                        </div>
                                        <label class="col-lg-2 col-form-label   text-right">Unit :</label>
                                        <div class="col-lg-3">
                                            <select type="text" name="unit_name" class="kt_select2_5 form-control">
                                                <option value="">Select</option>
                                                @foreach($unitMaster as $item)
                                                    <option value="{{$item->unit_name}}">{{$item->unit_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Add Spare
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('metronic/assets/js/pages/custom/wizard/wizard-1.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>

        $(document).on("click", ".open-copy-dialog", function () {
            var item_id = $(this).data('id');
            $("#item_id").val(item_id);
            $("#item_ids").val(item_id);
        });

        function addOptional(product_id, type) {
            var item_id = ($("#item_id").val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('save-optional') }}',
                data: {'product_id': product_id, 'type': type, 'item_id': item_id},
                success: function (data) {
                    location.reload();
                }
            });

        }

        function getBillDetail() {
            var product_id = ($("#product_id").val());
            var sr_no = ($("#serial_no").val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-Bill-Detail') }}',
                data: {'product_id': product_id, 'sr_no': sr_no},
                success: function (data) {
                    var data = JSON.parse(data);
                    $("#bill_no").val(data['bill_no']);
                    $("#kt_datepicker_3").val(data['bill_date']);
                }
            });
        }

        function getproduct(id) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-product') }}',
                data: {'category_id': id},
                success: function (data) {
                    $("#product_id").html(data);
                    <?php if(!empty($challanProduct['product_id'])){ ?>
                    document.getElementById("product_id").value = '<?php echo $challanProduct['product_id']; ?>';
                    <?php } ?>


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

        <?php if(!empty($challanProduct['category_id'])){ ?>
        getproduct(<?php echo $challanProduct['category_id']; ?>);
        <?php } ?>


        function getComplainDetail(id, name) {
            var challan_id = ($("#challan_id").val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-complain-detail') }}',
                data: {
                    'cid_id': id,
                    'challan_id': challan_id
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    document.getElementById("serial_no").value = obj['serial_no'];
                    document.getElementById("application").value = obj['application'];
                    document.getElementById("warranty").value = obj['warranty'];
                    document.getElementById("production_no").value = obj['production_no'];
                    document.getElementById("bill_no").value = obj['bill_no'];
                    document.getElementById("bill_date").value = obj['bill_date'];
                    document.getElementById("quantity").value = obj['quantity'];
                }
            });
            var category_id = name.replace("complain_product_id", "category_id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-category-name') }}',
                data: {
                    'complain_product_id': id
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    var newOption = new Option(obj['category_name'], obj['category_id'], false, true);
                    $("select[name='" + category_id + "']").append(newOption);
                }
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-complain-detail-challan') }}',
                method: 'post',
                data: {
                    complain_product_id: id
                }
            }).done(function (data) {
                $(".resolved").html(data);
                if (data) {
                    $("#exampleModalCenter").modal()
                }
            });
        }

        <?php if(!empty($challanProduct['complain_product_id'])){ ?>
        getComplainDetail(<?php echo $challanProduct['complain_product_id']; ?>);
        <?php } ?>

    </script>
@endpush
