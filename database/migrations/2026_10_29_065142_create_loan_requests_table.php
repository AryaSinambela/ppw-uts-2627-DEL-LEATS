<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_id');
            $table->string('borrower_name');
            $table->string('purpose');
            $table->string('borrower_email');
            $table->foreignId('borrower_nim')->constrained()->onDelete('cascade');
            $table->timestamp('loan_date');
            $table->timestamp('returned_at')->nullable();
            $table->timestamps(total_estimated_fee);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
