@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
@php( $login_url = $login_url ? route($login_url) : '' )
@php( $register_url = $register_url ? route($register_url) : '' )
@else
@php( $login_url = $login_url ? url($login_url) : '' )
@php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.register_message'))

@section('auth_body')

<form action="{{ $register_url }}" method="post">
    @csrf

    {{-- Name field --}}
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Email field --}}
    <div class="input-group mb-3">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Password field --}}
    <div class="input-group mb-3">
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('adminlte::adminlte.password') }}">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Confirm password field --}}
    <div class="input-group mb-3">
        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('adminlte::adminlte.retype_password') }}">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Department field --}}
    <div class="input-group mb-3">
        <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ old('department') }}" placeholder="{{ __('adminlte::adminlte.department') }}">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-id-card {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

    </div>

    {{-- Section field --}}
    <div class="input-group mb-3">
        <input type="text" name="section" class="form-control @error('section') is-invalid @enderror" value="{{ old('section') }}" placeholder="{{ __('adminlte::adminlte.section') }}">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-id-card {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

    </div>

    {{-- Position field --}}
    <div class="input-group mb-3">
        <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}" placeholder="{{ __('adminlte::adminlte.position') }}" autofocus>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-id-card {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

    </div>

    {{-- stamp field --}}
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
    <script>
        bsCustomFileInput.init();
    </script>
    <style>
        .custom-file {
            overflow: hidden;
        }

        .custom-file-label {
            white-space: nowrap;
        }
    </style>
    <div class="mb-1">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="stamp" name="stamp" accept="image/svg+xml" value="">
            <label class="custom-file-label" for="stamp" data-browse="参照">印章svgファイル選択...</label>
        </div>
        <a href="https://e-inkan.com/select.html">印章ダウンロードサイト</a>
    </div>
    <input type="hidden" name="used" value="1">
    <input type="hidden" name="authtype" value="0">

    {{-- Register button --}}
    <button type="submit" class="btn btn-primary btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
        <span class="fas fa-user-plus"></span>
        {{ __('adminlte::adminlte.register') }}
    </button>

</form>
@stop

@section('auth_footer')
<p class="my-0">
    <a href="{{ $login_url }}">
        {{ __('adminlte::adminlte.i_already_have_a_membership') }}
    </a>
</p>
@stop