<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'price'];

    public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'book_user', 'book_id', 'user_id')->withTimestamps();
}
}



