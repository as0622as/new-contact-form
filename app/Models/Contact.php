<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
    'first_name',
    'last_name',
    'gender',
    'email',
    'tel',
    'address',
    'building',
    'category_id',
    'content',
];

    // カテゴリとのリレーション
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
