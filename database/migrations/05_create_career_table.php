<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Career', function (Blueprint $table) {
                $table->increments('careerId');
                $table->string('nameCareer', 200);
                $table->unsignedBigInteger('idFaculty');
                $table->timestamps();
                $table->foreign('idFaculty')->references('facultyId')->on('Faculty')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Career');
        }
    };
?>