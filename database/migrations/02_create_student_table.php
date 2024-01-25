<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Student', function (Blueprint $table) {
                $table->increments('studentId');
                $table->string('carnet', 11)->unique();
                $table->string('career', 200)->nullable();
                $table->string('state', 30)->nullable();
                $table->unsignedBigInteger('idUser');
                $table->timestamps();
                $table->foreign('idUser')->references('userId')->on('User')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Student');
        }
    };
?>