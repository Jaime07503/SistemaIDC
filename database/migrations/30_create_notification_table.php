<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Notification', function (Blueprint $table) {
                $table->increments('notificationId');
                $table->string('notification', 150);
                $table->string('state', 30);
                $table->unsignedBigInteger('idUser');
                $table->timestamps();
                $table->foreign('idUser')->references('userId')->on('User')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('Notification');
        }
    };
?>