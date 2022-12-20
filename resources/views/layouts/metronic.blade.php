<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->
<head>
    <base href="">
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Updates and statistics"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="{{asset('metronic/assets/css/font/font.css')}}"/>
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
@stack('styles')
<!--end::Page Vendors Styles-->
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('metronic/assets/plugins/global/plugins.bundle.css?v=7.0.4') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('metronic/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.4') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('metronic/assets/css/style.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('metronic/assets/media/logos/LOGOS MASTER.png') }}"/>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed aside-enabled aside-static page-loading">
<!--begin::Main-->
<!--begin::Header Mobile-->
<div id="kt_header_mobile" class="header-mobile header-mobile-fixed">
    <!--begin::Logo-->
    <a href="{{ url('index.html') }}">
        <img alt="Logo" src="{{ asset('metronic/assets/media/logos/LOGOS MASTER.png') }}"
             class="logo-default max-h-30px"/>
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
        <button class="btn p-0 burger-icon rounded-0 burger-icon-left" id="kt_aside_tablet_and_mobile_toggle">
            <span></span>
        </button>
        <button class="btn btn-hover-text-primary p-0 ml-3" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
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
        </button>
    </div>
    <!--end::Toolbar-->
</div>
<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        <div class="aside aside-left d-flex flex-column flex-row-auto" id="kt_aside">
            <!--begin::Aside Menu-->
            <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                <!--begin::Menu Container-->
                <div id="kt_aside_menu" class="aside-menu min-h-lg-800px" data-menu-vertical="1" data-menu-scroll="1"
                     data-menu-dropdown-timeout="500">
                    <!--begin::Menu Nav-->
                    <ul class="menu-nav">
                        <li class="menu-item {{ request()->is('home*') ? 'menu-item-active' : '' }}"
                            aria-haspopup="true">
                            <a href="{{ url('home') }}" class="menu-link">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24"/>
													<path
                                                        d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                        fill="#000000" fill-rule="nonzero"/>
													<path
                                                        d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                        fill="#000000" opacity="0.3"/>
												</g>
											</svg>
                                            <!--end::Svg Icon-->
										</span>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-submenu {{ (request()->is('support-menu*')||request()->is('transport-master*')||request()->is('product-master*')||request()->is('service-station-detail*')||request()->is('client-master*') ||request()->is('users*') || request()->is('company*') || request()->is('branch*') || request()->is('service-station*'))  ? 'menu-item-open' : '' }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"/>
													<path
                                                        d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                        fill="#000000" opacity="0.3"/>
												</g>
											</svg>
                                            <!--end::Svg Icon-->
										</span>
                                <span class="menu-text ">Master</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link  menu-toggle">
													<span class="menu-text">Master</span>
												</span>
                                    </li>
                                    @if(Auth::user()->role_id == 2)
                                        <li class="menu-item {{ (request()->is('users*')) ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{route('users.index')}}" class="menu-link menu-toggle">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">User Master</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if(Auth::user()->role_id == 1)

                                        <li class="menu-item {{ request()->is('company*') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{route('company.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Company Master</span>
                                            </a>
                                        </li>

                                        <li class="menu-item {{ request()->is('branch*') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{route('branch.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Branch Master</span>
                                            </a>
                                        </li>
{{--                                        <li class="menu-item {{ request()->is('service-station*') ? 'menu-item-active' : '' }}"--}}
{{--                                            aria-haspopup="true">--}}
{{--                                            <a href="{{route('service-station.index')}}" class="menu-link">--}}
{{--                                                <i class="menu-bullet menu-bullet-dot">--}}
{{--                                                    <span></span>--}}
{{--                                                </i>--}}
{{--                                                <span class="menu-text">Service Station Master</span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
                                        <li class="menu-item {{ request()->is('service-station-detail*') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{route('service-station-detail.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Station Detail</span>
                                            </a>
                                        </li>
                                    @endif
                                    {{--                                    <li class="menu-item {{ request()->is('client-master*') ? 'menu-item-active' : '' }}"--}}
                                    {{--                                        aria-haspopup="true">--}}
                                    {{--                                        <a href="{{url('client-master')}}" class="menu-link">--}}
                                    {{--                                            <i class="menu-bullet menu-bullet-dot">--}}
                                    {{--                                                <span></span>--}}
                                    {{--                                            </i>--}}
                                    {{--                                            <span class="menu-text">Client Detail</span>--}}
                                    {{--                                        </a>--}}
                                    {{--                                    </li>--}}

                                    <li class="menu-item {{ request()->is('transport-master*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('transport-master.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Transport Detail</span>
                                        </a>
                                    </li><li class="menu-item {{ request()->is('product-master*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('product-master.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Product Master List</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->is('support-menu*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('support-menu.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">FAQ</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item menu-item-submenu {{ (request()->is('delivery-product-inward*')||request()->is('supplier-pending-report*')||request()->is('delivery-challan-product*')||request()->is('delivery-out*')|| request()->is('expense-product-in-image*')||request()->is('change-spare*')||request()->is('complain-edit*')||request()->is('engine-testing*')||request()->is('other-expense*') || request()->is('party*') || request()->is('callback-reason*') || request()->is('replacement-product*') || request()->is('replacement-in*') || request()->is('advance-replacement*') || request()->is('complain-assign*') || request()->is('complain-detail*') || request()->is('billty*') || request()->is('challan*') || request()->is('invoice*') || request()->is('credit-note*') || request()->is('destroy*') || request()->is('service-expense*') || request()->is('traveling-expense*'))  ? 'menu-item-open' : '' }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                        fill="#000000"/>
												</g>
											</svg>
                                            <!--end::Svg Icon-->
										</span>
                                <span class="menu-text">Replacement</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link Transaction">
													<span class="menu-text">Transaction</span>
												</span>
                                    </li>
                                    <li class="menu-item {{ (request()->is('complain-edit*') || request()->is('complain-detail*') || request()->is('complain-assign*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('complain-detail.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Complains</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ request()->is('billty*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('billty.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Billty</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ (request()->is('change-spare*')||request()->is('engine-testing*')||request()->is('challan*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('challan.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Challan</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ request()->is('invoice*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('invoice.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Invoice</span>
                                        </a>
                                    </li>


                                    <li class="menu-item {{ request()->is('credit-note*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('credit-note.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Credit Note</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ request()->is('destroy*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('destroy.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Destroy</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ (request()->is('expense-product-in-image*') ||request()->is('other-expense*') || request()->is('party*') || request()->is('callback-reason*') || request()->is('service-expense*') || request()->is('traveling-expense*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('service-expense.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Service Expense</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ ( request()->is('replacement-product*') || request()->is('advance-replacement*') || request()->is('replacement-in*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('advance-replacement.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Advance Replacement</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ ( request()->is('delivery-product-inward*')||request()->is('delivery-out*')||request()->is('delivery-challan-product*') ) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{route('delivery-out.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Delivery Challan Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item menu-item-submenu {{ ( request()->is('billty-pending-statement*')||request()->is('challan-dispatch-report*')||request()->is('delivery-product-pending*')||request()->is('complain-master-report*')||request()->is('credit-note-report*')||request()->is('challan-report*')||request()->is('product-wise-report*')||request()->is('mechanic-wise-report*')||request()->is('service-mechanic-wise-report*')) ? 'menu-item-open' : '' }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Communication\Clipboard-list.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path
                                                d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                                fill="#000000" opacity="0.3"/>
                                            <path
                                                d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                                fill="#000000"/>
                                            <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2"
                                                  rx="1"/>
                                            <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2"
                                                  rx="1"/>
                                            <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2"
                                                  rx="1"/>
                                            <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2"
                                                  rx="1"/>
                                            <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2"
                                                  rx="1"/>
                                            <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2"
                                                  rx="1"/>
                                            </g>
                                    </svg><!--end::Svg Icon--></span>
                                <span class="menu-text">Report</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link Transaction">
													<span class="menu-text">Report</span>
												</span>
                                    </li>
                                    <li class="menu-item {{ (request()->is('complain-master-report*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('complain-master-report/create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Complain</span>
                                        </a>
                                    </li>
{{--                                    @if(Auth::user()->user_id == 2)--}}
                                        <li class="menu-item {{ (request()->is('billty-pending-statement*')) ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ url('billty-pending-statement/create') }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Billty</span>
                                            </a>
                                        </li>
{{--                                    @endif--}}
                                    <li class="menu-item {{ (request()->is('challan-report*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('challan-report/create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Challan Pending</span>
                                        </a>
                                    </li>
{{--                                    @if(Auth::user()->user_id == 2)--}}
                                        <li class="menu-item {{ (request()->is('challan-dispatch-report*')) ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ url('challan-dispatch-report/create') }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Challan Dispatch</span>
                                            </a>
                                        </li>
{{--                                    @endif--}}
{{--                                    @if(Auth::user()->user_id == 2)--}}
                                        <li class="menu-item {{ (request()->is('credit-note-report*')) ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('credit-note-report.create')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Credit Note</span>
                                            </a>
                                        </li>
{{--                                    @endif--}}
                                    <li class="menu-item {{ (request()->is('delivery-product-pending*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('delivery-product-pending/create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Delivery Challan</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ (request()->is('product-wise-report*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('product-wise-report/create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Product Wise</span>
                                        </a>
                                    </li>
                                    {{--<li class="menu-item {{ (request()->is('mechanic-wise-report*')) ? 'menu-item-active' : '' }}"--}}
                                        {{--aria-haspopup="true">--}}
                                        {{--<a href="{{ url('mechanic-wise-report/create') }}" class="menu-link">--}}
                                            {{--<i class="menu-bullet menu-bullet-dot">--}}
                                                {{--<span></span>--}}
                                            {{--</i>--}}
                                            {{--<span class="menu-text">Mechanic Wise</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    <li class="menu-item {{ (request()->is('service-mechanic-wise-report*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('service-mechanic-wise-report/create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">OutSide-InSide Mechanic Report</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ (request()->is('supplier-pending-report*')) ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('supplier-pending-report/create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Supplier Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                @yield('menu')
                <!--end::Menu Nav-->
                </div>
                <!--end::Menu Container-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" class="header header-fixed">
                <!--begin::Container-->
                <div class="container d-flex align-items-stretch justify-content-between">
                    <!--begin::Left-->
                    <div class="d-none d-lg-flex align-items-center mr-3">
                        <!--begin::Aside Toggle-->
                        <button class="btn btn-icon aside-toggle ml-n3 mr-10" id="kt_aside_desktop_toggle">
									<span class="svg-icon svg-icon-xxl svg-icon-dark-75">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Text/Align-left.svg-->
										<svg xmlns="http://www.w3.org/2000/svg"
                                             width="24px" height="24px"
                                             viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24"/>
												<rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2"
                                                      rx="1"/>
												<rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2"
                                                      rx="1"/>
												<path
                                                    d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z"
                                                    fill="#000000"/>
											</g>
										</svg>
                                        <!--end::Svg Icon-->
									</span>
                        </button>
                        <!--end::Aside Toggle-->
                        <!--begin::Logo-->
                        <a href="{{ url('home') }}">
                            <img alt="Logo" src="{{ asset('metronic/assets/media/logos/LOGOS MASTER.png') }}"
                                 class="logo-sticky max-h-35px"/>
                        </a>
                        <!--end::Logo-->
                        <!--begin::Desktop Search-->
                        <div class="quick-search quick-search-inline ml-20 w-300px" id="kt_quick_search_inline">
                            <!--begin::Form-->
                            <form method="get" class="quick-search-form">
                                <div class="input-group rounded bg-light">
                                    <div class="input-group-prepend">
												<span class="input-group-text">
													<span class="svg-icon svg-icon-lg">
														<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none"
                                                               fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24"/>
																<path
                                                                    d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																<path
                                                                    d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                                    fill="#000000" fill-rule="nonzero"/>
															</g>
														</svg>
                                                        <!--end::Svg Icon-->
													</span>
												</span>
                                    </div>
                                    <input type="text" class="form-control h-45px" placeholder="Search..."/>
                                    <div class="input-group-append">
												<span class="input-group-text">
													<i class="quick-search-close ki ki-close icon-sm text-muted"></i>
												</span>
                                    </div>
                                </div>
                            </form>
                            <!--begin::Search Toggle-->
                            <div id="kt_quick_search_toggle" data-toggle="dropdown" data-offset="0px,1px">

                            </div>
                            <!--end::Search Toggle-->
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu dropdown-menu-left dropdown-menu-lg dropdown-menu-anim-up">
                                <div class="quick-search-wrapper scroll" data-scroll="true" data-height="350"
                                     data-mobile-height="200"></div>
                            </div>
                            <!--end::Dropdown-->
                        </div> &nbsp; &nbsp; &nbsp; &nbsp;
                        <!--end::Desktop Search-->
                        <a>{{Auth::user()->branch_name}}</a>
                    </div>

                    <div class="topbar">
                        <div class="topbar-item mr-4">
                            <div class="btn btn-icon btn-sm btn-clean btn-text-dark-75" id="kt_quick_user_toggle">
										<span class="svg-icon svg-icon-lg">
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24"/>
													<path
                                                        d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                        fill="#000000" fill-rule="nonzero" opacity="0.3"/>
													<path
                                                        d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                        fill="#000000" fill-rule="nonzero"/>
												</g>
											</svg>
										</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
            <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted font-weight-bold mr-2">{{date('Y')}}©</span>
                        <a href="http://172.16.6.54:83/Help-Desk/public"
                           class="text-dark-75 text-hover-primary">Topland Replacement</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="kt_quick_notifications" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between mb-10">
        <h3 class="font-weight-bold m-0">Notifications
            <small class="text-muted font-size-sm ml-2">1 New</small></h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_notifications_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <div class="offcanvas-content pr-5 mr-n5">
        <!--begin::Nav-->
        <div class="navi navi-icon-circle navi-spacer-x-0">
            <!--begin::Item-->
            <a href="#" class="navi-item">
                <div class="navi-link rounded">
                    <div class="symbol symbol-50 symbol-circle mr-3">
                        <div class="symbol-label">
                            <i class="flaticon-bell text-success icon-lg"></i>
                        </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold font-size-lg">5 new user created</div>
                        <div class="text-muted">Reports based on User</div>
                    </div>
                </div>
            </a>
            <!--end::Item-->
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Content-->
</div>
<!-- end::Notifications Panel-->
<!--begin::Quick Actions Panel-->
<div id="kt_quick_actions" class="offcanvas offcanvas-right p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-10">
        <h3 class="font-weight-bold m-0">Quick Actions
            <small class="text-muted font-size-sm ml-2">finance &amp; reports</small></h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_actions_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
        <div class="row gutter-b">
            <!--begin::Item-->
            <div class="col-6">
                <a href="#" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
							<span class="svg-icon svg-icon-3x svg-icon-primary m-0">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Euro.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path
                                            d="M4.3618034,10.2763932 L4.8618034,9.2763932 C4.94649941,9.10700119 5.11963097,9 5.30901699,9 L15.190983,9 C15.4671254,9 15.690983,9.22385763 15.690983,9.5 C15.690983,9.57762255 15.6729105,9.65417908 15.6381966,9.7236068 L15.1381966,10.7236068 C15.0535006,10.8929988 14.880369,11 14.690983,11 L4.80901699,11 C4.53287462,11 4.30901699,10.7761424 4.30901699,10.5 C4.30901699,10.4223775 4.32708954,10.3458209 4.3618034,10.2763932 Z M14.6381966,13.7236068 L14.1381966,14.7236068 C14.0535006,14.8929988 13.880369,15 13.690983,15 L4.80901699,15 C4.53287462,15 4.30901699,14.7761424 4.30901699,14.5 C4.30901699,14.4223775 4.32708954,14.3458209 4.3618034,14.2763932 L4.8618034,13.2763932 C4.94649941,13.1070012 5.11963097,13 5.30901699,13 L14.190983,13 C14.4671254,13 14.690983,13.2238576 14.690983,13.5 C14.690983,13.5776225 14.6729105,13.6541791 14.6381966,13.7236068 Z"
                                            fill="#000000" opacity="0.3"/>
										<path
                                            d="M17.369,7.618 C16.976998,7.08599734 16.4660031,6.69750122 15.836,6.4525 C15.2059968,6.20749878 14.590003,6.085 13.988,6.085 C13.2179962,6.085 12.5180032,6.2249986 11.888,6.505 C11.2579969,6.7850014 10.7155023,7.16999755 10.2605,7.66 C9.80549773,8.15000245 9.45550123,8.72399671 9.2105,9.382 C8.96549878,10.0400033 8.843,10.7539961 8.843,11.524 C8.843,12.3360041 8.96199881,13.0779966 9.2,13.75 C9.43800119,14.4220034 9.7774978,14.9994976 10.2185,15.4825 C10.6595022,15.9655024 11.1879969,16.3399987 11.804,16.606 C12.4200031,16.8720013 13.1129962,17.005 13.883,17.005 C14.681004,17.005 15.3879969,16.8475016 16.004,16.5325 C16.6200031,16.2174984 17.1169981,15.8010026 17.495,15.283 L19.616,16.774 C18.9579967,17.6000041 18.1530048,18.2404977 17.201,18.6955 C16.2489952,19.1505023 15.1360064,19.378 13.862,19.378 C12.6999942,19.378 11.6325049,19.1855019 10.6595,18.8005 C9.68649514,18.4154981 8.8500035,17.8765035 8.15,17.1835 C7.4499965,16.4904965 6.90400196,15.6645048 6.512,14.7055 C6.11999804,13.7464952 5.924,12.6860058 5.924,11.524 C5.924,10.333994 6.13049794,9.25950479 6.5435,8.3005 C6.95650207,7.34149521 7.5234964,6.52600336 8.2445,5.854 C8.96550361,5.18199664 9.8159951,4.66400182 10.796,4.3 C11.7760049,3.93599818 12.8399943,3.754 13.988,3.754 C14.4640024,3.754 14.9609974,3.79949954 15.479,3.8905 C15.9970026,3.98150045 16.4939976,4.12149906 16.97,4.3105 C17.4460024,4.49950095 17.8939979,4.7339986 18.314,5.014 C18.7340021,5.2940014 19.0909985,5.62999804 19.385,6.022 L17.369,7.618 Z"
                                            fill="#000000"/>
									</g>
								</svg>
                                <!--end::Svg Icon-->
							</span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">Accounting</span>
                </a>
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="col-6">
                <a href="#" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
							<span class="svg-icon svg-icon-3x svg-icon-primary m-0">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-attachment.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path
                                            d="M14.8571499,13 C14.9499122,12.7223297 15,12.4263059 15,12.1190476 L15,6.88095238 C15,5.28984632 13.6568542,4 12,4 L11.7272727,4 C10.2210416,4 9,5.17258756 9,6.61904762 L10.0909091,6.61904762 C10.0909091,5.75117158 10.823534,5.04761905 11.7272727,5.04761905 L12,5.04761905 C13.0543618,5.04761905 13.9090909,5.86843034 13.9090909,6.88095238 L13.9090909,12.1190476 C13.9090909,12.4383379 13.8240964,12.7385644 13.6746497,13 L10.3253503,13 C10.1759036,12.7385644 10.0909091,12.4383379 10.0909091,12.1190476 L10.0909091,9.5 C10.0909091,9.06606198 10.4572216,8.71428571 10.9090909,8.71428571 C11.3609602,8.71428571 11.7272727,9.06606198 11.7272727,9.5 L11.7272727,11.3333333 L12.8181818,11.3333333 L12.8181818,9.5 C12.8181818,8.48747796 11.9634527,7.66666667 10.9090909,7.66666667 C9.85472911,7.66666667 9,8.48747796 9,9.5 L9,12.1190476 C9,12.4263059 9.0500878,12.7223297 9.14285008,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L14.8571499,13 Z"
                                            fill="#000000" opacity="0.3"/>
										<path
                                            d="M9,10.3333333 L9,12.1190476 C9,13.7101537 10.3431458,15 12,15 C13.6568542,15 15,13.7101537 15,12.1190476 L15,10.3333333 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9,10.3333333 Z M10.0909091,11.1212121 L12,12.5 L13.9090909,11.1212121 L13.9090909,12.1190476 C13.9090909,13.1315697 13.0543618,13.952381 12,13.952381 C10.9456382,13.952381 10.0909091,13.1315697 10.0909091,12.1190476 L10.0909091,11.1212121 Z"
                                            fill="#000000"/>
									</g>
								</svg>
                                <!--end::Svg Icon-->
							</span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">Members</span>
                </a>
            </div>
            <!--end::Item-->
        </div>
        <div class="row gutter-b">
            <!--begin::Item-->
            <div class="col-6">
                <a href="#" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
							<span class="svg-icon svg-icon-3x svg-icon-primary m-0">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Box2.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path
                                            d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z"
                                            fill="#000000"/>
										<path
                                            d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z"
                                            fill="#000000" opacity="0.3"/>
									</g>
								</svg>
                                <!--end::Svg Icon-->
							</span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">Projects</span>
                </a>
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="col-6">
                <a href="#" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
							<span class="svg-icon svg-icon-3x svg-icon-primary m-0">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24"/>
										<path
                                            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
										<path
                                            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                            fill="#000000" fill-rule="nonzero"/>
									</g>
								</svg>
                                <!--end::Svg Icon-->
							</span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">Customers</span>
                </a>
            </div>
            <!--end::Item-->
        </div>
        <div class="row gutter-b">
            <!--begin::Item-->
            <div class="col-6">
                <a href="#" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
							<span class="svg-icon svg-icon-3x svg-icon-primary m-0">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5"/>
										<rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5"/>
										<path
                                            d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z"
                                            fill="#000000" fill-rule="nonzero"/>
										<rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5"/>
									</g>
								</svg>
                                <!--end::Svg Icon-->
							</span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">Email</span>
                </a>
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="col-6">
                <a href="#" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
							<span class="svg-icon svg-icon-3x svg-icon-primary m-0">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Color-profile.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path
                                            d="M12,10.9996338 C12.8356605,10.3719448 13.8743941,10 15,10 C17.7614237,10 20,12.2385763 20,15 C20,17.7614237 17.7614237,20 15,20 C13.8743941,20 12.8356605,19.6280552 12,19.0003662 C11.1643395,19.6280552 10.1256059,20 9,20 C6.23857625,20 4,17.7614237 4,15 C4,12.2385763 6.23857625,10 9,10 C10.1256059,10 11.1643395,10.3719448 12,10.9996338 Z M13.3336047,12.504354 C13.757474,13.2388026 14,14.0910788 14,15 C14,15.9088933 13.7574889,16.761145 13.3336438,17.4955783 C13.8188886,17.8206693 14.3938466,18 15,18 C16.6568542,18 18,16.6568542 18,15 C18,13.3431458 16.6568542,12 15,12 C14.3930587,12 13.8175971,12.18044 13.3336047,12.504354 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
										<circle fill="#000000" cx="12" cy="9" r="5"/>
									</g>
								</svg>
                                <!--end::Svg Icon-->
							</span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">Settings</span>
                </a>
            </div>
            <!--end::Item-->
        </div>
        <div class="row">
            <!--begin::Item-->
            <div class="col-6">
                <a href="#" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
							<span class="svg-icon svg-icon-3x svg-icon-primary m-0">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Euro.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path
                                            d="M4.3618034,10.2763932 L4.8618034,9.2763932 C4.94649941,9.10700119 5.11963097,9 5.30901699,9 L15.190983,9 C15.4671254,9 15.690983,9.22385763 15.690983,9.5 C15.690983,9.57762255 15.6729105,9.65417908 15.6381966,9.7236068 L15.1381966,10.7236068 C15.0535006,10.8929988 14.880369,11 14.690983,11 L4.80901699,11 C4.53287462,11 4.30901699,10.7761424 4.30901699,10.5 C4.30901699,10.4223775 4.32708954,10.3458209 4.3618034,10.2763932 Z M14.6381966,13.7236068 L14.1381966,14.7236068 C14.0535006,14.8929988 13.880369,15 13.690983,15 L4.80901699,15 C4.53287462,15 4.30901699,14.7761424 4.30901699,14.5 C4.30901699,14.4223775 4.32708954,14.3458209 4.3618034,14.2763932 L4.8618034,13.2763932 C4.94649941,13.1070012 5.11963097,13 5.30901699,13 L14.190983,13 C14.4671254,13 14.690983,13.2238576 14.690983,13.5 C14.690983,13.5776225 14.6729105,13.6541791 14.6381966,13.7236068 Z"
                                            fill="#000000" opacity="0.3"/>
										<path
                                            d="M17.369,7.618 C16.976998,7.08599734 16.4660031,6.69750122 15.836,6.4525 C15.2059968,6.20749878 14.590003,6.085 13.988,6.085 C13.2179962,6.085 12.5180032,6.2249986 11.888,6.505 C11.2579969,6.7850014 10.7155023,7.16999755 10.2605,7.66 C9.80549773,8.15000245 9.45550123,8.72399671 9.2105,9.382 C8.96549878,10.0400033 8.843,10.7539961 8.843,11.524 C8.843,12.3360041 8.96199881,13.0779966 9.2,13.75 C9.43800119,14.4220034 9.7774978,14.9994976 10.2185,15.4825 C10.6595022,15.9655024 11.1879969,16.3399987 11.804,16.606 C12.4200031,16.8720013 13.1129962,17.005 13.883,17.005 C14.681004,17.005 15.3879969,16.8475016 16.004,16.5325 C16.6200031,16.2174984 17.1169981,15.8010026 17.495,15.283 L19.616,16.774 C18.9579967,17.6000041 18.1530048,18.2404977 17.201,18.6955 C16.2489952,19.1505023 15.1360064,19.378 13.862,19.378 C12.6999942,19.378 11.6325049,19.1855019 10.6595,18.8005 C9.68649514,18.4154981 8.8500035,17.8765035 8.15,17.1835 C7.4499965,16.4904965 6.90400196,15.6645048 6.512,14.7055 C6.11999804,13.7464952 5.924,12.6860058 5.924,11.524 C5.924,10.333994 6.13049794,9.25950479 6.5435,8.3005 C6.95650207,7.34149521 7.5234964,6.52600336 8.2445,5.854 C8.96550361,5.18199664 9.8159951,4.66400182 10.796,4.3 C11.7760049,3.93599818 12.8399943,3.754 13.988,3.754 C14.4640024,3.754 14.9609974,3.79949954 15.479,3.8905 C15.9970026,3.98150045 16.4939976,4.12149906 16.97,4.3105 C17.4460024,4.49950095 17.8939979,4.7339986 18.314,5.014 C18.7340021,5.2940014 19.0909985,5.62999804 19.385,6.022 L17.369,7.618 Z"
                                            fill="#000000"/>
									</g>
								</svg>
                                <!--end::Svg Icon-->
							</span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">Orders</span>
                </a>
            </div>
            <!--end::Item-->
        </div>
    </div>
    <!--end::Content-->
</div>
<!--end::Quick Actions Panel-->
<!-- begin::User Panel-->
<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-content pr-5 mr-n5">
        <!--begin::Header-->
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label"
                     style="background-image:url('{{ asset('metronic/assets/media/users/300_21.jpg') }}')"></div>
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#"
                   class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ Auth::user()->name }}</a>
                <div class="text-muted mt-1"></div>
                <div class="navi mt-2">
                    <a href="#" class="navi-item">
								<span class="navi-link p-0 pb-2">
									<span class="navi-icon mr-1">
										<span class="svg-icon svg-icon-lg svg-icon-primary">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                                        fill="#000000"/>
													<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"/>
												</g>
											</svg>
                                            <!--end::Svg Icon-->
										</span>
									</span>
									<span class="navi-text text-muted text-hover-primary">{{Auth::user()->email}}</span>
								</span>
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                       class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end::Content-->
</div>
<ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">
    <li class="nav-item mb-2" data-toggle="tooltip" title="Help" data-placement="left">
        <a class="btn btn-sm btn-icon btn-bg-light btn-icon-primary btn-hover-primary" href="{{ url('faq') }}"
           target="_blank">
            <i class="flaticon-support"></i>
        </a>
    </li>
</ul>
<!--end::Sticky Toolbar-->

<script>var HOST_URL = "{{ url('/') }}";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#6993FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1E9FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('metronic/assets/plugins/global/plugins.bundle.js?v=7.0.4')}}"></script>
<script src="{{ asset('metronic/assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.4')}}"></script>
<script src="{{ asset('metronic/assets/js/scripts.bundle.js?v=7.0.4')}}"></script>
{{--<script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/data-ajax.js?v=7.0.4')}}"></script>--}}
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
@stack('scripts')
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
