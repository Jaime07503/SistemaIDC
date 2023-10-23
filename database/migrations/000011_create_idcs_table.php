<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('idcs', function (Blueprint $table) {
                $table->increments('idcId');
                $table->string('cicle');
                $table->string('year');
                $table->dateTime('endDate');
                $table->string('badgeProcessCompleted')->nullable();
                $table->string('state');
                $table->unsignedBigInteger('idResearchTopic');
                $table->unsignedBigInteger('idTeam');
                $table->unsignedBigInteger('idUser');
                $table->unsignedBigInteger('idTopicSearchReport');
                $table->unsignedBigInteger('idBibliographicArticle');
                $table->timestamps();
                $table->foreign('idResearchTopic')->references('researchTopicId')->on('research_topics');
                $table->foreign('idTeam')->references('teamId')->on('teams');
                $table->foreign('idUser')->references('userId')->on('users');
                $table->foreign('idTopicSearchReport')->references('topicSearchReportId')->on('topic_search_reports');
                $table->foreign('idBibliographicArticle')->references('bibliographicArticleId')->on('bibliographic_articles');
            });
        }

        public function down()
        {
            Schema::dropIfExists('idcs');
        }
    };
?>