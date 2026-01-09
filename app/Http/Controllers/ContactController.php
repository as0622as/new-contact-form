<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // PG01 入力画面
    public function create(Request $request)
    {
        $categories = Category::all();
        $inputs = $request->all();
        return view('contacts.create', compact('categories', 'inputs'));
    }

    // PG02 確認画面
    public function confirm(StoreContactRequest $request)
    {

        $inputs = $request->validated();

        $inputs['tel'] = $inputs['tel1'] . '-' . $inputs['tel2'] . '-' . $inputs['tel3'];

        $category = Category::find($inputs['category_id']);
        $inputs['category_content'] = $category ? $category->content : '';

        return view('contacts.confirm', compact('inputs'));
    }

    // PG03 送信処理
    public function store(StoreContactRequest $request)
    {
        $inputs = $request->validated();

        $inputs['tel'] = $inputs['tel1'] . '-' . $inputs['tel2'] . '-' . $inputs['tel3'];

        Contact::create($inputs);
        return redirect()->route('contacts.thanks');
    }

    // PG04 管理画面一覧
    public function index()
    {
        $contacts = Contact::with('category')
            ->latest()
            ->paginate(5);
        $categories = Category::all();
        return view('admin.contacts.index', compact('contacts','categories'));
    }

    // PG05 検索
    public function search(Request $request)
    {
        $query = Contact::query()->with('category');

        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('last_name', 'like', "%{$request->keyword}%")
                ->orWhere('first_name', 'like', "%{$request->keyword}%")
                ->orWhere('email', 'like', "%{$request->keyword}%");
            });
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->latest()->paginate(5)->withQueryString();
        $categories = Category::all();

        return view('admin.contacts.index', compact('contacts', 'categories'));
    }

    // PG07 削除
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect('/admin');
    }

    // PG11 エクスポート（中身はあとでOK）
    public function export()
    {
        // CSV出力など
    }

    public function thanks()
    {
        return view('contacts.thanks');
    }
}
