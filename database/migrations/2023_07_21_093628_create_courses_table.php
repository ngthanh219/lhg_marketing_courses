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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('slug')->unique()->nullable();
            $table->text('slogan')->nullable();
            $table->text('introduction')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->double('price');
            $table->integer('discount')->nullable()->default(0);
            $table->double('discount_price')->nullable()->default(0);
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
        Schema::dropIfExists('courses');
    }
};
