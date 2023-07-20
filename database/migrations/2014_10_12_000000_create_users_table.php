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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id')->default(Constant::ROLE_CLIENT);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->timestamp("verification_code_at")->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('is_login')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
