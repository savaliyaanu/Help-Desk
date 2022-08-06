@extends('layouts.metronic')
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
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
            <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
                <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center flex-wrap mr-1">
                        <!--begin::Page Heading-->
                        <div class="d-flex align-items-baseline mr-5">
                            <!--begin::Page Title-->
                            <h3 class="subheader-title text-dark font-weight-bold my-2 mr-3">Replacement Expense Product
                                Inward</h3>
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
                                      action="{{($action=='INSERT')? url('expense-product-in-image'):route('expense-product-in-image.update',$replacement_in->expense_product_in_id)}}"
                                      method="post">
                                    @if ($action=='UPDATE')
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 ">Spare Product Inward<span
                                                    class="text-danger"> *</span> </label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <select type="text" id="expense_item_id"
                                                            class="form-control " onchange="getQty(this.value)"
                                                            name="expense_item_id" data-live-search="true">
                                                        <option value="">Select Product Name</option>
                                                        @foreach($inward_item as $key=>$value)
                                                            <option
                                                                value="{{$value->expense_item_id}}">{{$value->product_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <?php if(!empty($replacement_in->expense_item_id)){ ?>
                                                    <script>document.getElementById("expense_item_id").value = '{{ $replacement_in->expense_item_id }}';</script>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 ">Spare Product<span
                                                    class="text-danger"> *</span> </label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <select type="text" id="spare_id"
                                                            class="form-control kt_select2_5"
                                                            name="spare_id" data-live-search="true">
                                                        <option value="">Select Product Name</option>
                                                        @foreach($productList as $key=>$value)
                                                            <option
                                                                value="{{$value->product_id}}">{{$value->product_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <?php if(!empty($replacement_in->spare_id)){ ?>
                                                    <script>document.getElementById("spare_id").value = '{{ $replacement_in->spare_id }}';</script>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <label class="col-form-label text-right col-lg-2 ">Quantity<span
                                                    class="text-danger"> *</span> </label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-sort-numeric-asc"></i>
                                                    </span>
                                                    </div>
                                                    <input type="text" id="qty"
                                                           class="form-control " placeholder="0"
                                                           name="qty"
                                                           value="{{ ((!empty($replacement_in->qty)) ?$replacement_in->qty :old('qty'))}}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="d-flex justify-content-between border-top mt-5 pt-10 card-footer">
                                            <div class="mr-2">
                                                <a href="{{ url('service-expense') }}"
                                                   class="btn btn-light-danger font-weight-bold mr-2">
                                                    <i class="la la-arrow-left"></i>
                                                    <span class="kt-hidden-mobile">Previous</span>
                                                </a>
                                            </div>
                                            <div>
                                                @if($action=='INSERT')
                                                    <button type="submit"
                                                            class="btn btn-success">
                                                        <i class="fas fa-save"></i> Save
                                                    </button>
                                                    <a href="{{url('service-expense')}}"
                                                       class="btn btn-light-primary font-weight-bold">
                                                        Cancel
                                                    </a>
                                                @else
                                                    <button type="submit"
                                                            class="btn btn-warning">
                                                        <i class="fas fa-save"></i> Update
                                                    </button>
                                                @endif
                                                <a href="{{url('service-expense')}}"
                                                   class="btn btn-danger">
                                                    Finish
                                                </a>
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
                                <th class="text-center">Qty</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($expense_product_in as $key=>$value){
                            ?>
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td class="text-center">{{ $value->product_name }}</td>
                                <td class="text-center">{{ $value->qty }}</td>
                                <td class="text-center">

                                    <a class="btn btn-sm btn-clean btn-icon btn-icon-sm"
                                       href="{{ url('expense-product-in-image/'.$value->expense_product_in_id.'/edit') }}">
                                        <i class="flaticon2-pen"></i>
                                    </a>
                                    <form method="POST" style="display:inline;" title="Delete"
                                          action="{{ route('expense-product-in-image.destroy',$value->expense_product_in_id)  }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="flaticon2-rubbish-bin-delete-button"></i>
                                        </button>
                                    </form>
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
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>
        function getQty(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-Qty') }}',
                data: {
                    'expense_item_id': id,
                },
                success: function (data) {
                    var obj = JSON.parse(data)
                    document.getElementById("qty").value = obj['qty'];
                }
            });
        }
    </script>
@endpush
