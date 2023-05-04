<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shared_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('users');
            $table->foreignId('to_user_id')->constrained('users');
            $table->foreignId('contact_id')->constrained('contacts');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
        });
    }
};
