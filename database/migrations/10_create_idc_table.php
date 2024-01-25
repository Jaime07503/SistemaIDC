<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Idc', function (Blueprint $table) {
                $table->increments('idcId');
                $table->timestamp('startDateSearchReport');
                $table->timestamp('endDateSearchReport');
                $table->timestamp('startDateScientificArticleReport');
                $table->timestamp('endDateScientificArticleReport');
                $table->timestamp('startDateNextIdcTopic');
                $table->timestamp('endDateNextIdcTopic');
                $table->string('badgeProcessCompleted', 512)->nullable();
                $table->string('state', 30);
                $table->unsignedBigInteger('idUser');
                $table->unsignedBigInteger('idTeam');
                $table->timestamps();
                $table->foreign('idUser')->references('userId')->on('User')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idTeam')->references('teamId')->on('Team')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Idc');
        }
    };
?>