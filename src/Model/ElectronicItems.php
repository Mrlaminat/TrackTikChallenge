<?php

namespace App\Model;

/**
 * Class ElectronicItems
 * @package App\Model
 */
class ElectronicItems
{
    /**
     * @var array $items
     */
    private array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param ElectronicItem $electronicItem
     */
    public function addItems(ElectronicItem $electronicItem): void
    {
        $this->items[] = $electronicItem;
    }

    /**
     * @param array $electronicItems
     */
    public function setItems(array $electronicItems): void
    {
        $this->items = $electronicItems;
    }

    /**
     * Sort items with extras by price
     *
     * @param array $items
     * @return array
     */
    public function getSortedItemsByPrice(array $items): array
    {
        usort($items, function($a, $b) {
            return $this->getTotalPrice([$b]) - $this->getTotalPrice([$a]);
        });

        return $items;
    }

    /**
     * Calculate the total price for all Electronic Items
     *
     * @param array $items
     * @return float
     */
    public function getTotalPrice(array $items): float
    {
        $totalPrice = 0;
        foreach ($items as $item) {
            $totalPrice += $item->getPrice();
            foreach ($item->getExtras() as $extra) {
                $totalPrice += $extra->getPrice();
            }
        }

        return $totalPrice;
    }

    /**
     * @param string $type
     * @return array
     */
    public function getItemsByType(string $type): array
    {
        if (!in_array($type, ElectronicItem::$types))  {
            return [];
        }

        return array_filter($this->items, function($item) use ($type)  {
            return $item->getType() == $type;
        });
    }
}
