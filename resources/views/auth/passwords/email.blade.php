<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Login page example"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{asset('metronic/assets/css/pages/login/classic/login-3.css?v=7.0.4')}}" rel="stylesheet" type="text/css"/>
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{asset('metronic/assets/plugins/global/plugins.bundle.css?v=7.0.4')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('metronic/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.4')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('metronic/assets/css/style.bundle.css?v=7.0.4')}}" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{asset('metronic/assets/media/logos/LOGOS MASTER.png')}}" />
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 login-signin-on d-flex flex-row-fluid" id="kt_login">
            <div class="login-form text-center text-white p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="text-center pt-2">
                    <a href="#">
                        <img src="{{asset('metronic/assets/media/logos/LOGOS MASTER.png')}}" class="max-h-100px" />
                    </a>
                </div>
                &nbsp; &nbsp; &nbsp; &nbsp;
                <!--end::Login Header-->
                <!--begin::Login Sign in form-->
                <div class="">
                    <div class="mb-12">
                        <h3>{{ __('Reset Password ?') }}</h3>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="k-login-v2__body-form k-form k-login-v2__body-form--border"
                          action="{{ route('password.email') }}" autocomplete="off" method="post">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email" placeholder="Email"
                                   class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8  @error('email') is-invalid @enderror" name="email"
                                   autocomplete="off"
                                   value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="k-login-v2__body-action k-login-v2__body-action--brand">
                            <button type="submit"
                                    class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3 m-2">{{ __('Send Password Reset Link') }}</button>
                        </div>

                        <!--end::Action-->
                    </form>
                </div>
                <!--end::Login Sign in form-->
            </div>
        <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"
             style="background-image: url({{ asset('metronic/assets/media/svg/illustrations/side_logo.jpeg') }});"></div>

    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
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
<script src="{{asset('metronic/assets/plugins/global/plugins.bundle.js?v=7.0.4')}}"></script>
<script src="{{asset('metronic/assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.4')}}"></script>
<script src="{{asset('metronic/assets/js/scripts.bundle.js?v=7.0.4')}}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{asset('metronic/assets/js/pages/custom/login/login-general.js?v=7.0.4')}}"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
