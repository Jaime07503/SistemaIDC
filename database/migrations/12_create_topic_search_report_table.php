<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Topic_Search_Report', function (Blueprint $table) {
                $table->increments('topicSearchReportId');
                $table->string('code')->nullable();
                $table->string('orientation', 800)->nullable();
                $table->string('induction', 1150)->nullable();
                $table->string('searchPlan', 700)->nullable();
                $table->string('meetings', 500)->nullable();
                $table->string('criteria', 350)->nullable();
                $table->string('teamValoration', 800)->nullable();
                $table->string('teamComment', 300)->nullable();
                $table->string('finalComment', 1000)->nullable();
                $table->string('storagePath', 300)->nullable();
                $table->string('state', 30)->nullable();
                $table->unsignedBigInteger('idIdc');
                $table->timestamps();
                $table->foreign('idIdc')->references('idcId')->on('Idc')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Topic_Search_Report');
        }
    };
?>