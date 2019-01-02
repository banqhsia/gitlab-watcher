<?php

namespace App;

use App\Comparator\ComparatorInterface;

class Comparator
{
    /**
     * @var ComparatorInterface
     */
    private $comparator;

    /**
     * Construct
     *
     * @param ComparatorInterface $comparator
     */
    public function __construct(ComparatorInterface $comparator)
    {
        $this->comparator = $comparator;
    }

    /**
     * @return bool
     */
    public function isChanged()
    {
        return ! $this->isSame();
    }

    /**
     * @return bool
     */
    public function isSame()
    {
        return $this->comparator->getPreviousContext() === $this->comparator->getCurrentContext();
    }
}
