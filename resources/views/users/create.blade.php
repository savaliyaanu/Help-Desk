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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">User Master</h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <!--begin::Form-->
                            <form class="form" id="kt_form_1" method="post"
                                  action="{{($action=='INSERT')?url('users'):route('users.update',$users->user_id) }}">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 ">Company Name
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-5 ">
                                            <div class="input-group">
                                                <select style="width: 100%" id="company_id"
                                                        class="form-control kt_select2_5 {{ $errors->has('company_id') ? ' is-invalid' : '' }}"
                                                        name="company_id" required onchange="getBranch(this.value)"
                                                        title="Please Select Company Name">
                                                    <option value="">Select Company Name</option>
                                                    @foreach($companyList as $key=>$items)
                                                        <option
                                                            value="{{$items->company_id}}">{{$items->company_name}}</option>
                                                    @endforeach
                                                </select>
                                                <?php if(!empty($users->company_id)){ ?>
                                                <script>document.getElementById("company_id").value = '{{ $users->company_id }}';</script>
                                                <?php } ?>
                                                @if ($errors->has('company_id'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('company_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 ">Branch Name
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            <div class="input-group">
                                                <select type="text" class="form-control kt_select2_5 {{ $errors->has('branch_id') ? ' is-invalid' : '' }}"
                                                        id="branch_id" name="branch_id" required>
                                                    <option value="">Select Branch Name</option>
                                                </select>
                                                <?php if(!empty($users->branch_id)){ ?>
                                                <script>document.getElementById("branch_id").value = '{{ $users->branch_id }}';</script>
                                                <?php } ?>
                                                @if ($errors->has('branch_id'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('branch_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 ">User Type <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            <div class="input-group">
                                                <select type="text" class="form-control kt_select2_5 {{ $errors->has('role_id') ? ' is-invalid' : '' }}"
                                                        id="role_id" name="role_id" required>
                                                    <option value="">Select User Role</option>
                                                    @foreach($roleList as $key=>$items)
                                                        <option
                                                            value="{{$items->role_id}}">{{$items->role_name}}</option>
                                                    @endforeach
                                                </select>
                                                <?php if(!empty($users->role_id)){ ?>
                                                <script>document.getElementById("role_id").value = '{{ $users->role_id }}';</script>
                                                <?php } ?>
                                                @if ($errors->has('role_id'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('role_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 ">User Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            <div class="input-group date">
                                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                       name="name" placeholder="Enter User Name" id="name"
                                                       value="{{ ((!empty($users->name)) ?$users->name :old('name'))}}">
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 ">Email <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            <div class="input-group date">
                                                <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                       name="email" placeholder="Enter Email Address" id="email"
                                                       value="{{ ((!empty($users->email)) ?$users->email :old('email'))}}">
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($action!='UPDATE')
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-3 ">Password <span class="text-danger">*</span></label>
                                            <div class="col-lg-5">
                                                <div class="input-group date">
                                                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                           name="password" placeholder="Enter Password" id="password"
                                                           value="{{ ((!empty($users->password)) ?$users->password :old('password'))}}">
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-3 ">Confirm Password
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-5">
                                                <div class="input-group date">
                                                    <input type="password" class="form-control {{ $errors->has('c_password') ? ' is-invalid' : '' }}"
                                                           name="c_password" placeholder="Enter Confirm Password"
                                                           id="c_password"
                                                           value="{{ ((!empty($users->c_password)) ?$users->c_password :old('c_password'))}}">
                                                    @if ($errors->has('c_password'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('c_password') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                    <div class="container">
                                        <div class="d-flex justify-content-between border-top mt-5 pt-10  card-footer">
                                            <div class="mr-2">
                                            </div>
                                            <div>
                                                @if($action=='INSERT')
                                                    <button type="submit"
                                                            class="btn btn-success">
                                                        <i class="fas fa-save"></i>Create User
                                                    </button>
                                                    <a href="{{route('users.index')}}"
                                                       class="btn btn-light-primary font-weight-bold">
                                                        Cancel
                                                    </a>
                                                @else
                                                    <button type="submit"
                                                            class="btn btn-warning">
                                                        <i class="fas fa-save"></i>Update
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection

@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script>
        function getBranch(company_id) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url('get-branch') }}',
                data: {'company_id': company_id},
                success: function (data) {
                    $('#branch_id').html(data);
                    <?php if(!empty($users->branch_id)){ ?>
                    document.getElementById("branch_id").value = '{{ $users->branch_id }}';
                    <?php } ?>
                }
            });
        }

        <?php if(!empty($users->branch_id)){ ?>
        getBranch(<?php echo $users->company_id; ?>);
        <?php } ?>
    </script>
@endpush
