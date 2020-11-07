<?php

namespace Framework\Domains\Server\Jobs;

use Lucid\Foundation\InvalidInputException;
use Framework\Data\ValueObjects\Currency;
use Framework\Data\ValueObjects\Price;
use Lucid\Foundation\Job;

class MakePriceFromInputJob extends Job
{
    private array $price;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $price)
    {
        $this->price = $price;
    }

    /**
     * @return Price
     * @throws \Lucid\Foundation\InvalidInputException
     */
    public function handle() : Price
    {
        if (isset($this->price['amount']) && isset($this->price['currency'])) {
            return new Price($this->price['amount'], new Currency($this->price['currency']));
        }
        throw new InvalidInputException('Invalid arguments for price');
    }
}
