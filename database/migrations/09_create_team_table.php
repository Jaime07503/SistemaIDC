<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Team', function (Blueprint $table) {
                $table->increments('teamId');
                $table->timestamp('creationDate');
                $table->integer('integrantQuantity');
                $table->string('state', 30);
                $table->unsignedBigInteger('idResearchTopic');
                $table->unsignedBigInteger('idTeacher');
                $table->timestamps();
                $table->foreign('idResearchTopic')->references('researchTopicId')->on('Research_Topic')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idTeacher')->references('teacherId')->on('Teacher')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Team');
        }
    };
?>