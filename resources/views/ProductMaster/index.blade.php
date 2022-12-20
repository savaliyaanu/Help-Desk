@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline mr-5">
                        <!--begin::Page Title-->
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Product Master List</h2>
                        <!--end::Page Title-->
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
                            <!--end::Navigation-->
                        </div>
                    </div>
                    <!--end::Dropdown-->
                    <!--begin::Button-->

                    <!--end::Button-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                @if (session('create-status'))
                    <div class="alert alert-success small  alert-dismissible" role="alert">
                        {{ session('create-status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                        </button>
                    </div>
                @endif
                @if (session('update-status'))
                    <div class="alert alert-warning small  alert-dismissible" role="alert">
                        {{ session('update-status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                        </button>
                    </div>
                @endif
                @if (session('delete-status'))
                    <div class="alert alert-danger small  alert-dismissible" role="alert">
                        {{ session('delete-status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                        </button>
                    </div>
                @endif

                <div class="card card-custom">
                    <div class="card-body">
                        <table class="table table-separate table-head-custom table-checkable" id="server-side-table">
                            <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Product Name</th>
                                <th>HSN</th>
                                <th>Part Code</th>
                                <th>Net Weight</th>
                                <th>Loose Weight</th>
                                <th>Packed Weight</th>
                            </tr>
                            </thead>
                            <tbody>
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
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/data-ajax.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        var ajaxTable = $('#server-side-table').DataTable({
            "processing": true,
            "aaSorting": [],
            "serverSide": true,
            "ordering": false,
            "pagingType": "full_numbers",
            "ajax": "{{url(!empty($AJAX_PATH)?$AJAX_PATH:'/')}}",
            "lengthMenu": [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]]
        });
    </script>
@endpush


