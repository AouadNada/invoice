<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_user extends Model
{
    use HasFactory;

    protected $table = 'invoice_user';

    protected $fillable = [
        'invoice_id',
        'user_id',
    ];  
}
