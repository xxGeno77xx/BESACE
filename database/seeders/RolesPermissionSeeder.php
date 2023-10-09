<?php

namespace Database\Seeders;

use App\Models\Tmoney;
use App\Models\User;
use App\Models\Xpress;
use App\Support\Classes;
use App\Enums\TypesClass;
use App\Models\CaisseMoov;
use App\Models\Solde_flooz;
use App\Models\SoldeGlobal;
use Illuminate\Support\Str;
use App\Models\Solde_tmoney;
use App\Models\Solde_xpress;
use App\Models\CaisseTogocell;
use App\Models\SoldeCreditMoov;
use Illuminate\Database\Seeder;
use App\Models\commission_flooz;
use App\Models\commission_xpress;
use Spatie\Permission\Models\Role;
use App\Models\SoldeCreditTogocell;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Support\Classes\PermissionsClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const SuperAdmin='Super administrateur';

    public function run(): void
    {
        // $permissions = PermissionsClass::toValues();

        // foreach ($permissions as $key => $name) {
        //     Permission::firstOrCreate([
        //         'name' => $name,
        //     ]);
        // }
        
//==================Users====================================

        $superAdminUser  = User::firstOrCreate([
            "email" => "superadministrateur@laposte.tg",
            'password' => Hash::make('11111111'),
            'name' => 'Super_administrateur',

        ]);

        $soldeTmoeny  = Solde_tmoney::firstOrCreate([
            "Montant" => 150000, 
        ]);

        $soldeGlobal  = SoldeGlobal::firstOrCreate([
            "Montant" => 6000000, 
        ]);

        $soldeFlooz  = Solde_flooz::firstOrCreate([
            "Montant" => 250000, 
        ]);

        $soldeXpress  = Solde_xpress::firstOrCreate([
            "Montant" => 350000, 
        ]);

        $soldeCommissionsXpress  = commission_xpress::firstOrCreate([
            "Montant" => 0, 
        ]);

        $soldeCommissionsXpress  = commission_flooz::firstOrCreate([
            "Montant" => 0, 
        ]);

        $soldeCreditMoov  = SoldeCreditMoov::firstOrCreate([
            "Montant" => 8000, 
        ]);

        $soldeCreditTogocell  = SoldeCreditTogocell::firstOrCreate([
            "Montant" => 17000, 
        ]);

        $soldeCaisseTogocell  = CaisseTogocell::firstOrCreate([
                    "Montant" => 0, 
        ]);

        $soldeCaisseMoov  = CaisseMoov::firstOrCreate([
            "Montant" => 0, 
        ]);

        for($i=0 ;$i<mt_rand(10,20); $i++)
        {
            Xpress::create([
                'Type'=>TypesClass::Retrait()->value,
                'Solde_xpress_restant' =>mt_rand(1,10000),
                'Commission' => mt_rand(5,1000)*mt_rand(0,5),
                'Nom_client' => Str::random(40),
                'Montant' => mt_rand(5,50000),
                'Téléphone' => mt_rand(5,50000),
                'user_id' => 1,
                'created_at'=> now()->subDays(mt_rand(3,6)),
                'updated_at'=> now()->subDays(mt_rand(3,6))->subHours(mt_rand(2,6))

            ]);
        }

        for($i=0 ;$i<mt_rand(10,20); $i++)
        {
            Xpress::create([
                'Type'=>TypesClass::Depot()->value,
                'Solde_xpress_restant' =>mt_rand(1,10000),
                'Commission' => mt_rand(5,1000)*mt_rand(0,5),
                'Nom_client' => Str::random(40),
                'Montant' => mt_rand(5,50000),
                'Téléphone' => mt_rand(5,50000),
                'user_id' => 1,
                'created_at'=> now()->subDays(mt_rand(3,6)),
                'updated_at'=> now()->subDays(mt_rand(3,6))->subHours(mt_rand(2,6))

            ]);
        }
            
        for($i=0 ;$i<mt_rand(10,20); $i++)
        {
            Tmoney::create([
                'Type'=>TypesClass::Retrait()->value,
                'Solde_tmoney_restant' =>mt_rand(1,10000),
                'Commission' => mt_rand(5,1000)*mt_rand(0,5),
                'Montant' => mt_rand(5,50000),
                'Téléphone' => mt_rand(5,50000),
                'user_id' => 1,
                'created_at'=> now()->subDays(mt_rand(3,6))->subHours(mt_rand(2,6)),
                'updated_at'=> now()->subDays(mt_rand(3,6))->subHours(mt_rand(2,6))

            ]);
        }
            
        for($i=0 ;$i<mt_rand(10,20); $i++)
        {
            Tmoney::create([
                'Type'=>TypesClass::Depot()->value,
                'Solde_tmoney_restant' =>mt_rand(1,10000),
                'Commission' => mt_rand(5,1000)*mt_rand(0,5),
                
                'Montant' => mt_rand(5,50000),
                'Téléphone' => mt_rand(5,50000),
                'user_id' => 1,
                'created_at'=> now()->subDays(mt_rand(3,6))->subHours(mt_rand(2,12)),
                'updated_at'=> now()->subDays(mt_rand(3,6))->subHours(mt_rand(2,6))

            ]);
        }
            
        }
        
}
