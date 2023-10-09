<?php
namespace App\Enums;

use \Spatie\Enum\Enum;

/**
 * @method static self Retrait()
 * @method static self Depot()
 * @method static self Forfait_appel()
 * @method static self Forfait_internet()
 * @method static self CreditSimple()
 * ===============================================
 * @method static self Xpress()
 * @method static self Ria()
 * @method static self Western()
 * @method static self Tmoney()
 * @method static self Flooz()
 */
class TypesClass extends Enum
{
    protected static function values()
    {
        return function(string $name): string|int {

            $traductions = array(
                "Depot" => "Dépot",
                "CreditSimple"=>"Crédit simple"
            );
            return strtr(str_replace("_", ": ", str($name)), $traductions);;
        };
    }
}