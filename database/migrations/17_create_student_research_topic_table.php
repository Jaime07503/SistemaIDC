<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Student_Research_Topic', function (Blueprint $table) {
                $table->increments('studentResearchTopicId');
                $table->string('state', 30);
                $table->unsignedBigInteger('idStudent');
                $table->unsignedBigInteger('idResearchTopic');
                $table->timestamps();
                $table->foreign('idStudent')->references('studentId')->on('Student')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idResearchTopic')->references('researchTopicId')->on('Research_Topic')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Student_Research_Topic');
        }
    };
?>