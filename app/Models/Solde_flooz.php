<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solde_flooz extends Model
{
    use HasFactory;

    public function Flooz()
    {
        return $this->hasMany(Flooz::class);
    }
}
