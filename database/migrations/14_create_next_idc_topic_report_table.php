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
                $table->string('code')->nullable();
                $table->string('introduction', 400)->nullable();
                $table->string('continueTopic', 850)->nullable();
                $table->string('proposeTopics', 850)->nullable();
                $table->string('conclusion', 800)->nullable();
                $table->string('storagePath', 300)->nullable();
                $table->string('state', 30)->nullable();
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