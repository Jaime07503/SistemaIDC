<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('student_team', function (Blueprint $table) {
                $table->unsignedBigInteger('idStudent');
                $table->unsignedBigInteger('idTeam');
                $table->timestamps();
                $table->foreign('idStudent')->references('studentId')->on('student');
                $table->foreign('idTeam')->references('teamId')->on('team');
            });
        }

        public function down()
        {
            Schema::dropIfExists('student_team');
        }
    };
?>