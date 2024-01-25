<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Scientific_Article_Report', function (Blueprint $table) {
                $table->increments('scientificArticleReportId');
                $table->string('code')->nullable();
                $table->string('spanishSummary', 800)->nullable();
                $table->string('englishSummary', 800)->nullable();
                $table->string('keywords', 200)->nullable();
                $table->string('introduction', 1400)->nullable();
                $table->string('methodology', 500)->nullable();
                $table->string('development', 2500)->nullable();
                $table->string('numberOfWords')->nullable();
                $table->string('storagePath', 300)->nullable();
                $table->string('state', 20)->nullable();
                $table->unsignedBigInteger('idIdc');
                $table->timestamps();
                $table->foreign('idIdc')->references('idcId')->on('Idc')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Scientific_Article_Report');
        }
    };
?>