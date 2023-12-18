<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Scientific_Article', function (Blueprint $table) {
                $table->increments('scientificArticleId');
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
                $table->string('state', 20);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Scientific_Article');
        }
    };
?>