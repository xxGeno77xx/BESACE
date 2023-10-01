<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldeCreditTogocell extends Model
{
    use HasFactory;

    public function CreditTogocell()
    {
        return $this->hasMany(CreditTogocell::class);
    }
}
