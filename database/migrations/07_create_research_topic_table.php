<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Research_Topic', function (Blueprint $table) {
                $table->increments('researchTopicId');
                $table->string('themeName', 80);
                $table->string('description', 500);
                $table->string('avatar', 512)->nullable();
                $table->string('importanceRegional', 512);
                $table->string('importanceGlobal', 512);
                $table->string('state', 25);
                $table->unsignedBigInteger('idSubject');
                $table->timestamps();
                $table->foreign('idSubject')->references('subjectId')->on('Subject')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Research_Topic');
        }
    };
?>