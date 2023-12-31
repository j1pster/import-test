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
            $table->dateTime('date_of_birth')->nullable();
            $table->boolean('checked')->default(false);
            $table->string('email')->nullable();
            $table->string('interest')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            
            $table->string('credit_card_number');
            $table->string('credit_card_type');
            $table->string('credit_card_name');
            $table->string('credit_card_expiration_date');

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
