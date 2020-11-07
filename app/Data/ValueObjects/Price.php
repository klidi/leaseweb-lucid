<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 31.10.20
 * Time: 11:16 PM
 */

namespace Framework\Data\ValueObjects;
namespace Framework\Data\ValueObjects;

use Framework\Data\Contracts\HasValidationRules;
use Illuminate\Contracts\Support\Arrayable;

final class Price implements HasValidationRules, Arrayable
{
    private int $amount;
    private Currency $currency;

    private static array $rules = [
        'amount' => ['required', 'integer', 'gt:0'],
    ];

    public function __construct(int $amount, Currency $currency)
    {
        $this->currency = $currency;
        $this->amount = $amount;
    }

    public static function getValidationRules() : array
    {
        self::addCurrencyRules();
        return self::$rules;
    }

    public static function addCurrencyRules() : void
    {
        $currencyRules = Currency::getValidationRules();
        if (!empty($currencyRules) && isset($currencyRules['code'])) {
            self::$rules['currency'] = $currencyRules['code'];
        }
    }

    public function getAmount() : int
    {
        return $this->amount;
    }

    public function getCurrency() : Currency
    {
        return $this->currency;
    }

    public function toArray() :array
    {
        return [
            'amount' => $this->getAmount(),
            'currency' => $this->currency->getCode(),
        ];
    }

}
