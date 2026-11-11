<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['ratings', 'reviews'];

    //define one to many relationship b/w book to reviews
    public function Book(){
        return $this->belongsTo(Book::class);
    }
}
