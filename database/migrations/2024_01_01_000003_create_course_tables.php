<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('type', ['free', 'paid'])->default('free');
            $table->enum('language_category', ['mandarin', 'indonesia']);
            $table->timestamps();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->enum('content_type', ['video', 'ebook', 'text']);
            $table->string('title');
            $table->string('file_url')->nullable();
            $table->text('content_body')->nullable();
            $table->boolean('is_locked')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
        Schema::dropIfExists('courses');
    }
};
