<?php

namespace App\Models;

use App\Enums\RunescapeAccountTypes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Player extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_hash';
    public $incrementing = false;

    public $fillable = [
        'account_hash',
        'username',
        'account_type',
        'data',
        'views'
    ];

    protected $casts = [
        'data' => 'array',
        'account_type' => RunescapeAccountTypes::class,
    ];

    protected function model(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::exists("models/{$this->account_hash}.ply")
                ? Storage::url("models/{$this->account_hash}.ply")
                : Storage::url("models/default.ply"),
        );
    }
}
