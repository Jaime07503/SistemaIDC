<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Teacher', function (Blueprint $table) {
                $table->increments('teacherId');
                $table->string('contractType', 50);
                $table->string('specialty', 200);
                $table->string('title', 20);
                $table->integer('idcQuantity');
                $table->unsignedBigInteger('idUser');
                $table->timestamps();
                $table->foreign('idUser')->references('userId')->on('User')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Teacher');
        }
    };
?>