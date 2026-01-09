@extends('layouts.app')

@section('title', 'お問い合わせ確認')

@section('content')
<h2>お問い合わせ確認</h2>

<form method="POST" action="{{ route('contacts.store') }}" class="contact-form">
    @csrf

    {{-- お名前 --}}
    <div>
        <strong>お名前：</strong>
        {{ $inputs['last_name'] }} {{ $inputs['first_name'] }}
        <input type="hidden" name="last_name" value="{{ $inputs['last_name'] }}">
        <input type="hidden" name="first_name" value="{{ $inputs['first_name'] }}">
    </div>

    {{-- 性別 --}}
    <div>
        <strong>性別：</strong>
        {{ $inputs['gender'] === '1' ? '男性' : ($inputs['gender'] === '2' ? '女性' : 'その他') }}
        <input type="hidden" name="gender" value="{{ $inputs['gender'] }}">
    </div>

    {{-- メール --}}
    <div>
        <strong>メールアドレス：</strong>
        {{ $inputs['email'] }}
        <input type="hidden" name="email" value="{{ $inputs['email'] }}">
    </div>

    {{-- 電話 --}}
    <div>
        <strong>電話番号：</strong>
        {{ $inputs['tel1'] }}-{{ $inputs['tel2'] }}-{{ $inputs['tel3'] }}
        <input type="hidden" name="tel1" value="{{ $inputs['tel1'] }}">
        <input type="hidden" name="tel2" value="{{ $inputs['tel2'] }}">
        <input type="hidden" name="tel3" value="{{ $inputs['tel3'] }}">
    </div>

    {{-- 住所 --}}
    <div>
        <strong>住所：</strong>
        {{ $inputs['address'] }}
        <input type="hidden" name="address" value="{{ $inputs['address'] }}">
    </div>

    {{-- 建物名 --}}
    <div>
        <strong>建物名：</strong>
        {{ $inputs['building'] ?? '-' }}
        <input type="hidden" name="building" value="{{ $inputs['building'] }}">
    </div>

    {{-- お問い合わせ種類 --}}
    <div>
        <strong>お問い合わせの種類：</strong>
        {{ $inputs['category_content'] }}
        <input type="hidden" name="category_id" value="{{ $inputs['category_id'] }}">
    </div>

    {{-- 内容 --}}
    <div>
        <strong>お問い合わせ内容：</strong>
        {{ $inputs['content'] }}
        <input type="hidden" name="content" value="{{ $inputs['content'] }}">
    </div>

    <button type="submit" class="btn-submit">送信</button>
</form>

{{-- 修正ボタン --}}
<form method="GET" action="{{ route('contacts.create') }}" class="contact-form">
    @foreach ($inputs as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <button type="submit" class="btn-modify">修正する</button>
</form>
@endsection
