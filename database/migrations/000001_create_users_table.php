<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('userId');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('avatar')->nullable();
                $table->string('role');
                $table->timestamp('first_login_present_cycle')->nullable();
                $table->timestamp('first_login_at')->nullable();
                $table->timestamp('last_login_at')->nullable();
                $table->string('state');
                $table->string('external_id');
                $table->string('external_auth');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('users');
        }
    };
?>