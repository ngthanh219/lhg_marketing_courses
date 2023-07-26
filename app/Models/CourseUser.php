<?php

namespace App\Models;

use App\Libraries\Constant;
use App\Services\AWSS3Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'price',
        'discount',
        'discount_price',
        'billing_image',
        'status',
        'is_show',
    ];

    protected $hidden = [
        'billing_image',
        'deleted_at',
        'updated_at'
    ];

    protected $appends = [
        'billing_image_url',
        'user_email',
        'course_name',
    ];

    public function getBillingImageUrlAttribute()
    {
        $awsS3Service = new AWSS3Service();

        if ($this->billing_image) {
            return $awsS3Service->getFile($this->billing_image, Constant::EXPIRE_IMAGE);
        }

        return null;
    }

    public function getUserEmailAttribute()
    {
        return User::find($this->user_id)->email;
    }

    public function getCourseNameAttribute()
    {
        return Course::find($this->course_id)->name;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
