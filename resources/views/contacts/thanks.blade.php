@extends('layouts.app')

@section('title', 'お問い合わせありがとうございました')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/contact-thanks.css') }}">
@endsection

@section('content')
<div class="contact-thanks-container">
    <div class="background-text">Thank you</div>

    <div class="thanks-content">
        <h1>お問い合わせありがとうございました</h1>
        <a href="{{ route('contacts.create') }}" class="btn-home">HOME</a>
    </div>
</div>
@endsection
