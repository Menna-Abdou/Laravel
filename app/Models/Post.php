<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'slug',
        'image'
    ];
    public function user(){
         return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');//name of polymorphic relation
        // return $this->hasMany(Comment::class, 'commentable');
    }
}
