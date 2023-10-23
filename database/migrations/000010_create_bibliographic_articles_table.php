<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('bibliographic_articles', function (Blueprint $table) {
                $table->increments('bibliographicArticleId');
                $table->string('spanishSummary');
                $table->string('englishSummary');
                $table->string('keywords');
                $table->string('introduction');
                $table->string('methodology');
                $table->string('development');
                $table->string('conclusion');
                $table->string('bibliographicReferences');
                $table->string('numberOfWords');
                $table->string('deadLine');
                $table->string('storagePath');
                $table->string('state');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('bibliographic_articles');
        }
    };
?>