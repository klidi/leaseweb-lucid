<?php

namespace Framework\Data;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Framework\Data\Contracts\HasValidationRules;
use Framework\Foundation\Casts\RamModulesCast;
use Framework\Foundation\Casts\PriceCast;
use Illuminate\Database\Eloquent\Model;

class Server extends Model implements HasValidationRules
{
    protected $fillable = [
        'asset_id', 'user_id', 'name', 'brand_id'
    ];

    protected $casts = [
        'price' => PriceCast::class,
        'ram_modules' => RamModulesCast::class,
    ];

    private static array $rules = [
        'asset_id' => ['required', 'unique:servers', 'integer'],
        'name' => ['required', 'string', 'max:30', 'min:3'],
        'brand_id' => ['required', 'integer', 'exists:brands,id'],
        'price' => ['required', 'array', 'size:2'],
        'ram_modules' => ['required', 'array', 'min:1'],
    ];

    public static function getValidationRules() : array
    {
        return self::$rules;
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo('Framework\Data\User');
    }

    public function brand() : BelongsTo
    {
        return $this->belongsTo('Framework\Data\Brand');
    }

    public static function createPriceInstance()
    {

    }
}
