@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('content')
<div x-data="{ openDelete: false, openDetail: false, contact: {} }">
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h2 class="page-title">Admin</h2> 

    {{-- 検索フォーム --}}
    <form action="{{ route('admin.contacts.search') }}" method="GET" class="search-form">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="名前やメールアドレス">
        <select name="gender">
            <option value="">性別⇓</option>
            <option value="1" {{ request('gender') == 1 ? 'selected' : '' }}>男性</option>
            <option value="2" {{ request('gender') == 2 ? 'selected' : '' }}>女性</option>
            <option value="3" {{ request('gender') == 3 ? 'selected' : '' }}>その他</option>
        </select>
        <select name="category_id">
            <option value="">お問い合わせの種類⇓</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->content }}
                </option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ request('date') ?? '' }}">
        <button type="submit">検索</button>
        <a href="{{ route('admin.contacts.index') }}" class="btn-reset">リセット</a>
    </form>

    {{-- ページネーション --}}
    @php
        $total = $contacts->lastPage();
        $current = $contacts->currentPage();
        $maxPages = 5;
        $start = max($current - 2, 1);
        $end = min($start + $maxPages - 1, $total);
        $start = max($end - $maxPages + 1, 1);
    @endphp

    <div class="pagination-links">
    @if ($current > 1)
        <a class="page-item" href="{{ $contacts->url($current - 1) }}">＜</a>
    @endif

    @for ($i = $start; $i <= $end; $i++)
        @if ($i == $current)
            <span class="page-item active">{{ $i }}</span>
        @else
            <a class="page-item" href="{{ $contacts->url($i) }}">{{ $i }}</a>
        @endif
    @endfor

    @if ($current < $total)
        <a class="page-item" href="{{ $contacts->url($current + 1) }}">＞</a>
    @endif
    </div>
    
    {{-- お問い合わせ一覧 --}}
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>お名前</th>
                <th>性別</th>
                <th>メール</th>
                <th>種類</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                    <td>{{ $contact->gender === 1 ? '男性' : ($contact->gender === 2 ? '女性' : 'その他') }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->category->content ?? '' }}</td>
                    <td>
                        <button type="button" @click="openDetail = true;
                                    contact = {
                                        id: {{ $contact->id }},
                                        name: @js($contact->last_name . ' ' . $contact->first_name),
                                        gender: @js($contact->gender === 1 ? '男性' : ($contact->gender === 2 ? '女性' : 'その他')),
                                        email: @js($contact->email),
                                        tel: @js($contact->tel),
                                        address: @js($contact->address),
                                        building: @js($contact->building),
                                        category: @js($contact->category->content ?? ''),
                                        detail: @js($contact->detail),
                                        };
                                            ">詳細</button>

                        <button type="button" @click="openDelete = true;
                                    contact = {
                                    id: {{ $contact->id }},
                                    name: @js($contact->last_name . ' ' . $contact->first_name),
                                    gender: @js($contact->gender === 1 ? '男性' : ($contact->gender === 2 ? '女性' : 'その他')),
                                    email: @js($contact->email),
                                    tel: @js($contact->tel),
                                    address: @js($contact->address),
                                    building: @js($contact->building),
                                    category: @js($contact->category->content ?? ''),
                                    detail: @js($contact->detail),
                                    deleteUrl: @js(route('admin.contacts.destroy', $contact)),
                                        };
                                            ">削除</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 削除モーダル --}}
    <div x-show="openDelete" @click.self="open=false" class="modal-overlay">
        <div class="modal-box">
            <h2 class="modal-title">削除確認</h2>
            <p>以下のお問い合わせを削除します。よろしいですか？</p>
            <div class="modal-info">
                <p><strong>ID:</strong> <span x-text="contact.id"></span></p>
                <p><strong>名前:</strong> <span x-text="contact.name"></span></p>
                <p><strong>性別:</strong> <span x-text="contact.gender"></span></p>
                <p><strong>メール:</strong> <span x-text="contact.email"></span></p>
                <p><strong>電話番号:</strong> <span x-text="contact.tel"></span></p>
                <p><strong>住所:</strong> <span x-text="contact.address"></span></p>
                <p><strong>建物名:</strong> <span x-text="contact.building"></span></p>
                <p><strong>種類:</strong> <span x-text="contact.category"></span></p>
                <p><strong>内容:</strong></p>
                <div x-text="contact.detail"></div>
            </div>
            <form :action="contact.deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" @click="open=false" class="btn-cancel">キャンセル</button>
                <button class="btn-delete">削除する</button>
            </form>
        </div>
    </div>
    {{-- ▼▼ 詳細モーダル ▼▼ --}}
    <div x-show="openDetail" @click.self="openDetail=false" class="modal-overlay">
        <div class="modal-box">
            <button @click="openDetail=false" class="modal-close">×</button>
            <h2 class="modal-title">お問い合わせ詳細</h2>

            <div class="modal-info">
                <p><strong>ID:</strong> <span x-text="contact.id"></span></p>
                <p><strong>名前:</strong> <span x-text="contact.name"></span></p>
                <p><strong>性別:</strong> <span x-text="contact.gender"></span></p>
                <p><strong>メール:</strong> <span x-text="contact.email"></span></p>
                <p><strong>電話番号:</strong> <span x-text="contact.tel"></span></p>
                <p><strong>住所:</strong> <span x-text="contact.address"></span></p>
                <p><strong>建物名:</strong> <span x-text="contact.building"></span></p>
                <p><strong>種類:</strong> <span x-text="contact.category"></span></p>

                <p><strong>内容:</strong></p>
            <div x-text="contact.detail"></div>
        </div>
    </div>
</div>
{{-- ▲▲ 詳細モーダル ▲▲ --}}

</div>
@endsection
