<?php

namespace Package\Gemba\Enum;

use InvalidArgumentException;

enum PaymentState: string
{
    case WAITING = 'waiting';

    case PENDING = 'pending';

    case ACCEPTING = 'accepting';

    case ACCEPTED = 'accepted';

    case REJECTED = 'rejected';

    case PAID = 'paid';

    public static function allStatus(): array
    {
        return [
            self::WAITING->name => '支払待',
            self::PENDING->name => '支払中',
            self::ACCEPTING->name => '受付中',
            self::ACCEPTED->name => '受付済',
            self::REJECTED->name => '拒否',
            self::PAID->name => '支払済',
        ];
    }

    /**
     * @param PaymentState $nextState
     * @return PaymentState
     * @throws InvalidArgumentException
     */
    public function proceed(PaymentState $nextState): PaymentState
    {
        if (!$this->nextStateSpec($nextState)) {
            throw new InvalidArgumentException("{$this->name}から{$nextState->name}に進めません");
        }

        return $nextState;
    }

    /**
     * @param PaymentState $next
     * @return bool
     */
    private function nextStateSpec(PaymentState $next): bool
    {
        $items = [
            self::WAITING->name => [
                self::PENDING->name,
                self::ACCEPTING->name,
                self::ACCEPTED->name,
                self::REJECTED->name,
                self::PAID->name,
            ],
            self::PENDING->name => [
                self::ACCEPTING->name,
                self::ACCEPTED->name,
                self::REJECTED->name,
                self::PAID->name,
            ],
            self::ACCEPTING->name => [
                self::ACCEPTED->name,
                self::REJECTED->name,
                self::PAID->name,
            ],
            self::ACCEPTED->name => [
                self::REJECTED->name,
                self::PAID->name,
            ],
            self::REJECTED->name => [
                self::PAID->name,
            ],
            self::PAID->name => [],
        ];

        return in_array($next->name, $items[$this->name], true);
    }
}
