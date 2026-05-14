<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('child_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();
            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('assigned_ngo_id')->nullable();
            $table->enum('assigned_to_type', ['ngo', 'police', 'both'])->default('ngo');
            $table->enum('status', ['pending', 'under_investigation', 'rescued', 'rehabilitated'])->default('pending');
            $table->string('location');
            $table->string('city');
            $table->text('description');
            $table->text('admin_notes')->nullable();
            $table->timestamp('rescued_at')->nullable();
            $table->timestamp('rehabilitated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_cases');
    }
};
