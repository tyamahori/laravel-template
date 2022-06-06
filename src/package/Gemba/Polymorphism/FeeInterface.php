<?php

namespace Package\Gemba\Polymorphism;

interface FeeInterface
{
    /**
     * @return Yen
     */
    public function yen(): Yen;

    /**
     * @return string
     */
    public function label(): string;
}
