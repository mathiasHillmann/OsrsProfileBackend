<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;

    public $fillable = [
        'username',
        'account_hash',
        'account_type',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];
}
