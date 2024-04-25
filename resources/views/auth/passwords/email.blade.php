@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@php( $password_email_url = View::getSection('password_email_url') ?? config('adminlte.password_email_url', 'password/email') )

@if (config('adminlte.use_route_url', false))
@php( $password_email_url = $password_email_url ? route($password_email_url) : '' )
@else
@php( $password_email_url = $password_email_url ? url($password_email_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.password_reset_message'))

@section('auth_body')
<style>
    .login-page {
        background-color: #59b9c6 !important;
    }

    .login-logo {
        margin-bottom: 0;
    }

    .login-logo a {
        color: white !important;
    }

    .login-logo a b::after {
        content: '文書管理システム';
        display: block;
        font-size: large;
    }

    .card-primary.card-outline {
        border: none !important;
        border-radius: 0 !important;
    }

    .login-box,
    .register-box {
        width: 50% !important;
        max-width: 450px;
    }
</style>

@if(session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

<form action="{{ $password_email_url }}" method="post">
    @csrf

    {{-- Email field --}}
    <div class="input-group mb-3">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>

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

    {{-- Send reset link button --}}
    <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-success') }} btn-success">
        <span class="fas fa-share-square"></span>
        {{ __('adminlte::adminlte.send_password_reset_link') }}
    </button>

</form>

<div class="text-center mt-2">
    <b>
        <<&nbsp; </b>
            <a href="/login">ログイン画面に戻る</a>
</div>
@stop