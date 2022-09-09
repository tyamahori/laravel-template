<?php

namespace Package\Gemba\BuilderPattern;

use LogicException;

trait CreateClassHelper
{
    /**
     * @param string $className
     * @param int $traceLimit
     * @return void
     */
    public function shouldBeCalledFrom(
        string $className,
        int $traceLimit = 3
    ): void {

        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $traceLimit) as $backtrace) {
            if (isset($backtrace['class']) && $backtrace['class'] === $className) {
                return;
            }
        }

        throw new LogicException(
            sprintf(
                'This method should be called from %s',
                $className
            )
        );
    }
}
