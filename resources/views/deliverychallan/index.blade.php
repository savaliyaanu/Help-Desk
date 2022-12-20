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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Delivery Challan Out</h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                @can('create', App\DeliveryChallanOut::class)
                    <div class="d-flex align-items-center">
                        <!--begin::Button-->
                        <a href="{{route('delivery-out.create')}}"
                           class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
									<span class="svg-icon svg-icon-success svg-icon-lg">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
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
                                        <!--end::Svg Icon-->
									</span>New Delivery Challan</a>
                    </div>
                @endcan
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
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
                        <!--begin: Datatable-->
                        <table id="example" class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th>Complain No</th>
                                <th>Client Name</th>
                                <th>Send Date</th>
                                <th>Supplier Name</th>
                                {{--                                <th>Inward Date</th>--}}
                                <th>Status</th>
                                <th>Product Out Report</th>
                                <th>Product In Report</th>
                                <th>Inward Form</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($delivery_out as $row=>$items)
                                <tr>
                                    @if($items->branch_id == 1)
                                        <td align="center">{{ 'PF-TKT/'.$items->fyear.'/'.$items->complain_no }}</td>
                                    @elseif($items->branch_id == 3)
                                        <td align="center">{{ 'TE-TKT/'.$items->fyear.'/'.$items->complain_no }}</td>
                                    @elseif($items->branch_id == 4)
                                        <td align="center">{{ 'TP-TKT/'.$items->fyear.'/'.$items->complain_no }}</td>
                                    @endif
                                    <td align="center">{{ $items->client_name }}</td>
                                    <td align="center">{{  date('d-m-Y H:i:s',strtotime($items->created_at))}}</td>
                                    <td align="center">{{ $items->supplier_name}}</td>
                                    {{--                                    <td align="center">{{  date('d-m-Y',strtotime($items->inward_date))}}</td>--}}
                                    <td align="center">
                                        @if($items->status == 'Pending')
                                            <span style="width: 137px;">
                                        <span
                                            class="label font-weight-bold label-lg label-light-danger label-inline">{{ $items->status }}</span>
                                        </span>
                                        @else
                                            <span style="width: 137px;">
                                        <span
                                            class="label font-weight-bold label-lg label-light-success label-inline">{{ $items->status }}</span>
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                           title="Delivery Product Out Report"
                                           target="_blank"
                                           href="{{ url('supplier-delivery-challan/'.$items->delivery_challan_out_id.'/out') }}">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                        <td>
                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                           title="Delivery Product IN Report" target="_blank"
                                           href="{{ url('supplier-delivery-challan-in/'.$items->delivery_challan_out_id.'/in') }}">
                                            <i class="flaticon2-printer"></i>
                                        </a>
                                        </td>
                                        <td>
                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Inward Product Form"
                                           href="{{ url('delivery-product-inward/'.$items->delivery_challan_out_id) }}">
                                            <i class="flaticon2-checking"></i>
                                        </a>
                                        </td>
                                        <td>
                                         <?php if (Gate::allows('delivery-challan-policy', 1)) { ?>
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"
                                               href="{{ url('delivery-out/'.$items->delivery_challan_out_id.'/edit') }}">
                                                <i class="flaticon2-pen"></i>
                                            </a>
                                        <?php } ?>
                                        </td>
                                        <td>
                                        <?php if (Gate::allows('delivery-challan-policy', 1)) { ?>
                                            <form method="POST" style="display:inline;" title="Delete"
                                                  action="{{ route('delivery-out.destroy',$items->delivery_challan_out_id)  }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                                </button>
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                            @endforeach
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
@push('styles')
    <link href="{{asset('assets/css/fixedHeader.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush
@push('scripts')
    <script src="{{asset('assets/js/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.fixedHeader.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#example thead');

            var table = $('#example').DataTable({
                orderCellsTop: false,
                fixedHeader: true,
                ordering: false,
                initComplete: function () {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title + '" />');

                            // On every keypress in this input
                            $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                                .off('keyup change')
                                .on('change', function (e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != ''
                                                ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                : '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function (e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        });
    </script>
@endpush
