<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditTogocell extends Model
{
    use HasFactory;

    public function SoldeCreditTogocell()
    {
        return $this->hasOne(Solde_flooz::class, 'solde_credit_togocell_id');
    }
}
