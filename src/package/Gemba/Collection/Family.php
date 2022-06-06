<?php

namespace Package\Gemba\Collection;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

class Family implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * @param array $familyMembers
     */
    public function __construct(
        private array $familyMembers
    ) {
        foreach ($familyMembers as $member) {
            if (!$member instanceof FamilyMember) {
                throw new InvalidArgumentException('Family member must be an instance of FamilyMember');
            }
        }
    }

    /**
     * @return Traversable|FamilyMember[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->familyMembers);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->familyMembers[$offset]);
    }

    /**
     * @param mixed $offset
     * @return FamilyMember|null
     */
    public function offsetGet(mixed $offset): FamilyMember|null
    {
        return $this->familyMembers[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->familyMembers[] = $value;
        } else {
            $this->familyMembers[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->familyMembers[$offset]);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->familyMembers);
    }

    /**
     * @param FamilyMember $familyMember
     * @return Family
     */
    public function add(FamilyMember $familyMember): Family
    {
        return new self(array_merge($this->familyMembers, [$familyMember]));
    }

    /**
     * @return Family
     */
    public function filterHasIncome(): Family
    {
        $familyMembers = [];
        foreach ($this->familyMembers as $familyMember) {
            if ($familyMember->hasIncome) {
                $familyMembers[] = $familyMember;
            }
        }

        return new Family($familyMembers);
    }
}
