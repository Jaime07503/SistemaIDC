<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Topic', function (Blueprint $table) {
                $table->increments('topicId');
                $table->string('nameTopic', 200);
                $table->string('subjectRelevance', 500);
                $table->string('globalUpdateImg', 512);
                $table->string('localUpdateImg', 512);
                $table->string('updatedInformation', 400);
                $table->string('localRelevance', 400);
                $table->string('globalRelevance', 500);
                $table->string('studentContribute', 200);
                $table->string('state', 30);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Topic');
        }
    };
?>