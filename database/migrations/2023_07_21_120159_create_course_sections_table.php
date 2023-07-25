<?php

use App\Libraries\Constant;
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
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->text('name')->nullable();
            $table->text('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_show')->default(Constant::IS_NOT_SHOW);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sections');
    }
};
