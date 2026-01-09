@extends('layouts.app')

@section('page-title')
    <h2 class="page-title">Login</h2>
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-page">
    @if (session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-input">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" id="password" name="password" required class="form-input">
        </div>

        <button type="submit" class="btn-submit">ログイン</button>
    </form>

    <p class="login-register-link">
        <a href="{{ route('register') }}">新規登録はこちら</a>
    </p>
</div>
@endsection
