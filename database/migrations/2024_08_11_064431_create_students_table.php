<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('register_date');
            $table->string('effective_date_of_certificate');
            $table->string('registration_no')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('certificate_no')->nullable();
            $table->string('full_name_of_student');
            $table->string('name_with_initial');
            $table->string('nic_no');
            $table->string('address');
            $table->string('course_name')->nullable();
            $table->string('year')->nullable();
            $table->string('picture')->nullable();
            $table->integer('batch_id')->unsigned();
            $table->string('session_id')->nullable();
            $table->timestamps();

             // ForeignKey
             $table->foreign('batch_id')->references('id')->on('batches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
