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
                $table->string('code');
                $table->string('spanishSummary', 500);
                $table->string('englishSummary', 500);
                $table->string('keywords', 500);
                $table->string('introduction', 500);
                $table->string('methodology', 500);
                $table->string('development', 500);
                $table->string('conclusion', 500);
                $table->string('bibliographicReferences', 500);
                $table->string('numberOfWords');
                $table->string('storagePath');
                $table->string('state', 20);
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