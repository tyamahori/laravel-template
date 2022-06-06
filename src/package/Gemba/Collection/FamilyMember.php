<?php

namespace Package\Gemba\Collection;

class FamilyMember
{
    /**
     * @param string $name
     * @param bool $hasIncome
     */
    public function __construct(
        readonly public string $name,
        readonly public bool $hasIncome = false,
    ) {
    }

    /**
     * @return string
     */
    public function name(): string
    {
        $income = $this->hasIncome ? 'あり' : 'なし';
        return "$this->name(収入 $income)" . PHP_EOL ;
    }
}
