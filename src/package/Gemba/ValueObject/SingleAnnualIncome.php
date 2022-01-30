<?php

namespace Package\Gemba\ValueObject;

use InvalidArgumentException;

class SingleAnnualIncome
{
    private static int $minimum = 0;

    private static int $maximum = 100000;

    private static int $unit = 10000;

    /**
     * @param int $annualIncome
     */
    public function __construct(
        private int $annualIncome
    ) {
        if (!(self::$minimum <= $annualIncome && $annualIncome <= self::$maximum)) {
            throw new InvalidArgumentException('Annual income must be greater than or equal to ' . self::$minimum);
        }
    }

    /**
     * @return int
     */
    public function rawAnnualIncome(): int
    {
        return $this->annualIncome * self::$unit;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->annualIncome;
    }

    /**
     * @param SingleAnnualIncome $annualIncome
     * @return SingleAnnualIncome
     */
    public function add(SingleAnnualIncome $annualIncome): SingleAnnualIncome
    {
        $newIncome = $this->annualIncome + $annualIncome->value();

        return new SingleAnnualIncome($newIncome);
    }

    /**
     * @return string
     */
    public function annualIncomeForDisplay(): string
    {
        $roundedNumber = round($this->annualIncome);
        $formattedNumber = number_format($roundedNumber);

        return "$formattedNumber 万円";
    }
}
