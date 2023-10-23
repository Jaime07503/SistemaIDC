<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('research_topics', function (Blueprint $table) {
                $table->increments('researchTopicId');
                $table->string('themeName');
                $table->string('description');
                $table->binary('importanceReginal');
                $table->binary('importanceGlobal');
                $table->string('state');
                $table->binary('avatar')->nullable();
                $table->unsignedBigInteger('idSubject');
                $table->timestamps();
                $table->foreign('idSubject')->references('subjectId')->on('subject');
            });
        }

        public function down()
        {
            Schema::dropIfExists('research_topics');
        }
    };
?>