<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('teacher', function (Blueprint $table) {
                $table->increments('teacherId');
                $table->string('contractType');
                $table->string('specialty');
                $table->unsignedBigInteger('idUser');
                $table->timestamps();
                $table->foreign('idUser')->references('userId')->on('user');
            });
        }

        public function down()
        {
            Schema::dropIfExists('teacher');
        }
    };
?>