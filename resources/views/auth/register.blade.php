@extends('layouts.app')

@section('page-title')
    <h2 class="page-title">Register</h2>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-page">
    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="register-form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">お名前</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus class="form-input">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-input">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" id="password" name="password" required class="form-input">
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">パスワード確認</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="form-input">
        </div>

        <button type="submit" class="btn-submit">登録</button>
    </form>
</div>
@endsection
