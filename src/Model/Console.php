<?php

namespace App\Model;

/**
 * Class Console
 * @package App\Model
 */
class Console extends ElectronicItem implements ElectronicItemInterface
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