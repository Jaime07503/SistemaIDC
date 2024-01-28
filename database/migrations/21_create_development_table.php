<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Development', function (Blueprint $table) {
                $table->increments('developmentId');
                $table->string('subtitle', 100);
                $table->string('content', 4000);
                $table->string('studentContribute', 200);
                $table->string('state', 30);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Development');
        }
    };
?>