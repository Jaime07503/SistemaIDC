<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('student_research_topic', function (Blueprint $table) {
                $table->increments('idStudentResearchTopic');
                $table->unsignedBigInteger('idStudent');
                $table->unsignedBigInteger('idResearchTopic');
                $table->string('state');
                $table->timestamps();
                $table->foreign('idStudent')->references('studentId')->on('student');
                $table->foreign('idResearchTopic')->references('researchTopicId')->on('research_topic');
            });
        }

        public function down()
        {
            Schema::dropIfExists('student_research_topic');
        }
    };
?>