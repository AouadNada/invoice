<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'type',
        'date',
        'total',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'payment_terms',
        'amount_paid',
        'balance_due',
        'currency',
        'payment_type',
        'payment_status',
        'due_date',
        'po_number',
        'shipping_address',
        'notes',
        'terms',
        'image',
    ];    

  
    public function users()
    {
        return $this->belongsToMany(User::class, 'invoice_user', 'invoice_id', 'user_id');
    }


}
