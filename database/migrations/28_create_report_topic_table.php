<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Report_Topic', function (Blueprint $table) {
                $table->increments('reportTopicId');
                $table->unsignedBigInteger('idNextIdcTopicReport');
                $table->unsignedBigInteger('idTopic');
                $table->timestamps();
                $table->foreign('idNextIdcTopicReport')->references('nextIdcTopicReportId')->on('Next_Idc_Topic_Report')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idTopic')->references('topicId')->on('Topic')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Report_Topic');
        }
    };
?>