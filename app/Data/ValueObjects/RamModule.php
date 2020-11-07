<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 1.11.20
 * Time: 10:16 AM
 */

namespace Framework\Data\ValueObjects;


use Framework\Data\Contracts\HasValidationRules;
use Framework\Foundation\Validation\InBitstream;
use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;

final class RamModule implements HasValidationRules, Arrayable
{
    private const UNIT = 'GB';

    private int $size;
    private RamModuleType $type;
    private string $unit = self::UNIT;

    private static array $rules = [
        'size' => ['required', 'integer', 'gt:0'],
    ];

    public function __construct(int $size, RamModuleType $type)
    {
        if (!(($size & ($size-1)) === 0)) {
            throw new InvalidArgumentException('Invalid ram module size', 400);
        }
        $this->size = $size;
        $this->type = $type;
    }

    public static function getValidationRules() : array
    {
        self::addAditionalRules();
        return self::$rules;
    }

    private static function addAditionalRules() : void
    {
        self::$rules['size'][] = new InBitstream();

        $typeValidationRules = RamModuleType::getValidationRules();
        if (!empty($typeValidationRules) && isset($typeValidationRules['name'])) {
            self::$rules['type'] = $typeValidationRules['name'];
        }
    }

    public function getSize() : int
    {
        return $this->size;
    }

    public function getType() : RamModuleType
    {
        return $this->type;
    }

    public function getUnit() : string
    {
        return $this->unit;
    }

    public function toArray()
    {
        return [
            'size' => $this->size,
            'type' => $this->type->getName(),
        ];
    }
}
