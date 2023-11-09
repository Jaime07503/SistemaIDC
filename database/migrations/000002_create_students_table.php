<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('student', function (Blueprint $table) {
                $table->increments('studentId');
                $table->string('carnet')->unique();
                $table->string('career');
                $table->string('studentCycle');
                $table->string('studentYear');
                $table->string('enrolledSubject');
                $table->string('previousIDC')->nullable();
                $table->string('state');
                $table->unsignedBigInteger('idUser');
                $table->timestamps();
                $table->foreign('idUser')->references('userId')->on('user');
            });
        }

        public function down()
        {
            Schema::dropIfExists('student');
        }
    };
?>