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
        Schema::create('journal_details', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index();
            $table->string('coa_code')->index();
            $table->string('type')->index()->nullable();
            $table->string('description')->nullable();
            $table->string('dc', 20);
            $table->decimal('debit', 12, 2);
            $table->decimal('credit', 12, 2);
            $table->decimal('amount', 12, 2);
            $table->date('date')->index();
            $table->year('year')->index()->storedAs("YEAR(date)");
            $table->integer('month')->index()->storedAs("CONCAT(YEAR(date), LPAD(MONTH(date),2,'0'))");
            $table->enum('status', ['open','approved','void'])->index()->default('open');
            $table->integer('sort')->index()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_details');
    }
};
