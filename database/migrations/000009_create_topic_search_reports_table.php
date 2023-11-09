<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('topic_search_report', function (Blueprint $table) {
                $table->increments('topicSearchReportId');
                $table->string('teamOrientation');
                $table->string('searchPlan');
                $table->string('meetingReport')->nullable();
                $table->string('generalObjetive');
                $table->string('specificsObjetives');
                $table->string('criteria');
                $table->string('coordinatorAssessment');
                $table->string('evaluationRubric');
                $table->string('deadLine');
                $table->string('storagePath');
                $table->string('state');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('topic_search_report');
        }
    };
?>