<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Student_History', function (Blueprint $table) {
                $table->increments('studentHistoryId');
                $table->decimal('cum', 3, 1);
                $table->string('studentCycle', 25);
                $table->string('studentYear', 25);
                $table->string('enrolledSubject', 11);
                $table->string('subjectApply', 80);
                $table->string('previousIdc', 80)->nullable();
                $table->unsignedBigInteger('idStudent');
                $table->timestamps();
                $table->foreign('idStudent')->references('studentId')->on('Student')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Student_History');
        }
    };
?>