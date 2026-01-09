<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    // お問い合わせとのリレーション
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
