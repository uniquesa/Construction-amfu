<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('attachments', function (Blueprint $table) {
    $table->id();
    
    // ✅ Agar tumhari main table ka naam `request_entries` hai:
    $table->foreignId('request_id')
          ->constrained('request_entries') // not 'requests'
          ->onDelete('cascade');
    
    $table->string('file_path');
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
