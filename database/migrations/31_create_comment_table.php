<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Comment', function (Blueprint $table) {
                $table->increments('commentId');
                $table->string('commentsIdc', 500);
                $table->string('opportunityForImprovements', 500)->nullable();
                $table->string('whoContributes', 200);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Comment');
        }
    };
?>