<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorials extends Model
{
    protected $fillable = ['id', 'name'];

    public $timestamps = false;
    use HasFactory;
}
