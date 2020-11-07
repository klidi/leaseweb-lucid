<?php

namespace Framework\Domains\Server\Jobs;

use Framework\Data\ValueObjects\Currency;
use Framework\Data\ValueObjects\Price;
use Lucid\Foundation\Validator;
use Illuminate\Validation\Rule;
use Lucid\Foundation\Job;

class ValidateCreateServerPriceInputJob extends Job
{
    private array $price;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $price)
    {
        $this->rules['currency'][] = Rule::in(Currency::SUPPORTED_CURRENCIES);
        $this->price = $price;
        $this->rules = Price::getValidationRules();
    }

    /**
     * @param Validator $validator
     * @return bool
     * @throws \Lucid\Foundation\InvalidInputException
     */
    public function handle(Validator $validator) :bool
    {
        return $validator->validate($this->price, Price::getValidationRules());
    }
}
