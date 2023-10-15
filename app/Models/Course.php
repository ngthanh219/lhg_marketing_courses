<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'slogan',
        'introduction',
        'description',
        'image',
        'price',
        'discount',
        'discount_price',
        'is_show'
    ];

    protected $hidden = [
        'image',
        'deleted_at',
        'updated_at'
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        return $this->image != null ? (config('base.image_url') . $this->image) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function courseSections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'id');
    }

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class, 'course_id', 'id');
    }
}
