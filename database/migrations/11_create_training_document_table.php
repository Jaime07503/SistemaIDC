<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Training_Document', function (Blueprint $table) {
                $table->increments('trainingDocumentId');
                $table->string('nameDocument', 80);
                $table->string('documentType', 80);
                $table->string('type', 80);
                $table->string('state', 30);
                $table->unsignedBigInteger('idIdc');
                $table->timestamps();
                $table->foreign('idIdc')->references('idcId')->on('Idc')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Training_Document');
        }
    };
?>