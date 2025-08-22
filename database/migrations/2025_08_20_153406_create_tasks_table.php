<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('status', ['todo', 'in_progress', 'done'])->default('todo');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('description')->nullable();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete(); // who created/owns the task
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
