<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration responsável por criar a tabela de tickets
 */
return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->integer('quantity');
            $table->char('situation', 1)->default('A');
            $table->timestamp('delivery_date')->default(now());
            $table->timestamps();
            $table->softDeletes();
        });

    }


    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
