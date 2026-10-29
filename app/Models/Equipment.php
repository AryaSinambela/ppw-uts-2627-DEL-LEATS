<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama',
        'category_id', 
        'Asset_code',
        'status',
        'condition'
    ];
}