<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('teams', function (Blueprint $table) {
                $table->increments('teamId');
                $table->dateTime('creationDate');
                $table->integer('integrantQuantity');
                $table->string('state');
                $table->unsignedBigInteger('idTeacher');
                $table->timestamps();
                $table->foreign('idTeacher')->references('teacherId')->on('teachers');
            });
        }

        public function down()
        {
            Schema::dropIfExists('teams');
        }
    };
?>