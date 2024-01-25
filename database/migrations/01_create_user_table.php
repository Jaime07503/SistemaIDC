<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('User', function (Blueprint $table) {
                $table->increments('userId');
                $table->string('name', 100);
                $table->string('email', 320)->unique();
                $table->string('avatar', 512)->nullable();
                $table->string('role', 40);
                $table->timestamp('firstLoginPresentCycle')->nullable();
                $table->timestamp('firstLogin')->nullable();
                $table->timestamp('lastLogin')->nullable();
                $table->string('state', 30);
                $table->rememberToken();
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('User');
        }
    };
?>