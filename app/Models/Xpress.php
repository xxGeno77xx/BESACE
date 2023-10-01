<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xpress extends Model
{
    use HasFactory;

    public function Solde_xpress()
    {
        return $this->hasOne(Solde_flooz::class, 'solde_Xpress_id');
    }
}
