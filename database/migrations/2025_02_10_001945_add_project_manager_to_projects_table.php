<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('project_manager')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['project_manager']);
            $table->dropColumn('project_manager');
        });
    }
};
