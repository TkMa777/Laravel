<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'picture_url', 'last_name', 'first_name', 'species', 'gender', 'status', 'origin', 'episodes'
    ];

    protected $casts = [
        'episodes' => 'array',
    ];
}
