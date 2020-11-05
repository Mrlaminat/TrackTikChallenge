<?php

namespace App\Model;

/**
 * Class Microwave
 * @package App\Model
 */
class Microwave extends ElectronicItem implements ElectronicItemInterface
{
    /**
     * @var int|null
     */
    private ?int $maxExtras;

    /**
     * @param int|null $maxExtras
     */
    public function setMaxExtras(?int $maxExtras): void
    {
        $this->maxExtras = $maxExtras;
    }

    /**
     * @return int|null
     */
    public function getMaxExtras(): ?int
    {
        return $this->maxExtras;
    }
}