<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Next_Idc_Topic_Report', function (Blueprint $table) {
                $table->increments('nextIdcTopicReportId');
                $table->string('code');
                $table->string('intoduction', 500);
                $table->string('continueTopic', 500);
                $table->string('proposeTopics', 500);
                $table->string('storagePath', 500);
                $table->string('state', 20);
                $table->unsignedBigInteger('idIdc');
                $table->timestamps();
                $table->foreign('idIdc')->references('idcId')->on('Idc')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Next_Idc_Topic_Report');
        }
    };
?>