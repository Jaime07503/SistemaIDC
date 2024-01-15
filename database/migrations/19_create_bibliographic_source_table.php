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
                $table->string('theme');
                $table->string('author');
                $table->string('year');
                $table->string('averageType');
                $table->string('studentContribute');
                $table->string('link');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Bibliographic_Source');
        }
    };
?>