<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // 一覧表示
    public function index()
    {
        $contacts = Contact::with('category')
            ->latest()
            ->paginate(5);
        
        $categories = Category::all();

        return view('admin.contacts.index', compact('contacts','categories'));
    }

    // 検索
    public function search(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('keyword')) {
            $query->where('first_name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('last_name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('email', 'like', '%' . $request->keyword . '%');
        }

        $contacts = $query->with('category')->latest()->paginate(5);
        $categories = Category::all();
        return view('admin.contacts.index', compact('contacts','categories'));
    }

    // 削除
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'お問い合わせを削除しました');
    }

    // 詳細表示（モーダル用）
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }
}
