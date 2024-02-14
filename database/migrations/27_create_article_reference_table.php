<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Article_Reference', function (Blueprint $table) {
                $table->increments('articleReferenceId');
                $table->unsignedBigInteger('idScientificArticleReport');
                $table->unsignedBigInteger('idReference');
                $table->timestamps();
                $table->foreign('idScientificArticleReport')->references('scientificArticleReportId')->on('Scientific_Article_Report')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idReference')->references('referenceId')->on('Reference')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('article_references');
        }
    };
?>