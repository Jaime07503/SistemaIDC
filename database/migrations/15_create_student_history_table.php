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
                $table->string('enrolledSubject', 12);
                $table->string('subjectApply', 200);
                $table->string('previousIdc', 200)->nullable();
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