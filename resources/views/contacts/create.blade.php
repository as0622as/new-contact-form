@extends('layouts.app')

@section('title', 'Contact')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/contacts.css') }}">
@endsection

@section('content')
<h2 class="page-title">Contact</h2>

@if ($errors->any())
    <div class="error-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('contacts.confirm') }}" class="contact-form">
    @csrf

    {{-- お名前 --}}
    <div class="form-group">
        <label class="form-label">
            お名前 <span class="required">※</span>
        </label>

        <div class="name-row">
            <div class="name-item">
                <input type="text" name="last_name" class="name-input"
                       placeholder="山田" value="{{ old('last_name', $inputs['last_name'] ?? '') }}">
            </div>

            <div class="name-item">
                <input type="text" name="first_name" class="name-input"
                       placeholder="太郎" value="{{ old('first_name', $inputs['first_name'] ?? '') }}">
            </div>
        </div>
    </div>

    {{-- 性別 --}}
    <div class="form-group">
        <label class="form-label">
            性別 <span class="required">※</span>
        </label>

        <div class="gender-row">
            @php
                $gender = old('gender', $inputs['gender'] ?? '');
            @endphp

            <label><input type="radio" name="gender" value="1" {{ $gender == 1 ? 'checked' : '' }}> 男性</label>
            <label><input type="radio" name="gender" value="2" {{ $gender == 2 ? 'checked' : '' }}> 女性</label>
            <label><input type="radio" name="gender" value="3" {{ $gender == 3 ? 'checked' : '' }}> その他</label>
        </div>
    </div>

    {{-- メール --}}
    <div class="form-group">
        <label class="form-label">
            メールアドレス <span class="required">※</span>
        </label>

        <div class="email-row">
            <input type="email"
                   name="email"
                   class="email-input"
                   placeholder="test@example.com"
                   value="{{ old('email', $inputs['email'] ?? '') }}">
        </div>
    </div>

    {{-- 電話 --}}
    <div class="form-group">
        <label class="form-label">
            電話番号 <span class="required">※</span>
        </label>

        <div class="tel-row">
            <input type="text" name="tel1" class="tel-input" maxlength="4" placeholder="080" value="{{ old('tel1', $inputs['tel1'] ?? '') }}">
            <span class="tel-hyphen">-</span>

            <input type="text" name="tel2" class="tel-input" maxlength="4" placeholder="1234" value="{{ old('tel2', $inputs['tel2'] ?? '') }}">
            <span class="tel-hyphen">-</span>

            <input type="text" name="tel3" class="tel-input" maxlength="4" placeholder="5678" value="{{ old('tel3', $inputs['tel3'] ?? '') }}">
        </div>
    </div>

    {{-- 住所 --}}
    <div class="form-group">
        <label class="form-label">
            住所 <span class="required">※</span>
        </label>

        <div class="address-row">
            <input type="text"
                   name="address"
                   class="address-input"
                   placeholder="東京都渋谷区千駄ヶ谷1-2-3"
                   value="{{ old('address', $inputs['address'] ?? '') }}">
        </div>
    </div>

    {{-- 建物名 --}}
    <div class="form-group">
        <label class="form-label">
            建物名
        </label>

        <div class="building-row">
            <input type="text"
                   name="building"
                   class="building-input"
                   placeholder="千駄ヶ谷マンション"
                   value="{{ old('building', $inputs['building'] ?? '') }}">
        </div>
    </div>

    {{-- お問い合わせ種類 --}}
    <div class="form-group">
        <label class="form-label">
            お問い合わせの種類 <span class="required">※</span>
        </label>

        <div class="type-row">
            @php
                $selectedCategory = old('category_id', $inputs['category_id'] ?? '');
            @endphp

            <select name="category_id" class="type-select">
                <option value="">選択してください</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                    {{ $category->content }}
                </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- 内容 --}}
    <div class="form-group">
        <label class="form-label">
            お問い合わせ内容 <span class="required">※</span>
        </label>

        <div class="content-row">
            <textarea
                name="content"
                id="content"
                class="form-control"
                placeholder="【お問い合わせ内容をご記載ください】">{{ old('content', $inputs['content'] ?? '') }}</textarea>
        </div>
    </div>

    <button type="submit" class="btn">確認画面へ</button>
</form>
@endsection
