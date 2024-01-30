<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
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

    public function getImageAttribute($value)
    {
        return $value != null ? json_decode($value, true) : [];
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }
}
