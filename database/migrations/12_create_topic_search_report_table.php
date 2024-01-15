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
                $table->string('code');
                $table->string('introduction', 500);
                $table->string('induction', 500);
                $table->string('teamBehavior', 500);
                $table->string('searchPlan', 500);
                $table->string('meetings', 500);
                $table->string('objetiveInformation', 500);
                $table->string('teamValoration', 500);
                $table->string('teacherComment', 500);
                $table->string('finalComment', 500);
                $table->string('storagePath');
                $table->string('state');
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