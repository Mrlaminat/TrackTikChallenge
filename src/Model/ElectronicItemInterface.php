<?php

namespace App\Model;

/**
 * Interface ElectronicItemInterface
 * @package App\Model
 */
interface ElectronicItemInterface
{
    /**
     * @param int|null $maxExtras
     */
    public function setMaxExtras(?int $maxExtras): void;

    /**
     * @return int|null
     */
    public function getMaxExtras(): ?int;
}