<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Article_Conclusion', function (Blueprint $table) {
                $table->increments('articleConclusionId');
                $table->unsignedBigInteger('idScientificArticleReport');
                $table->unsignedBigInteger('idConclusion');
                $table->timestamps();
                $table->foreign('idScientificArticleReport')->references('scientificArticleReportId')->on('Scientific_Article_Report')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idConclusion')->references('conclusionId')->on('Conclusion')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Article_Conclusion');
        }
    };
?>