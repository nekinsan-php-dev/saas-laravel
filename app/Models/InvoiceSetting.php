<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    protected $fillable = [
        'user_id',
        'default_currency',
        'default_language',
        'invoice_prefix',
        'next_invoice_number',
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
        'company_tax_number',
        'footer_notes',
        'terms_conditions',
        'digital_signature',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
