<?php

namespace App\Models;

use App\Libraries\Constant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'role_id',
        'name',
        'phone',
        'email',
        'password',
        'verification_code',
        'verification_code_at',
        'email_verified_at',
        'is_login'
    ];

    protected $hidden = [
        'password',
        'email_verified_at',
        'deleted_at',
        'updated_at'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class, 'user_id', 'id');
    }
}
