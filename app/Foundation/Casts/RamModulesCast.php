<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 2.11.20
 * Time: 9:23 PM
 */

namespace Framework\Foundation\Casts;

use Framework\Data\Collections\RamModules;
use Framework\Data\ValueObjects\RamModuleType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class RamModulesCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return \App\Models\Address
     */
    public function get($model, $key, $value, $attributes)
    {
        $ramModules = json_decode($attributes['ram_modules']);
        $collection = new RamModules();
        foreach ($ramModules as $ramModule) {
            $collection->add(new RamModule($ramModule->size, new RamModuleType($ramModule->type)));
        }
        return $collection;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Illuminate\Contracts\Database\Eloquent\string|string $key
     * @param mixed $value
     * @param array $attributes
     * @return array|mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        if (! $value instanceof RamModules) {
            throw new InvalidArgumentException('The given value is not an RamModule instance.');
        }

        return [
            'ram_modules' => json_encode($value->toArray()),
        ];
    }
}
