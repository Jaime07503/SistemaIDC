<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('bibliographic_sources', function (Blueprint $table) {
                $table->increments('bibliographicSourceId');
                $table->string('bibliographicSourceType');
                $table->string('author');
                $table->string('year');
                $table->string('averageType');
                $table->string('link');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('bibliographic_sources');
        }
    };
?>