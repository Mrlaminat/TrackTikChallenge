<?php

namespace App\Model;

/**
 * Class Controller
 * @package App\Model
 */
class Controller extends ElectronicItem
{
    /**
     * @var bool $wired
     */
    private bool $wired;

    /**
     * @return bool
     */
    public function getWired(): bool
    {
        return $this->wired;
    }

    /**
     * @param bool $wired
     */
    public function setWired(bool $wired): void
    {
        $this->wired = $wired;
    }
}