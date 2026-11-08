<?php

namespace App\Models;

use Framework\Core\Model;

/**
 * Class Car
 *
 * Databázová entita auta v garáži. Mapuje sa na tabuľku `cars` (názov tabuľky sa odvodí z názvu triedy).
 *
 * @package App\Models
 */
class Car extends Model
{
    /** Stĺpec v DB `power_kw` sa v modeli volá `powerKw`. */
    protected static array $columnsMap = ['power_kw' => 'powerKw'];

    /** Vlastnosti, ktoré sa smú nastaviť z formulára (ochrana pred mass assignmentom). */
    protected static ?array $fillable = ['brand', 'model', 'year', 'engine', 'powerKw', 'description'];

    public ?int $id = null;
    public ?string $brand = null;
    public ?string $model = null;
    public ?int $year = null;
    public ?string $engine = null;
    public ?int $powerKw = null;
    public ?string $description = null;
}
