<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solde_xpress extends Model
{
    use HasFactory;

    public function Xpress()
    {
        return $this->hasMany(Xpress::class);
    }
}
