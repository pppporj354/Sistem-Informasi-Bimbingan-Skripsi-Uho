<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_type'); // create, update, delete, approve, reject, login, logout, etc.
            $table->string('entity_type')->nullable(); // Student, Lecturer, Guidance, etc.
            $table->string('entity_id')->nullable(); // ID of the entity being modified
            $table->string('user_id'); // User who performed the action
            $table->string('user_name'); // Name of the user (for historical reference)
            $table->string('user_role'); // Role of the user at the time of action
            $table->text('description'); // Human-readable description of the action
            $table->json('old_values')->nullable(); // Previous values (for updates)
            $table->json('new_values')->nullable(); // New values (for updates/creates)
            $table->string('ip_address')->nullable(); // IP address of the user
            $table->string('user_agent')->nullable(); // User agent string
            $table->timestamps();

            // Indexes for better performance
            $table->index(['event_type', 'created_at']);
            $table->index(['entity_type', 'entity_id']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
