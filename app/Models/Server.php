<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'host',
        'description',
        'image',
        'position'
    ];

    protected $casts = [
        'position' => 'integer'
    ];
}