<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_topics', function (Blueprint $table) {
            $table->increments('researchTopicId');
            $table->string('themeName');
            $table->string('description');
            $table->binary('importanceReginal');
            $table->binary('importanceGlobal');
            $table->string('state');
            $table->timestamps();
            $table->unsignedBigInteger('idSubject');
            $table->foreign('idSubject')->references('subjectId')->on('subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_topics');
    }
};
