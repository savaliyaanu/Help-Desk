@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Complain Detail</h2>
                    </div>
                </div>
                @can('create', App\Complain::class)
                    <div class="d-flex align-items-center">
                        <a href="{{route('complain-detail.create')}}"
                           class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
                            <span class="svg-icon svg-icon-success svg-icon-lg">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                     viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path
                                                d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                        <path
                                                d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                fill="#000000" fill-rule="nonzero"/>
                                    </g>
                                </svg>
                            </span>New Complain
                        </a>
                    </div>
                @endcan
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->

            <div class="container-fluid ">
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
                    <div class="card-body">
                        <table class="table table-separate table-head-custom table-checkable" id="server-side-table">
                            <thead>
                            <tr>
                                <th>Ref No</th>
                                <th>Date</th>
                                <th>Client Name</th>
                                <th>Type</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Status</th>
                                <th>Medium Name</th>
                                <th>Entry BY</th>
                                <th>Assign Name</th>
                                <th>TKT. Assign</th>
                                <th>TKT. Resolved</th>
                                <th>TKT. FollowUP</th>
                                <th>FollowUp History</th>
                                <th>PDF</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Complain Resolved</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle"></i> </span>
                    </button>
                </div>
                <form method="post" action="{{'complain-resolved-save'}}">
                    @csrf
                    <div class="modal-body resolved">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="followup" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Followup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle"></i> </span>
                    </button>
                </div>
                <form method="post" action="{{'saveFollowUp'}}">
                    @csrf
                    <div class="modal-body fill-followup">
                        <div class="card-body">
                            <div class="alert alert-custom alert-light-danger d-none" role="alert" id="kt_form_1_msg">
                                <div class="alert-icon">
                                    <i class="flaticon2-information"></i>
                                </div>
                                <div class="alert-text font-weight-bold">Oh snap! Change a few things up and try
                                    submitting again.
                                </div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span>
																	<i class="ki ki-close"></i>
																</span>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="complain_id" id="complain_id" value="">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Client Name</label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input type="text" class="form-control form-control-sm" id="client_name" readonly
                                           required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Assign Person</label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input type="text" class="form-control form-control-sm" id="assign_name" readonly
                                           required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Remark</label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <textarea required rows="3" class="form-control" name="remark"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Date</label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" readonly="readonly"
                                               name="next_followup_date" placeholder="Select Date" id="kt_datepicker_3"
                                               value=""/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="{{asset('assets/css/fixedHeader.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush
@push('scripts')
    <script src="{{asset('assets/js/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.fixedHeader.min.js')}}"></script>
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


        $(document).on("click", ".open-copy-dialog", function () {
            var complain_id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('complain-resolved') }}',
                data: {'complain_id': complain_id},
                success: function (data) {
                    $(".resolved").html(data);
                }
            });
        });

        $(document).on("click", ".open-follow-dialog", function () {
            var complain_id = $(this).data('id');
            $("#complain_id").val(complain_id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('followup-last-detail') }}',
                data: {'complain_id': complain_id},
                success: function (data) {
                    var obj = JSON.parse(data);
                    $("#client_name").val(obj['client_name']);
                    $("#assign_name").val(obj['assign_name']);
                }
            });
        });

        function deleteComplainDetail(id) {
            var r = confirm("Are You Sure Wan't to Delete Complain?");
            if (r == true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url('complain-delete') }}',
                    data: {'complain_id': id},
                    success: function (data) {
                        location.reload(true);
                    }
                });
            }
        }
    </script>
    <script src="{{asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script>
        // function deleteComplain(id) {
        //     var token = $("meta[name='csrf-token']").attr("content");
        //     var r = confirm("Are You Sure Delete?");
        //     if (r === true) {
        //         $.ajax(
        //             {
        //                 url: "delete-complain/" + id,
        //                 type: 'DELETE',
        //                 data: {
        //                     "id": id,
        //                     "_token": token,
        //                 },
        //                 success: function () {
        //                     location.reload();
        //                 }
        //             });
        //     }
        // }
    </script>
@endpush
