<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 2.11.20
 * Time: 8:08 PM
 */

namespace Framework\Foundation\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Framework\Data\ValueObjects\Currency;
use Framework\Data\ValueObjects\Price;
use InvalidArgumentException;

class PriceCast implements CastsAttributes
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Illuminate\Contracts\Database\Eloquent\string|string $key
     * @param mixed $value
     * @param array $attributes
     * @return Price|mixed
     * @throws \Lucid\Foundation\InvalidInputException
     */
    public function get($model, $key, $value, $attributes)
    {
        return new Price($attributes['price'], new Currency($attributes['currency']));
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
        if (! $value instanceof Price) {
            throw new InvalidArgumentException('The given value is not an Price instance.');
        }
        return [
            'price' => $value->getAmount(),
            'currency' => $value->getCurrency()->getCode(),
        ];
    }
}
