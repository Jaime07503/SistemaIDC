<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Idc', function (Blueprint $table) {
                $table->increments('idcId');
                $table->string('cicle');
                $table->string('year');
                $table->timestamp('endDate');
                $table->string('badgeProcessCompleted', 512)->nullable();
                $table->string('state', 20);
                $table->unsignedBigInteger('idUser');
                $table->unsignedBigInteger('idTeam');
                $table->unsignedBigInteger('idTopicSearchReport');
                $table->unsignedBigInteger('idScientificArticle');
                $table->unsignedBigInteger('idNextIdcTopicReport');
                $table->timestamps();
                $table->foreign('idUser')->references('userId')->on('User')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idTeam')->references('teamId')->on('Team')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idTopicSearchReport')->references('topicSearchReportId')->on('Topic_Search_Report')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idScientificArticle')->references('scientificArticleId')->on('Scientific_Article')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idNextIdcTopicReport')->references('nextIdcTopicReportId')->on('Next_Idc_Topic_Report')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Idc');
        }
    };
?>