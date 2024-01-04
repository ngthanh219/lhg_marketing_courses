<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'other_name',
        'other_email',
        'other_phone',
        'book_id',
        'price',
        'discount',
        'discount_price',
        'note',
        'status'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];

    protected $appends = [
        'user_email'
    ];

    public function getUserEmailAttribute()
    {
        $email = null;
        if ($this->user_id) {
            $email = User::find($this->user_id)->email;
        }

        return $email;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y H:i:s");
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
