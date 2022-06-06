<?php

namespace Package\Gemba\Polymorphism;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

class Reservation implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * @param FeeInterface[] $fees
     */
    public function __construct(
        private array $fees
    ) {
        foreach ($fees as $fee) {
            if (!$fee instanceof FeeInterface) {
                throw new InvalidArgumentException('Fee must be implement FeeInterface');
            }
        }
    }

    /**
     * @return Traversable|FeeInterface[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->fees);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->fees[$offset]);
    }

    /**
     * @param mixed $offset
     * @return FeeInterface|null
     */
    public function offsetGet(mixed $offset): FeeInterface|null
    {
        return $this->fees[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->fees[] = $value;
        } else {
            $this->fees[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->fees[$offset]);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->fees);
    }

    /**
     * @param FeeInterface $fee
     * @return Reservation
     */
    public function add(FeeInterface $fee): Reservation
    {
        return new self(array_merge($this->fees, [$fee]));
    }

    /**
     * @return Reservation
     */
    public function filterAdult(): Reservation
    {
        $newFees = [];
        foreach ($this->fees as $fee) {
            if ($fee->label() === '大人料金') {
                $newFees[] = $fee;
            }
        }

        return new Reservation($newFees);
    }

    public function totalYen(): Yen
    {
        $total = new Yen(0);
        foreach ($this->fees as $fee) {
            $total = $total->add($fee->yen());
        }

        return $total;
    }
}
