<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Subject', function (Blueprint $table) {
                $table->increments('subjectId');
                $table->string('code', 80);
                $table->string('nameSubject', 200);
                $table->string('section', 1);
                $table->string('approvedIdc', 30);
                $table->string('state', 30);
                $table->string('avatar', 512)->nullable();
                $table->unsignedBigInteger('idCycle');
                $table->unsignedBigInteger('idCareer');
                $table->unsignedBigInteger('idTeacher');
                $table->timestamps();
                $table->foreign('idCycle')->references('cycleId')->on('Cycle')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idTeacher')->references('teacherId')->on('Teacher')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idCareer')->references('careerId')->on('Career')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Subject');
        }
    };
?>