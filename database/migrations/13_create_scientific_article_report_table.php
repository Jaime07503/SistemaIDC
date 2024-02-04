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