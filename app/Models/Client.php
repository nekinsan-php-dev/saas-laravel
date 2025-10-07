<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'email',
        'company',
        'tax_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
