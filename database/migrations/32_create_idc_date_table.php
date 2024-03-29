<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Idc_Date', function (Blueprint $table) {
                $table->increments('dateId');
                $table->timestamp('startDateSearchReport');
                $table->timestamp('endDateSearchReport');
                $table->timestamp('startDateScientificArticleReport');
                $table->timestamp('endDateScientificArticleReport');
                $table->timestamp('startDateNextIdcTopic');
                $table->timestamp('endDateNextIdcTopic');
                $table->unsignedBigInteger('idCycle');
                $table->timestamps();
                $table->foreign('idCycle')->references('cycleId')->on('Cycle')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Idc_Date');
        }
    };
?>