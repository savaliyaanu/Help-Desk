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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Challan Detail</h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                @can('create', App\Challan::class)
                    <div class="d-flex align-items-center">
                        <!--begin::Button-->
                        <a href="{{route('challan.create')}}"
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
									</span>New Challan</a>

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
                <!--begin::Notice-->
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
                <!--end::Notice-->
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin: Search Form-->
                        <!--begin::Search Form-->
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
                        <!--end::Search Form-->
                        <!--end: Search Form-->
                        <!--begin: Datatable-->
                        <table class="datatable datatable-bordered datatable-head-custom" id="kt_datatable">
                            <thead>
                            <tr>
                                <th>Ref No</th>
                                <th>Challan No</th>
                                <th>Challan Date</th>
                                <th>Client Name</th>
                                <th>City</th>
                                <th>District</th>
                                <th>State</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($challan as $row=>$items)
                                <tr>
                                    @if($items->branch_id == 1)
                                        <td align="center">{{ 'PF-TKT/'.$items->fyear.'/'.$items->complain_no }}</td>
                                    @elseif($items->branch_id == 3)
                                        <td align="center">{{ 'TE-TKT/'.$items->fyear.'/'.$items->complain_no }}</td>
                                    @elseif($items->branch_id == 4)
                                        <td align="center">{{ 'TP-TKT/'.$items->fyear.'/'.$items->complain_no }}</td>
                                    @endif
                                    @if($items->branch_id == 1)
                                        <td align="center">{{ 'PF-CH/'.$items->fyear.'/'.$items->challan_no }}</td>
                                    @elseif($items->branch_id == 3)
                                        <td align="center">{{ 'TE-CH/'.$items->fyear.'/'.$items->challan_no }}</td>
                                    @elseif($items->branch_id == 4)
                                        <td align="center">{{ 'TP-CH/'.$items->fyear.'/'.$items->challan_no }}</td>
                                    @endif
                                    <td align="center">{{ date('d-m-Y',strtotime($items->challan_date)) }}</td>
                                    <?php if($items->change_bill_address == 'Y'){ ?>
                                    <td>{{$items->billing_name }}</td>
                                    <td>{{$items->city_name }}</td>
                                    <td>{{$items->district_name }}</td>
                                    <td>{{$items->state_name }}</td>
                                    <?php }else{ ?>
                                    <td>{{$items->client_name }}</td>
                                    <td>{{$items->city_name }}</td>
                                    <td>{{$items->district_name }}</td>
                                    <td>{{$items->state_name }}</td>
                                    <?php } ?>
                                    <td>
                                        <a class=""
                                           onclick="updateChallanStatus()"
                                           href="{{url('update-status/'.$items->challan_id)}}">
                                            @if($items->current_status == 'Repairing')
                                                <button type="button"
                                                        class="btn btn-warning font-weight-bold btn-pill">{{$items->current_status}}</button>
                                                &nbsp;
                                            @else
                                                <button type="button"
                                                        class="btn btn-success font-weight-bold btn-pill">{{$items->current_status}}</button>
                                                &nbsp;
                                            @endif
                                        </a></td>

                                    <td>
                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md " target="_blank"
                                           title="Add Product"
                                           href="{{url('challan-product-create/'.$items->challan_id)}}">
                                            <i class="fab fa-product-hunt"></i>
                                        </a>

                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"
                                           title="Add Accessories"
                                           href="{{url('challan-accessories-create/'.$items->challan_id)}}">
                                            <i class="fab fa-adn"></i>
                                        </a>

                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"
                                           title="Add Panel"
                                           href="{{url('challan-panel-create/'.$items->challan_id)}}">
                                            <i class="fas fa-solar-panel"></i>
                                        </a>

                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"
                                           title="Change Spare"
                                           href="{{url('change-spare-create/'.$items->challan_id)}}">
                                            <i class="fab fa-stack-exchange"></i>
                                        </a>

                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Testing Report"
                                           target="_blank"
                                           href="{{url('engine-testing-report/'.$items->challan_id)}}">
                                            <i class="fas fa-print"></i>
                                        </a>

                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"
                                           title="Inspection Report"
                                           href="{{url('challan-inspection-report/'.$items->challan_id)}}">
                                            <i class="flaticon2-printer"></i>
                                        </a>

                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"
                                           title="Challan Pdf"
                                           href="{{url('print-fpdf/'.$items->challan_id)}}">
                                            <i class="far fa-file-pdf"></i>
                                        </a>

                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"
                                           title="Change Spare Pdf"
                                           href="{{url('change-spare-pdf/'.$items->challan_id)}}">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>

                                        {{--                                        @can('update',$items)--}}
                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Edit"
                                           href="{{ url('challan/'.$items->challan_id.'/edit') }}">
                                            <i class="flaticon2-pen"></i>
                                        </a>

                                        {{--                                        @endcan--}}
                                        {{--                                        @can('delete',$items)--}}
                                        <form method="POST" style="display:inline;" title="Delete"
                                              action="{{ route('challan.destroy',$items->challan_id)  }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                <i class="flaticon2-rubbish-bin-delete-button"></i>
                                            </button>
                                        </form>
                                        {{--                                        @endcan--}}
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
@push('scripts')

    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
@endpush
