<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
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
}
