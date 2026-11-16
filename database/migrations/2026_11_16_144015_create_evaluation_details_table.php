<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evaluation_id')
                ->constrained('evaluations')
                ->cascadeOnDelete();

            $table->foreignId('criteria_id')
                ->constrained('criteria')
                ->cascadeOnDelete();

            $table->decimal('score', 5, 2);
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique([
                'evaluation_id',
                'criteria_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_details');
    }
};
