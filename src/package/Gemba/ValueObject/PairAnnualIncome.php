<?php

namespace Package\Gemba\ValueObject;

class PairAnnualIncome
{
    /**
     * @param SingleAnnualIncome $annualIncome
     * @param SingleAnnualIncome $anotherAnnualIncome
     */
    public function __construct(
        private SingleAnnualIncome $annualIncome,
        private SingleAnnualIncome $anotherAnnualIncome
    ) {
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->annualIncome->value() + $this->anotherAnnualIncome->value();
    }

    /**
     * @return int
     */
    public function rawValue(): int
    {
        return $this->annualIncome->rawAnnualIncome() + $this->anotherAnnualIncome->rawAnnualIncome();
    }

    /**
     * @return string
     */
    public function annualIncomeForView(): string
    {
        $total = $this->annualIncome->value() + $this->anotherAnnualIncome->value();
        $format = number_format($total);

        return "$format 万円";
    }
}
