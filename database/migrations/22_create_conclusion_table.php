<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Conclusion', function (Blueprint $table) {
                $table->increments('conclusionId');
                $table->string('conclusion', 400);
                $table->string('studentContribute', 200);
                $table->string('state', 30);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Conclusion');
        }
    };
?>