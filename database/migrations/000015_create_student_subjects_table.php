<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('student_subject', function (Blueprint $table) {
                $table->unsignedBigInteger('idStudent');
                $table->unsignedBigInteger('idSubject');
                $table->timestamps();
                $table->foreign('idStudent')->references('studentId')->on('student');
                $table->foreign('idSubject')->references('subjectId')->on('subject');
            });
        }

        public function down()
        {
            Schema::dropIfExists('student_subject');
        }
    };
?>