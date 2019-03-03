<?php

namespace App;

use App\Comparator\ComparatorInterface;

class Comparator
{
    /**
     * @return bool
     */
    public static function isChanged(ComparatorInterface $context)
    {
        return ! static::isSame($context);
    }

    /**
     * @return bool
     */
    public static function isSame(ComparatorInterface $context)
    {
        return $context->getPreviousContext() === $context->getCurrentContext();
    }
}
