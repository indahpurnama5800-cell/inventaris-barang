<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('action')->comment('create, update, delete, import, export');
            $table->string('subject_type');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('audit_logs'); }
};
