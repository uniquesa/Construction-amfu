<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('request_entries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['Pending','Under_Review','Approved','Rejected'])->default('Pending');
            $table->enum('current_level', ['PM','FCO','PMO','CSO'])->default('PM');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relation with users
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_entries');
    }
};
