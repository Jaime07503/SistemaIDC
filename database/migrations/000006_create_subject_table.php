<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('subject', function (Blueprint $table) {
                $table->increments('subjectId');
                $table->string('nameSubject');
                $table->string('section');
                $table->string('career');
                $table->string('subjectCycle');
                $table->string('subjectYear');
                $table->binary('avatar')->nullable();
                $table->unsignedBigInteger('idTeacher');
                $table->timestamps();
                $table->foreign('idTeacher')->references('teacherId')->on('teachers');
            });
        }

        public function down()
        {
            Schema::dropIfExists('subject');
        }
    };
?>