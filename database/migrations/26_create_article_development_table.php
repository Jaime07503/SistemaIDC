<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Article_Development', function (Blueprint $table) {
                $table->increments('articleDevelopmentId');
                $table->unsignedBigInteger('idScientificArticleReport');
                $table->unsignedBigInteger('idDevelopment');
                $table->timestamps();
                $table->foreign('idScientificArticleReport')->references('scientificArticleReportId')->on('Scientific_Article_Report')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idDevelopment')->references('developmentId')->on('Development')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Article_Development');
        }
    };
?>