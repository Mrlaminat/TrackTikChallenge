<?php

namespace App\Model;

/**
 * Class ElectronicItem
 * @package App\Model
 */
abstract class ElectronicItem
{
    /**
     * @var float $price
     */
    private float $price;

    /**
     * @var string $type
     */
    private string $type;

    /**
     * @var array $extras
     */
    private array $extras = [];

    const ELECTRONIC_ITEM_CONSOLE    = 'console';
    const ELECTRONIC_ITEM_TELEVISION = 'television';
    const ELECTRONIC_ITEM_MICROWAVE  = 'microwave';
    const ELECTRONIC_ITEM_CONTROLLER = 'controller';

    /**
     * @var array|string[] $types
     */
    public static array $types = [
        self::ELECTRONIC_ITEM_CONSOLE,
        self::ELECTRONIC_ITEM_MICROWAVE,
        self::ELECTRONIC_ITEM_TELEVISION,
        self::ELECTRONIC_ITEM_CONTROLLER
    ];

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getExtras(): array
    {
        return $this->extras;
    }

    /**
     * @param $controller
     */
    public function addExtras(Controller $controller): void
    {
        $this->extras[] = $controller;
    }

    /**
     * @param array $extras
     */
    public function setExtras(array $extras): void
    {
        $this->extras = $extras;
    }
}
