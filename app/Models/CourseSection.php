<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'name',
        'description',
        'is_show'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];

    protected $appends = [
        'course_name',
    ];

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

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'course_section_id', 'id');
    }
}
