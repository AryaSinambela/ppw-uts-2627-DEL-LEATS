<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'equipment_id',
        'borrower_name', 
        'borrower_nim',
        'borrower_email',
        'loan_date',
        'expected_return_date',
        'purpose',
        'total_estimated_fee'
    ];


    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}