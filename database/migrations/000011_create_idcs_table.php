<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('idc', function (Blueprint $table) {
                $table->increments('idcId');
                $table->string('cicle');
                $table->string('year');
                $table->dateTime('endDate');
                $table->string('badgeProcessCompleted')->nullable();
                $table->string('state');
                $table->unsignedBigInteger('idTeam');
                $table->unsignedBigInteger('idUser');
                $table->unsignedBigInteger('idTopicSearchReport');
                $table->unsignedBigInteger('idBibliographicArticle');
                $table->timestamps();
                $table->foreign('idTeam')->references('teamId')->on('team');
                $table->foreign('idUser')->references('userId')->on('user');
                $table->foreign('idTopicSearchReport')->references('topicSearchReportId')->on('topic_search_report');
                $table->foreign('idBibliographicArticle')->references('bibliographicArticleId')->on('bibliographic_article');
            });
        }

        public function down()
        {
            Schema::dropIfExists('idc');
        }
    };
?>