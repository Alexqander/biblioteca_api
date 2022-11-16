<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    protected $fillable = [
        'id',
        'name',
        'first_surname',
        'second_surname'
    ];


    public function books()
    {
        return $this->belongsToMany(
            Book::class,
            'id',
            'name',
            'isbn',
            'title',
            'description',
            'published_date',
            'category_id',
            'editorial_id'
        );
    }

    public $timestamps = false;
    use HasFactory;
}
