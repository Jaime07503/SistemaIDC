<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Source_Objetive', function (Blueprint $table) {
                $table->increments('sourceObjetiveId');
                $table->unsignedBigInteger('idTopicSearchReport');
                $table->unsignedBigInteger('idObjetive');
                $table->timestamps();
                $table->foreign('idTopicSearchReport')->references('topicSearchReportId')->on('Topic_Search_Report')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idObjetive')->references('objetiveId')->on('Objetive')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Source_Objetive');
        }
    };
?>