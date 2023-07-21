<?php

namespace App\Models;

use App\Libraries\Constant;
use App\Services\AWSS3Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_section_id',
        'description',
        'source_url',
        'duration',
        'is_show'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];

    public function getSourceUrlAttribute($value)
    {  
        $awsS3Service = new AWSS3Service();

        if ($value) {
            return $awsS3Service->getFile($value, Constant::EXPIRE_VIDEO);
        }

        return null;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id', 'id');
    }
}
