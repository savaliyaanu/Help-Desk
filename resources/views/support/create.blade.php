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
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Support</h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
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
                                  action="{{($action=='INSERT')? url('support-menu'):route('support-menu.update',$support->faq_id) }}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group ">
                                        <label for="exampleSelect1">Category
                                            Name</label><span>*</span>

                                        <select class="form-control kt_select2_5" name="category_id"
                                                id="exampleSelect1">
                                            <option value="">Select Category</option>
                                            <?php foreach ($category as $row){ ?>
                                            <option
                                                value="<?php echo $row['category_id']; ?>" <?php echo (!empty($support['category_id']) AND $support['category_id'] == $row['category_id']) ? 'selected' : '';?>><?php echo $row['category_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if(!empty($category[0]['category_id'])){ ?>
                                        <script>document.getElementById("category_id").value = '<?php echo $category[0]['category_id']; ?>';</script>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group ">
                                        <label>Question </label><span>*</span>
                                        <input type="text" class="form-control" placeholder="Enter Question"
                                               name="questions"
                                               value="{{ ((!empty($support->questions)) ?$support->questions :old('questions'))}}"/>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top mt-5 pt-10 card-footer">
                                    <div class="mr-2">
                                        <a href="{{ url('support-menu/') }}"
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
                                        <a href="{{url('case-solution/create')}}"
                                           class="btn btn-light-dark font-weight-bold">
                                            Next
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
@endsection
@push('scripts')
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
@endpush
