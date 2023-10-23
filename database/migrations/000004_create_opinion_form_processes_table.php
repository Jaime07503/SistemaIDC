<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('opinion_form_processes', function (Blueprint $table) {
                $table->increments('opinionFormProcessId');
                $table->string('opinionIdcProcess');
                $table->string('improvementOpportunity');
                $table->string('state');
                $table->unsignedBigInteger('idUser');
                $table->timestamps();
                $table->foreign('idUser')->references('userId')->on('users');
            });
        }

        public function down()
        {
            Schema::dropIfExists('opinion_form_processes');
        }
    };
?>