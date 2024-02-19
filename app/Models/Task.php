<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'estimated_time',
        'used_time',
        'status',
    ];


    protected static function booted()
    {
        static::addGlobalScope('withUser', function ($builder) {
            $builder->with('user');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
