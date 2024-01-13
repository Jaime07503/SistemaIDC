<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Student_Subject', function (Blueprint $table) {
                $table->increments('studentSubjectId');
                $table->integer('applicationCount');
                $table->unsignedBigInteger('idStudent');
                $table->unsignedBigInteger('idSubject');
                $table->timestamps();
                $table->foreign('idStudent')->references('studentId')->on('Student')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idSubject')->references('subjectId')->on('Subject')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Student_Subject');
        }
    };
?>