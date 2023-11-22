<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('research_topic', function (Blueprint $table) {
                $table->increments('researchTopicId');
                $table->string('themeName');
                $table->string('description', 500);
                $table->string('importanceReginal');
                $table->string('importanceGlobal');
                $table->string('state');
                $table->string('avatar')->nullable();
                $table->unsignedBigInteger('idSubject');
                $table->timestamps();
                $table->foreign('idSubject')->references('subjectId')->on('subject');
            });
        }

        public function down()
        {
            Schema::dropIfExists('research_topic');
        }
    };
?>