<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Idc_Comment', function (Blueprint $table) {
                $table->increments('idcCommentId');
                $table->unsignedBigInteger('idIdc');
                $table->unsignedBigInteger('idComment');
                $table->timestamps();
                $table->foreign('idIdc')->references('idcId')->on('Idc')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('idComment')->references('commentId')->on('Comment')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Idc_Comment');
        }
    };
?>