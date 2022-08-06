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
                        <h3 class="subheader-title text-dark font-weight-bold my-2 mr-3">Product Image</h3>
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
            <!--begin::Card-->
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <!--begin::Form-->
                            <form class="form" id="kt_form_1"
                                  action="{{($action=='INSERT')? url('challan-image'):route('challan-image.update'.$imageDetail->image_id) }}"
                                  method="post">
                                @if ($action=='UPDATE')
                                    {{ method_field('PUT') }}
                                @endif
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <input type="hidden" name="challan_product_id" value="{{ $challan_product_id }}">
                                    <input type="hidden" name="challan_id" value="{{ $challan_id->challan_id }}">
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 ">Product
                                            Image <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            <div class="dropzone dropzone-default dropzone-success" id="kt_dropzone_3"
                                                 action="{{route('multifileuploads')}}">
                                                @csrf
                                                <div class="dropzone-msg dz-message needsclick">
                                                    <h3 class="dropzone-msg-title">Drop files here or click to
                                                        upload.</h3>
                                                    <span class="dropzone-msg-desc">Only image, pdf and psd files are allowed for upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10 card-footer">
                                        <div class="mr-2">

                                        </div>
                                        <div>
                                            @if($action=='INSERT')
                                                <button type="submit"
                                                        class="btn btn-success">
                                                    <i class="fas fa-save"></i>Save
                                                </button>
                                                <a href="{{url('challan-product-create/'.$challan_id->challan_id)}}"
                                                   class="btn btn-light-primary font-weight-bold">
                                                    Cancel
                                                </a>
                                            @else
                                                <button type="submit"
                                                        class="btn btn-warning">
                                                    <i class="fas fa-save"></i>Update
                                                </button>
                                            @endif
                                            <a href="{{ url('challan') }}"
                                               class="btn btn-danger">
                                                <span class="kt-hidden-mobile">Finish</span>
                                            </a>
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

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline mr-5">
                        <!--begin::Page Title-->
                        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">Image List</h2>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Row-->
                <div class="row">
                    @foreach ($imageDetail as $key=>$item)
                        <div class="col-lg-4">
                            <!--begin::Card-->
                            <a href="{{url('images/challan/'.$item->image_name)}}">
                                <div class="card card-custom overlay">

                                    <div class="card-body p-0">

                                        <div class="overlay-wrapper">
                                            <img src="{{url('images/challan/'.$item->image_name)}}"
                                                 alt="Image"
                                                 class="w-100 rounded"/>
                                        </div>
                                        <div class="overlay-layer align-items-end justify-content-end pb-5 pr-5">
                                            <a href="{{url('images/challan/'.$item->image_name)}}" target="_blank"  title="Image View"
                                               class="btn btn-clean btn-icon mr-2"><i
                                                    class="fas fa-images"></i></a>
                                            <form method="POST" style="display:inline;" title="Delete Image"
                                                  action="{{ route('challan-image.destroy',$item->image_id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!--end::Card-->
                        </div>
                    @endforeach
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@push('scripts')
    <script src="{{asset('metronic/assets/js/pages/crud/forms/validation/form-controls.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/file-upload/dropzonejs.js?v=7.0.4')}}"></script>
    <script src="{{asset('metronic/assets/js/pages/crud/ktdatatable/base/html-table.js?v=7.0.4')}}"></script>
    <script>
        Dropzone.options.kDropzoneTwo = {
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "image/*,application/pdf,.psd/jpeg,jpg",
            accept: function (file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            removedfile: function (a) {
                var image = a.name;
                image = image.replace("/[^a-zA-Z0-9.]/", "");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url('remove-image') }}',
                    data: {'image_name': image},
                    dataType: 'post'
                });
                var b;
                return a.previewElement && null != (b = a.previewElement) && b.parentNode.removeChild(a.previewElement), this._updateMaxFilesReachedClass()
            },
        };
    </script>
@endpush
