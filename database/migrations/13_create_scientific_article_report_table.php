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
                $table->timestamp('creationDate')->nullable();
                $table->string('spanishSummary', 850)->nullable();
                $table->string('englishSummary', 850)->nullable();
                $table->string('keywords', 160)->nullable();
                $table->string('introduction', 1450)->nullable();
                $table->string('methodology', 500)->nullable();
                $table->string('subtitle', 4000)->nullable();
                $table->string('secondSubtitle', 4000)->nullable();
                $table->string('thirdSubtitle', 4000)->nullable();
                $table->integer('numberOfWords')->nullable();  
                $table->string('storagePath', 300)->nullable();
                $table->string('nameDocumentImage', 200)->nullable();
                $table->string('documentImageStoragePath', 300)->nullable();
                $table->string('nameCorrectDocument', 200)->nullable();
                $table->string('correctDocumentStoragePath', 300)->nullable();
                $table->string('nameCorrectedDocument', 200)->nullable();
                $table->string('correctedDocumentStoragePath', 300)->nullable();
                $table->string('state', 30)->nullable();
                $table->string('previousState', 30)->nullable();
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