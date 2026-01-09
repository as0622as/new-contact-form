<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    
    public function index()
    {
        $contacts = Contact::with('category')
            ->latest()
            ->paginate(5);
        
        $categories = Category::all();

        return view('admin.contacts.index', compact('contacts','categories'));
    }

    
    public function search(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('keyword')) {
            $query->where('first_name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('last_name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('email', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->with('category')->latest()->paginate(5);
        $categories = Category::all();
        return view('admin.contacts.index', compact('contacts','categories'));
    }

    
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'お問い合わせを削除しました');
    }

    public function export()
    {
        $contacts = Contact::with('category')->get();

        $filename = 'contacts_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($contacts) {
            $file = fopen('php://output', 'w');

        fputcsv($file, [
            'ID',
            '名前',
            '性別',
            'メール',
            '電話番号',
            '住所',
            '建物名',
            '種類',
            'お問い合わせ内容',
            '作成日',
        ]);

        foreach ($contacts as $c) {
            fputcsv($file, [
                $c->id,
                $c->last_name . ' ' . $c->first_name,
                $c->gender === 1 ? '男性' : ($c->gender === 2 ? '女性' : 'その他'),
                $c->email,
                $c->tel,
                $c->address,
                $c->building,
                $c->category->content ?? '',
                $c->detail,
                $c->created_at,
            ]);
        }

        fclose($file);
    };

        return response()->stream($callback, 200, $headers);
    }
}
