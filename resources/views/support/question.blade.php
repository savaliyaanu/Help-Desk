@extends('layouts.metronic')
@section('content')
    <div class="content pt-0 d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <!--begin::Hero-->
        <div class="d-flex flex-row-fluid bgi-size-cover bgi-position-top"
             style="background-image: url('assets/media/bg/bg-9.jpg')">
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
                <div class="d-flex justify-content-between align-items-center pt-25 pb-35">
                    <h3 class="font-weight-bolder text-dark mb-0">Frequently Asked Questions</h3>
                    <div class="d-flex">
                        <a href="#" class="font-size-h4 font-weight-bold">Help Center</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Hero-->
        <!--begin::Section-->
        <div class="container mt-n15">
            <!--begin::Card-->
            <div class="card mb-8">
                <!--begin::Body-->
                <div class="card-body p-10">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-lg-3">
                            <!--begin::Navigation-->
                            <ul class="navi navi-link-rounded navi-accent navi-hover navi-active nav flex-column mb-8 mb-lg-0"
                                role="tablist">
                                <!--begin::Nav Item-->
                                @foreach($categories as $key=>$value)
                                    <li class="navi-item mb-2">
                                        <a class="navi-link {{ $value->category_id==$selectedCategory?'active':'' }}"
                                           href="{{ url('faq/'.$value->category_id) }}">
                                            <span
                                                class="navi-text text-dark-50 font-size-h5 font-weight-bold">{{$value->category_name}}</span>
                                        </a>
                                    </li>
                            @endforeach
                            <!--end::Nav Item-->
                                <!--begin::Nav Item-->

                                <!--end::Nav Item-->
                            </ul>
                            <!--end::Navigation-->
                        </div>
                        <div class="col-lg-9">
                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Accordion-->
                                <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle"
                                     id="faq">
                                    <!--begin::Item-->
                                    @php $counter = 0; @endphp
                                    @foreach($case as $key=>$value)

                                        <div class="card">
                                            <div class="card-header" id="faqHeading1">
                                                <a class="card-title text-dark collapsed" data-toggle="collapse"
                                                   href="#faq{{$counter}}"
                                                   aria-expanded="true" aria-controls="faq1" role="button">
																<span class="svg-icon svg-icon-primary">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-right.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<polygon points="0 0 24 0 24 24 0 24"/>
																			<path
                                                                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                                fill="#000000" fill-rule="nonzero"/>
																			<path
                                                                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3"
                                                                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)"/>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
                                                    <div class="card-label text-dark pl-4">{{$value->questions}}</div>
                                                </a>
                                            </div>
                                            <div id="faq{{$counter}}" class="collapse">
                                                <table class="table table-separate table-head-custom table-checkable"
                                                       id="kt_datatable">
                                                    <thead>
                                                    <tr>
                                                        <th style="text-align: left"> Case</th>
                                                        <th style="text-align: left"> Solution</th>
                                                        <th style="text-align: left"> Parts</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($value->getCase as $row=>$items)
                                                        <tr>
                                                            <td>{{ $items->case}}</td>
                                                            <td>{{ $items->solution}}</td>
                                                            <td>{{ $items->parts}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    {{--                                        <div id="faq{{$counter}}" class="collapse show"--}}
                                    {{--                                             aria-labelledby="faqHeading1"--}}
                                    {{--                                             data-parent="#faq">--}}
                                    {{--                                            <div--}}
                                    {{--                                                class="card-body text-dark-50 font-size-lg pl-12">{{$value->answer}}--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    @php $counter++; @endphp
                                @endforeach
                                <!--end::Item-->
                                </div>
                                <!--end::Accordion-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Item-->
        </div>
        <!--end::Section-->
        <!--begin::Section-->
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!--begin::Card-->
                    <a href="#" class="card card-custom wave wave-animate-slow bg-grey-100 mb-8 mb-lg-0">
                        <!--begin::Card Body-->
                        <div class="card-body">
                            <div class="d-flex align-items-center p-6">
                                <!--begin::Icon-->
                                <div class="mr-6">
													<span class="svg-icon svg-icon-4x svg-icon-primary">
														<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none"
                                                               fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24"/>
																<path
                                                                    d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                                    fill="#000000" opacity="0.3"/>
																<path
                                                                    d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                                    fill="#000000"/>
															</g>
														</svg>
                                                        <!--end::Svg Icon-->
													</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Content-->
                                <div class="d-flex flex-column">
                                    <h3 class="text-dark h3 mb-3">Get Started</h3>
                                    <div class="text-dark-50">Base FAQ Questions</div>
                                </div>
                                <!--end::Content-->
                            </div>
                        </div>
                        <!--end::Card Body-->
                    </a>
                    <!--end::Card-->
                </div>
                <div class="col-lg-4">
                    <!--begin::Card-->
                    <a href="#" class="card card-custom wave wave-animate bg-grey-100 mb-8 mb-lg-0">
                        <!--begin::Card Body-->
                        <div class="card-body">
                            <div class="d-flex align-items-center p-6">
                                <!--begin::Icon-->
                                <div class="mr-6">
													<span class="svg-icon svg-icon-4x svg-icon-primary">
														<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Clipboard-check.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none"
                                                               fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24"/>
																<path
                                                                    d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                                                    fill="#000000" opacity="0.3"/>
																<path
                                                                    d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z"
                                                                    fill="#000000"/>
																<path
                                                                    d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                                                    fill="#000000"/>
															</g>
														</svg>
                                                        <!--end::Svg Icon-->
													</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Content-->
                                <div class="d-flex flex-column">
                                    <h3 class="text-dark h3 mb-3">Tutorials</h3>
                                    <div class="text-dark-50">Books &amp; Articles</div>
                                </div>
                                <!--end::Content-->
                            </div>
                        </div>
                        <!--end::Card Body-->
                    </a>
                    <!--end::Card-->
                </div>
                <div class="col-lg-4">
                    <!--begin::Card-->
                    <a href="#" class="card card-custom wave wave-animate-fast bg-grey-100">
                        <!--begin::Card Body-->
                        <div class="card-body">
                            <div class="d-flex align-items-center p-6">
                                <!--begin::Icon-->
                                <div class="mr-6">
													<span class="svg-icon svg-icon-4x svg-icon-primary">
														<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none"
                                                               fill-rule="evenodd">
																<polygon points="0 0 24 0 24 24 0 24"/>
																<path
                                                                    d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																<path
                                                                    d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                                    fill="#000000" fill-rule="nonzero"/>
															</g>
														</svg>
                                                        <!--end::Svg Icon-->
													</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Content-->
                                <div class="d-flex flex-column">
                                    <h3 class="text-dark h3 mb-3">User Guide</h3>
                                    <div class="text-dark-50">Complete Knowledgebase</div>
                                </div>
                                <!--end::Content-->
                            </div>
                        </div>
                        <!--end::Card Body-->
                    </a>
                    <!--end::Card-->
                </div>
            </div>
        </div>
        <!--end::Section-->
        <!--end::Entry-->
    </div>
@endsection
