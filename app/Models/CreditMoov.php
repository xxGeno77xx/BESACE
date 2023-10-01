<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditMoov extends Model
{
    use HasFactory;

    public function Solde_flooz()
    {
        return $this->hasOne(Solde_flooz::class, 'solde_credit_moov_id');
    }
}
