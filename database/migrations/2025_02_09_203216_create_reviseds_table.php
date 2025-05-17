<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reviseds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->string('file_path'); // Yüklenen dosyanın yolu
            $table->text('note'); // Kullanıcının zorunlu olarak eklemesi gereken not
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviseds');
    }
};
