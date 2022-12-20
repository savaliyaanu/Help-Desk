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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Expense Detail</h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                @can('create', App\ReplacementExpense::class)
                    <div class="d-flex align-items-center">
                        <!--begin::Button-->
                        <a href="{{route('service-expense.create')}}"
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
									</span>New Expense</a>
                    </div>
                @endcan
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
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

                        <table id="example" class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th>Report No</th>
                                <th>Complain No</th>
                                <th>Date</th>
                                <th>Mechanic Name</th>
                                <th>State Name</th>
                                <th>City Name</th>
                                <th>Party Name</th>
                                <th>Status</th>
                                <th>Inspection Report</th>
                                <th>Callback Reason Form</th>
                                <th>Expense Product Form</th>
                                <th>Expense Report</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Spare Report</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($expense))
                                @php $i=1 @endphp
                                @foreach($expense as $key=>$items)
                                    <tr>
                                                                                <td>{{ $items->expense_no }}</td>
                                        @if($items->branch_id == 1)
                                            <td align="center">{{ 'PF-TKT/'.$items->fyear.'/'.$items->complain_no }}</td>
                                        @elseif($items->branch_id == 3)
                                            <td align="center">{{ 'TE-TKT/'.$items->fyear.'/'.$items->complain_no }}</td>
                                        @elseif($items->branch_id == 4)
                                            <td align="center">{{ 'TP-TKT/'.$items->fyear.'/'.$items->complain_no }}</td>
                                        @endif
                                        <td align="center">{{ date('d-m-Y',strtotime($items->traveling_from)) }}</td>
                                        <td>{{ $items->mechanic_name}}</td>
                                        <td>{{$items->state_name}}</td>
                                        <td>{{$items->city_name}}</td>
                                        <td>{{$items->party_name}}</td>
                                        <td>{{$items->status}}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"
                                               title="Inspection Report"
                                               href="{{url('expense-spare-report/'.$items->expense_id)}}">
                                                <i class="flaticon2-printer"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                               title="Callback Reason Form"
                                               href="{{url('callback-reason/'.$items->expense_id)}}">
                                                <i class="flaticon-doc"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                               title="Service Expense Product Form"
                                               href="{{url('expense-product-in-image/'.$items->expense_id)}}">
                                                <i class="flaticon2-checking"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                               title="Service Expense Report Pdf" target="_blank"
                                               href="{{url('service-report/'.$items->expense_id)}}">
                                                <i class="far fa-file-pdf"></i>
                                            </a>
                                        </td>
                                        <td>

                                                <?php if (Gate::allows('service-expense-policy', 1)) { ?>
                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"
                                               href="{{ url('service-expense/'.$items->expense_id.'/edit') }}">
                                                <i class="flaticon2-pen"></i>
                                            </a>
                                            <?php } ?> </td>
                                        <td>

                                                <?php if (Gate::allows('service-expense-policy', 1)) { ?>
                                            <form method="POST" style="display:inline;" title="Delete"
                                                  action="{{ route('service-expense.destroy',$items->expense_id)  }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit"
                                                        class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                                </button>
                                            </form>
                                            <?php } ?>
                                        </td>
                                        <td>

                                            <a class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                               title="Spare Report Pdf" target="_blank"
                                               href="{{url('service-spare-report/'.$items->expense_id)}}">
                                                <i class="fas fa-portrait"></i>
                                            </a>
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
{{--    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>--}}
@endpush
