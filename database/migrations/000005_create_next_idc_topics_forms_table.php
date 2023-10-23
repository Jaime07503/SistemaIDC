<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('next_idc_topics_forms', function (Blueprint $table) {
                $table->increments('nextIdcTopicFormId');
                $table->string('subject');
                $table->string('lastUpdate');
                $table->binary('regionalImportance');
                $table->binary('globalImportance');
                $table->string('justificationKnowledge');
                $table->string('state');
                $table->unsignedBigInteger('idStudent');
                $table->timestamps();
                $table->foreign('idStudent')->references('studentId')->on('students');
            });
        }

        public function down()
        {
            Schema::dropIfExists('next_idc_topics_forms');
        }
    };
?>