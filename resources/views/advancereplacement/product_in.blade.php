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
                        <h3 class="subheader-title text-dark font-weight-bold my-2 mr-3">Product Inward</h3>
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
            <!--begin::Card-->
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <!--begin::Form-->
                            <form class="form" id="kt_form_1"
                                  action="{{($action=='INSERT')? url('replacement-product/'):route('replacement-product.update',$replacementProduct->replacement_product_id)}}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <input type="hidden" name="replacement_in_id" value="{{ $replacement_in_id }}">

                                        <label class="col-form-label text-right col-lg-2">Spare Order Product</label>
                                        <div class="col-lg-4">
                                            <select type="text" id="spare_id"
                                                    class="form-control"
                                                    name="spare_id" data-live-search="true">
                                                <option value="">Select Spare Product</option>
                                                @foreach($order_master as $item)
                                                    <option value="{{$item->product_id}}">{{$item->item_name}}(Qty {{$item->order_quantity}})</option>
                                                @endforeach
                                            </select>
                                            <?php if(!empty($replacementProduct->spare_id)){ ?>
                                            <script>document.getElementById("spare_id").value = '{{ $replacementProduct->spare_id }}';</script>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2">Product
                                            Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <select type="text" id="product_id"
                                                    class="form-control spare-product"
                                                    name="product_id" data-live-search="true">
                                                <option value="">Select Spare Product</option>
                                                @foreach($productList as $item)
                                                    <option value="{{$item->product_id}}">{{$item->product_name}}</option>
                                                @endforeach
                                            </select>
                                            <?php if(!empty($replacementProduct->product_id)){ ?>
                                            <script>document.getElementById("product_id").value = '{{ $replacementProduct->product_id }}';</script>
                                            <?php } ?>
                                        </div>
                                        <label class="col-form-label text-right col-lg-2 ">Qty
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-2 ">
                                            <div class="input-group">
                                                <input id="qty" placeholder="Qty"
                                                       class="form-control " name="qty"
                                                       value="{{ ((!empty($replacementProduct->qty)) ?$replacementProduct->qty :old('qty')) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10 card-footer">
                                        <div class="mr-2">
                                            <a href="{{ url()->previous() }}"
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
                                                    <i class="fas fa-save"></i> Update
                                                </button>
                                            @endif
                                            <a href="{{url('advance-replacement')}}" class="btn btn-danger">
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
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline mr-5">
                        <!--begin::Page Title-->
                        <h3 class="subheader-title text-dark font-weight-bold my-2 mr-3">Item List</h3>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
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
                        <table class="table table-separate table-head-custom table-checkable">
                            <thead>
                            <tr>
                                <th>SR. No.</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($replacementProductList))
                                @php $i=1 @endphp
                                @foreach ($replacementProductList as $key=>$items)
                                    <tr>
                                        <td>{{ $i++}}</td>
                                        <td>{{ $items->product_name}}</td>
                                        <td>{{ $items->qty}}</td>
                                        <td>
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                               href="{{ url('replacement-product/'.$items->replacement_product_id.'/edit') }}">
                                                <i class="flaticon2-pen"></i>
                                            </a>
                                            <form method="POST" style="display:inline;"
                                                  action="{{ route('replacement-product.destroy',$items->replacement_product_id) }}">
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
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script>
        $(".spare-product").select2({
            placeholder: "Select a Spare Name",
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
        function getItemQty(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-item-qty') }}',
                data: {
                    'spare_id': id,
                },
                success: function (data) {
                    var obj = JSON.parse(data)
                    document.getElementById("qty").value = obj['qty'];
                }
            });
        }
    </script>
@endpush
