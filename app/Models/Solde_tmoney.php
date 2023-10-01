<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solde_tmoney extends Model
{
    use HasFactory;

    public function Tmoney()
    {
        return $this->hasMany(Tmoney::class);
    }
}
