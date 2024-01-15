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
                $table->string('conclusion', 255);
                $table->string('state', 10);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Conclusion');
        }
    };
?>