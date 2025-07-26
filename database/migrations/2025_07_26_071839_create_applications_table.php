<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->unique()->nullable(false);
            $table->date('date');
            $table->string('location');
            $table->string('name');
            $table->string('father_name');
            $table->text('address');
            $table->string('mobile');
            $table->string('gmail');
            $table->string('aadhar');
            $table->string('pan')->nullable();
            $table->string('bank_account_no');
            $table->string('ifsc');
            $table->string('education');
            $table->string('experience');
            $table->string('apply_job');
            $table->string('photo_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};