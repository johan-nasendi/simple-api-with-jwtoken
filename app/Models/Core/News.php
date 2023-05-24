<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    public $guarded = [];

    public function user() {
        return $this->belongsTo(User::class,'author');
    }
    public function category() {
        return $this->belongsTo(Categories::class,'category_id');
    }
}
