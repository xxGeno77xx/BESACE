<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ria extends Model
{
    use HasFactory;
    protected $casts = [
        'Montant' =>  'array',
    ];
}
