<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_hash';
    public $incrementing = false;

    public $fillable = [
        'account_hash',
        'username',
        'account_type',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];
}
