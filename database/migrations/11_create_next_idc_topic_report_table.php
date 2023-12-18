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
                $table->string('subject', 80);
                $table->string('lastUpdate');
                $table->string('importanceRegional', 512);
                $table->string('importanceGlobal', 512);
                $table->string('justificationKnowledge', 500);
                $table->string('opinionIdcProcess', 500);
                $table->string('improvementOpportunity', 500);
                $table->string('state', 20);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Next_Idc_Topic_Report');
        }
    };
?>