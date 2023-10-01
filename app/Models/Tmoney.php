<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmoney extends Model
{
    use HasFactory;

    public function Solde_tmoney()
    {
        return $this->hasOne(Solde_flooz::class, 'solde_tmoney_id');
    }
}
