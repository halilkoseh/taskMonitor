<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 // database/migrations/xxxx_create_user_task_table.php
public function up()
{
    Schema::create('user_task', function (Blueprint $table) {
        $table->id();
        $table->foreignId('task_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
        
        // Benzersiz kombinasyon
        $table->unique(['task_id', 'user_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_task');
    }
};
