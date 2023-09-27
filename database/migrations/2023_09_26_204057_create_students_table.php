<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('studentId');
            $table->string('licenseNumber');
            $table->string('career');
            $table->string('studentCycle');
            $table->string('studentYear');
            $table->string('enrolledSubject');
            $table->string('previousIDC');
            $table->string('state');
            $table->unsignedBigInteger('idUser');
            $table->timestamps();
            $table->foreign('idUser')->references('userId')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
