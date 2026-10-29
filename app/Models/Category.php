<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'id',
        'nama',
        'category_id', 
        'year'
        
    ];

    }

