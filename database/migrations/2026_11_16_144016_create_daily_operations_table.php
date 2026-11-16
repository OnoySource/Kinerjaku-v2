<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_operations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->date('operation_date');
            $table->string('activity');
            $table->decimal('quantity', 10, 2)->nullable();
            $table->string('unit', 50)->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('recorded');

            $table->timestamps();

            $table->index(['employee_id', 'operation_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_operations');
    }
};
