@extends('layouts.app')
@section('alerts')
    @if (session('create-status'))
        <div class="alert alert-custom alert-notice alert-light-success fade show mb-5" role="alert">
            <div class="alert-icon">
                <i class="far fa-copyright"></i>
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
@endsection
