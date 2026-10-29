<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    /**
     * Run the migrations.
     */
    use HasFactory;
    
    // Hapus properti 'id' dari fillable
    protected $fillable = [
        'equipment_id', 
        'borrower_name', 
        'borrower_nim', 
        'borrower_email', 
        'loan_date', 
        'expected_return_date', 
        'purpose', 'status', 
        'total_estimated_fee'
    ];

        /**
     * Reverse the migrations.
     */
    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }
}