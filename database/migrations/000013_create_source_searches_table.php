<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('source_searches', function (Blueprint $table) {
                $table->unsignedBigInteger('idTopicSearchReport');
                $table->unsignedBigInteger('idBibliographicSource');
                $table->timestamps();
                $table->foreign('idTopicSearchReport')->references('topicSearchReportId')->on('topic_search_reports');
                $table->foreign('idBibliographicSource')->references('bibliographicSourceId')->on('bibliographic_sources');
            });
        }

        public function down()
        {
            Schema::dropIfExists('source_searches');
        }
    };
?>