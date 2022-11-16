<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['id', 'name'];

    public $timestamps = false;
    use HasFactory;

    public function books()
    {
        return $this->hasMany(Book::class, 'id');
    }
}
