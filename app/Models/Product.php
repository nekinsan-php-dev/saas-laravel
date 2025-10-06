<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'description',
        'price',
        'sku',
        'status' //enum, active,inactive
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
