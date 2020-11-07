<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 1.11.20
 * Time: 11:22 AM
 */

namespace Framework\Data\ValueObjects;

use Framework\Data\Contracts\HasValidationRules;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Validation\Rule;
use InvalidArgumentException;


final class Currency implements HasValidationRules, Arrayable
{
    public const SUPPORTED_CURRENCIES = ['EUR', 'USD'];

    private string $code;

    private static array $rules = [
        'code' => ['required', 'string', 'max:3', 'min:3']
    ];

    /**
     * Currency constructor.
     * @param string $code
     * @throws InvalidArgumentException
     */
    public function __construct(string $code)
    {
        if (!in_array($code, self::SUPPORTED_CURRENCIES))
        {
            throw new InvalidArgumentException('Invalid Currency', 400);
        }

        $this->code = $code;
    }

    /**
     * @return array
     */
    public static function getValidationRules() : array
    {
        self::addAditionalRules();
        return self::$rules;
    }

    private static function addAditionalRules()
    {
        self::$rules['code'][] = Rule::in(self::SUPPORTED_CURRENCIES);
    }

    /**
     * @return string
     */
    public function getCode() : string
    {
        return $this->code;
    }

    /**
     * @param int $options
     * @return array
     */
    public function toArray($options = 0) : array
    {
        return [
            'code' => $this->code
        ];
    }

}
