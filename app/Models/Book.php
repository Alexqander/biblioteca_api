<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'id',
        'name',
        'isbn',
        'title',
        'description',
        'published_date',
        'category_id',
        'editorial_id',
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
    public function editorial()
    {
        return $this->belongsTo(Editorials::class, 'editorial_id', 'id');
    }
    public function authors()
    {
        return $this->belongsToMany(
            Authors::class,
            'authors_books',
            'books_id',
            'authors_id'
        );
    }
    use HasFactory;
}
