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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Teacher::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Section::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\TimeTable::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['time_table_id','section_id']);
            $table->unique(['teacher_id','time_table_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
