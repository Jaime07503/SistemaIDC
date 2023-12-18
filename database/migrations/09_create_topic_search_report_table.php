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
                $table->string('teamOrientation');
                $table->string('searchPlan');
                $table->string('meetings');
                $table->string('generalObjetive');
                $table->string('specificsObjetives', 1500);
                $table->string('coordinatorAssessment');
                $table->timestamp('deadLine');
                $table->string('storagePath');
                $table->string('state');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Topic_Search_Report');
        }
    };
?>