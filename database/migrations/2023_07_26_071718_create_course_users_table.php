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
        Schema::create('course_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('course_id');
            $table->double('price');
            $table->integer('discount')->nullable()->default(0);
            $table->double('discount_price')->nullable()->default(0);
            $table->text('billing_image')->nullable();
            $table->integer('status')->default(Constant::COURSE_USER_PENDING);
            $table->tinyInteger('is_show')->default(Constant::IS_SHOW);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_users');
    }
};
