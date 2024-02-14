<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Bibliographic_Source', function (Blueprint $table) {
                $table->increments('bibliographicSourceId');
                $table->string('theme', 300);
                $table->string('author', 400);
                $table->string('year', 4);
                $table->string('averageType', 150);
                $table->string('source', 100);
                $table->string('link', 1000);
                $table->integer('studentContribute');
                $table->string('state', 30);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Bibliographic_Source');
        }
    };
?>