<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Source_Search', function (Blueprint $table) {
                $table->increments('sourceSearchId');
                $table->unsignedBigInteger('idTopicSearchReport');
                $table->unsignedBigInteger('idBibliographicSource');
                $table->timestamps();
                $table->foreign('idTopicSearchReport')->references('topicSearchReportId')->on('Topic_Search_Report')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idBibliographicSource')->references('bibliographicSourceId')->on('Bibliographic_Source')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Source_Search');
        }
    };
?>