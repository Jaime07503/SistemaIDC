<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Cycle', function (Blueprint $table) {
                $table->increments('cycleId');
                $table->string('cycle', 40);
                $table->string('state', 30);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Cycle');
        }
    };
?>