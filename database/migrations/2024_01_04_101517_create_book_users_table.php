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
        Schema::create('book_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('other_name')->nullable();
            $table->string('other_email')->nullable();
            $table->string('other_phone')->nullable();
            $table->integer('book_id');
            $table->double('price');
            $table->integer('discount')->nullable()->default(0);
            $table->double('discount_price')->nullable()->default(0);
            $table->text('note')->nullable();
            $table->integer('status')->default(Constant::BOOK_USER_PENDING);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_users');
    }
};
