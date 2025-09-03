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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->date('date')->index();
            $table->string('note')->nullable();
            $table->string('type')->index()->nullable();
            $table->decimal('debit_total', 12, 2)->default(0);
            $table->decimal('credit_total', 12, 2)->default(0);
            $table->foreignId('contact_id')->index()->nullable()->default(0);
            $table->string('journalable_type')->index()->nullable();
            $table->string('journalable_id')->index()->nullable();
            $table->string('journalable_code')->nullable();
            $table->enum('status', ['open','approved','void'])->index()->default('open');
            $table->foreignId('created_by')->index()->default(0);
            $table->foreignId('updated_by')->index()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
