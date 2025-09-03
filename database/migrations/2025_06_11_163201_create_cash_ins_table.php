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
        Schema::create('cash_ins', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->date('date')->nullable();
            $table->foreignId('cash_account_id')->index()->nullable();
            $table->foreignId('contact_id')->index()->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('type')->index()->nullable();
            $table->string('note')->nullable();
            $table->integer('has_receivable')->index()->default(0);
            $table->integer('used_receivable')->index()->default(0);
            $table->integer('has_prepaid')->index()->default(0);
            $table->integer('used_prepaid')->index()->default(0);
            $table->enum('status', ['open','close','void'])->index()->default('open');
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
        Schema::dropIfExists('cash_ins');
    }
};
