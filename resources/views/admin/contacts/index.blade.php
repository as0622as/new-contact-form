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
    <a href="{{ route('admin.contacts.export') }}" class="btn-export">
        エクスポート
    </a>
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
                        <a href="#detail-{{ $contact->id }}" class="btn btn-primary">詳細</a>
                    </td>
                </tr>

                {{-- ▼ 詳細モーダル ▼ --}}
                <div id="detail-{{ $contact->id }}" class="modal">
                    <div class="modal-box">
                        <a href="#" class="modal-close">×</a>

                        <h2>お問い合わせ詳細</h2>

                        <p><strong>ID:</strong> {{ $contact->id }}</p>
                        <p><strong>名前:</strong> {{ $contact->last_name }} {{ $contact->first_name }}</p>
                        <p><strong>性別:</strong>
                            {{ $contact->gender === 1 ? '男性' : ($contact->gender === 2 ? '女性' : 'その他') }}
                        </p>
                        <p><strong>メール:</strong> {{ $contact->email }}</p>
                        <p><strong>電話番号:</strong> {{ $contact->tel }}</p>
                        <p><strong>住所:</strong> {{ $contact->address }}</p>
                        <p><strong>建物名:</strong> {{ $contact->building }}</p>
                        <p><strong>種類:</strong> {{ $contact->category->content ?? '' }}</p>

                        <p><strong>内容:</strong></p>
                        <div>{{ $contact->detail }}</div>

                        {{-- 削除ボタン --}}
                        <div style="modal-delete-btn">
                             <a href="#delete-{{ $contact->id }}" class="btn btn-delete">
                                    削除
                            </a>
                        </div>
                    </div>
                </div>
                {{-- ▲ 詳細モーダル ▲ --}}

                {{-- ▼ 削除モーダル ▼ --}}
                <div id="delete-{{ $contact->id }}" class="modal">
                    <div class="modal-box">
                        <a href="#" class="modal-close">×</a>

                        <h2>削除確認</h2>
                        <p>以下のお問い合わせを削除します。よろしいですか？</p>

                        <p><strong>ID:</strong> {{ $contact->id }}</p>
                        <p><strong>名前:</strong> {{ $contact->last_name }} {{ $contact->first_name }}</p>
                        <p><strong>性別:</strong>
                            {{ $contact->gender === 1 ? '男性' : ($contact->gender === 2 ? '女性' : 'その他') }}
                        </p>
                        <p><strong>メール:</strong> {{ $contact->email }}</p>
                        <p><strong>電話番号:</strong> {{ $contact->tel }}</p>
                        <p><strong>住所:</strong> {{ $contact->address }}</p>
                        <p><strong>建物名:</strong> {{ $contact->building }}</p>
                        <p><strong>種類:</strong> {{ $contact->category->content ?? '' }}</p>

                        <p><strong>内容:</strong></p>
                        <div>{{ $contact->detail }}</div>

                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">削除する</button>
                            <a href="#" class="btn-cancel">キャンセル</a>
                        </form>
                    </div>
                </div>
                {{-- ▲ 削除モーダル ▲ --}}
            @endforeach
        </tbody>
    </table>

    
</div>
@endsection
