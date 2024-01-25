<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('Faculty', function (Blueprint $table) {
                $table->increments('facultyId');
                $table->string('nameFaculty', 200);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('Faculty');
        }
    };
?>