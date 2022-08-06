@extends('layouts.metronic')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
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
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline mr-5">
                        <!--begin::Page Title-->
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Question Solution <span
                                class="text-danger">*</span></h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>

            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid align-middle">
            <!--begin::Container-->
            <div class="container align-center">
                <div class="row">
                    <div class="col-md-6">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b example example-compact align-center">
                            <div class="card-header">
                                <h3 class="card-title">Support FAQ</h3>
                            </div>
                            <!--begin::Form-->
                            <form class="kt-form kt-form--label-right"
                                  action="{{($action=='INSERT')? url('case-solution'):route('case-solution.update',$case_solution['case_id']) }}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
{{--                                    <input type="hidden" name="faq_id" value="{{ $faq_id }}">--}}
                                    <div class="form-group ">
                                        <label>Case <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Case"
                                               name="case"
                                               value="{{ ((!empty($case_solution->case)) ?$case_solution->case :old('case'))}}"/>
                                    </div>
                                    <div class="form-group ">
                                        <label>Solution <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter case"
                                               name="solution"
                                               value="{{ ((!empty($case_solution->solution)) ?$case_solution->solution :old('solution')) }}"/>
                                    </div>
                                    <div class="form-group ">
                                        <label>Parts <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Parts"
                                               name="parts"
                                               value="{{ ((!empty($case_solution->parts)) ?$case_solution->parts :old('parts')) }}"/>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top mt-5 pt-10 card-footer">
                                    <div class="mr-2">
                                        <a href="{{ url('support-menu/create') }}"
                                           class="btn btn-light-primary font-weight-bold mr-2">
                                            <i class="la la-arrow-left"></i>
                                            <span class="kt-hidden-mobile">Previous</span>
                                        </a>
                                    </div>
                                    <div>
                                        @if($action=='INSERT')
                                            <button type="submit"
                                                    class="btn btn-success">
                                               Save
                                            </button>
                                        @else
                                            <button type="submit"
                                                    class="btn btn-warning">
                                                Update
                                            </button>
                                        @endif
                                        <a href="{{url('support-menu')}}"
                                           class="btn btn-danger">
                                            Finish
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">FAQ Solution</h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
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
                                <th>Faq No.</th>
                                <th>Case</th>
                                <th>Solution</th>
                                <th>Parts</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($case_solution as $row=>$items)
                                <tr>
                                    <td align="center">{{ $items->faq_id}}</td>
                                    <td >{{ $items->case}}</td>
                                    <td>{{ $items->solution}}</td>
                                    <td>{{ $items->parts}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"
                                           href="{{ url('/case-solution/'.$items->case_id.'/edit') }}">
                                            <i class="flaticon2-pen"></i>
                                        </a>
                                        <form method="POST" style="display:inline;" title="Delete"
                                              action="{{ route('case-solution.destroy',$items->case_id)  }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                <i class="flaticon2-rubbish-bin-delete-button"></i>
                                            </button>
                                        </form>
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
