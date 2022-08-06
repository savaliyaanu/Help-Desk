@extends('layouts.app')

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Dashboard</h3>

                </div>
            </div>
        </div>

        <!-- end:: Content Head -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Dashboard 1-->

            <!--Begin::Row-->

            <!--End::Row-->

            <!--Begin::Row-->
            <div class="row">
                <div class="col-xl-4 col-lg-4 order-lg-2 order-xl-1">

                    <!--begin:: Widgets/Daily Sales-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header kt-margin-b-30">
                                <h3 class="kt-widget14__title">
                                    Daily Sales
                                </h3>
                                <span class="kt-widget14__desc">
													Check out each collumn for more details
												</span>
                            </div>
                            <div class="kt-widget14__chart" style="height:120px;">
                                <canvas id="kt_chart_daily_sales"></canvas>
                            </div>
                        </div>
                    </div>

                    <!--end:: Widgets/Daily Sales-->
                </div>
                <div class="col-xl-4 col-lg-4 order-lg-2 order-xl-1">

                    <!--begin:: Widgets/Revenue Change-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Revenue Change
                                </h3>
                                <span class="kt-widget14__desc">
													Revenue change breakdown by cities
												</span>
                            </div>
                            <div class="kt-widget14__content">
                                <div class="kt-widget14__chart">
                                    <div id="kt_chart_revenue_change" style="height: 150px; width: 150px;"></div>
                                </div>
                                <div class="kt-widget14__legends">
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-success"></span>
                                        <span class="kt-widget14__stats">+10% New York</span>
                                    </div>
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-warning"></span>
                                        <span class="kt-widget14__stats">-7% London</span>
                                    </div>
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-brand"></span>
                                        <span class="kt-widget14__stats">+20% California</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end:: Widgets/Revenue Change-->
                </div>
            </div>

            <!--End::Row-->

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>
@endsection
