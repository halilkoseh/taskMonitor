<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->timestamp('approval_requested_at')->nullable()->after('status');
            $table->timestamp('approved_at')->nullable()->after('approval_requested_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('approval_requested_at');
            $table->dropColumn('approved_at');
        });
    }
};
