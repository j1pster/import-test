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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account')->nullable();
            $table->string('address')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->boolean('checked')->default(false);
            $table->string('email')->nullable();
            $table->string('interest')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            
            $table->string('credit_card_number')->nullable();
            $table->string('credit_card_type')->nullable();
            $table->string('credit_card_name')->nullable();
            $table->string('credit_card_expiration_date')->nullable();

            $table->unsignedBigInteger('import_id')->references('id')->on('imports');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
