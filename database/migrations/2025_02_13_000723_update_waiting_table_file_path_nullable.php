<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 // Yeni migration oluştur (Örn: php artisan make:migration update_waiting_table_file_path_nullable)
public function up()
{
    Schema::table('waitings', function (Blueprint $table) {
        $table->string('file_path')->nullable()->change(); // Nullable yap
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
