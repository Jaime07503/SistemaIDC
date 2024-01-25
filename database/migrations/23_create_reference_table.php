<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Reference', function (Blueprint $table) {
                $table->increments('referenceId');
                $table->string('reference', 300);
                $table->string('studentContribute', 100);
                $table->string('state', 30);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Reference');
        }
    };
?>