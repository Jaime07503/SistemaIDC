<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Student_Team', function (Blueprint $table) {
                $table->increments('studentTeamId');
                $table->unsignedBigInteger('idStudent');
                $table->unsignedBigInteger('idTeam');
                $table->timestamps();
                $table->foreign('idStudent')->references('studentId')->on('Student')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idTeam')->references('teamId')->on('Team')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Student_Team');
        }
    };
?>