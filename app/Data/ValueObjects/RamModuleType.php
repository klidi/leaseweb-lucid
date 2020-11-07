<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 2.11.20
 * Time: 3:24 PM
 */

namespace Framework\Data\ValueObjects;


use Framework\Data\Contracts\HasValidationRules;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

final class RamModuleType implements HasValidationRules
{
    public const TYPES = ['DDR3', 'DDR4', 'DDR5', 'DDR6'];

    private string $name;

    private static $rules = [
        'name' =>  ['required', 'string', 'min:4']
    ];

    public function __construct(string $name)
    {
        if (!in_array($name, self::TYPES)) {
            throw new InvalidArgumentException('Invalid ram module type', 400);
        }
        $this->name = $name;
    }

    public static function getValidationRules(): array
    {
        self::addAditionalRules();
        return self::$rules;
    }

    private static function addAditionalRules() : void
    {
        self::$rules['name'][] = Rule::in(self::TYPES);
    }

    public function getName()
    {
        return $this->name;
    }

    public function toArray($options = 0) : array
    {
        return [
            'name' => $this->name
        ];
    }
}
