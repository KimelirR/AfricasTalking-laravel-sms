<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfricaTalk extends Model
{
    use HasFactory;

    protected $fillable = [
        'to',
        'message',
        'delivery_status',
    ];
}
