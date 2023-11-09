<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('user', function (Blueprint $table) {
                $table->increments('userId');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('avatar')->nullable();
                $table->string('role');
                $table->timestamp('firstLoginPresentCycle')->nullable();
                $table->timestamp('firstLogin')->nullable();
                $table->timestamp('lastLogin')->nullable();
                $table->string('state');
                $table->string('externalId')->nullable();
                $table->string('externalAuth')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('user');
        }
    };
?>