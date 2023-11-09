<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('team', function (Blueprint $table) {
                $table->increments('teamId');
                $table->dateTime('creationDate');
                $table->integer('integrantQuantity');
                $table->string('state');
                $table->unsignedBigInteger('idResearchTopic');
                $table->unsignedBigInteger('idTeacher');
                $table->timestamps();
                $table->foreign('idResearchTopic')->references('researchTopicId')->on('research_topic');
                $table->foreign('idTeacher')->references('teacherId')->on('teacher');
            });
        }

        public function down()
        {
            Schema::dropIfExists('team');
        }
    };
?>