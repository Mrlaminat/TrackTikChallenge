<?php

namespace App\Service;

use App\Model\Console;
use App\Model\Controller;
use App\Model\ElectronicItem;
use App\Model\ElectronicItems;
use App\Model\Microwave;
use App\Model\Television;
use Exception;

/**
 * Explanation to Electronic Service and Electronic Models logic (OOP).
 * Current implementation follows "create each type of electronic as classes".
 * As far as we have separate Models (Console, Microwave, Television)
 * with the same properties, functions, we have quite common (duplications) implementation for the proceeding functions.
 * IMHO the possible good solution it's service factory for generation Classes and properties by type,
 * For this implementation I would prefer to use base Electronic Item class and specific type properties for each entity.
 *
 * Class ElectronicService
 * @package App\Service
 */
class ElectronicService
{
    /**
     * @param array $electronicItemsData
     * @return array
     * @throws Exception
     */
    public function proceedElectronicItems(array $electronicItemsData): array
    {
        $electronicItems = $this->generateElectronicItems($electronicItemsData);

        $sortedElectronicItems = $electronicItems->getSortedItemsByPrice($electronicItems->getItems());
        $totalPrice = $electronicItems->getTotalPrice($electronicItems->getItems());

        $consoleItems = $electronicItems->getItemsByType(ElectronicItem::ELECTRONIC_ITEM_CONSOLE);
        $consoleItemsPrice = $electronicItems->getTotalPrice($consoleItems);

        return [
            'sorted_electronic_items' => $sortedElectronicItems,
            'total_price' => $totalPrice,
            'total_console_price' => $consoleItemsPrice
        ];
    }

    /**
     * @param array $electronicItemsData
     * @return ElectronicItems
     * @throws Exception
     */
    public function generateElectronicItems(array $electronicItemsData): ElectronicItems
    {
        //TODO Isset can be avoided with request validation
        if (!isset($electronicItemsData['electronic_list']) && !$electronicItemsData['electronic_list']) {
            throw new Exception('Electronic list is empty or not exist');
        }

        $requirements = $electronicItemsData['requirements'] ?? [];

        $electronicItems = new ElectronicItems();
        foreach ($electronicItemsData['electronic_list'] as $electronicItem) {
            if (isset($electronicItem['item_type']) && in_array($electronicItem['item_type'], ElectronicItem::$types)) {
                $requirement = $this->getItemRequirements($electronicItem['item_type'], $requirements);
                $electronicItems->addItems($this->callItemGenerator($electronicItem, $requirement));
            }
        }

        return $electronicItems;
    }

    /**
     * @param array $itemData
     * @param array $requirement
     * @return ElectronicItem
     * @throws Exception
     */
    private function callItemGenerator(array $itemData, array $requirement): ElectronicItem
    {
        $method = sprintf('generate%sItem', ucfirst($itemData['item_type']));
        if (!method_exists($this, $method)) {
            throw new Exception(sprintf('Method %s not exist.', $method));
        }

        return $this->$method($itemData, $requirement);
    }

    /**
     * @param array $consoleData
     * @param array $requirement
     * @return Console
     */
    private function generateConsoleItem(array $consoleData, array $requirement): Console
    {
        $console = new Console();
        $console->setType($consoleData['item_type']);
        $console->setType($consoleData['item_type']);
        $console->setPrice($consoleData['item_price'] ?? 0);
        $console->setMaxExtras($requirement['max_extras'] ?? null);

        $consoleExtras = $this->generateItemExtras($consoleData['item_extras'] ?? [], $console->getMaxExtras());
        $console->setExtras($consoleExtras);

        return $console;
    }

    /**
     * @param array $televisionData
     * @param array $requirement
     * @return Television
     */
    private function generateTelevisionItem(array $televisionData, array $requirement): Television
    {
        $television = new Television();
        $television->setType($televisionData['item_type']);
        $television->setPrice($televisionData['item_price'] ?? 0);
        $television->setMaxExtras($requirement['max_extras'] ?? null);

        $televisionExtras = $this->generateItemExtras($televisionData['item_extras'] ?? [], $television->getMaxExtras());
        $television->setExtras($televisionExtras);

        return $television;
    }

    /**
     * @param array $microwaveData
     * @param array $requirement
     * @return Microwave
     */
    private function generateMicrowaveItem(array $microwaveData, array $requirement): Microwave
    {
        $microwave = new Microwave();
        $microwave->setType($microwaveData['item_type']);
        $microwave->setPrice($microwaveData['item_price'] ?? 0);
        $microwave->setMaxExtras($requirement['max_extras'] ?? null);

        $microwaveExtras = $this->generateItemExtras($microwaveData['item_extras'] ?? [], $microwave->getMaxExtras());
        $microwave->setExtras($microwaveExtras);

        return $microwave;
    }

    /**
     * @param array $extrasData
     * @param int|null $maxExtras
     * @return array
     */
    private function generateItemExtras(array $extrasData, int $maxExtras = null): array
    {
        $itemExtras = [];
        $extrasData = array_slice($extrasData, 0, $maxExtras);
        foreach ($extrasData as $extraData) {
            $itemExtras[] = $this->generateItemExtra($extraData);
        }

        return $itemExtras;
    }

    /**
     * @param $extrasData
     * @return Controller
     */
    private function generateItemExtra($extrasData): Controller
    {
        //TODO here we can add modification to allow users set as extras not only controllers
        $itemExtra = new Controller();
        $itemExtra->setType($extrasData['item_type'] ?? 'controller');
        $itemExtra->setPrice($extrasData['item_price'] ?? 0);
        $itemExtra->setWired($extrasData['item_wired'] ?? true);

        return $itemExtra;
    }

    /**
     * @param string $type
     * @param array $requirements
     * @return array
     */
    private function getItemRequirements(string $type, array $requirements): array
    {
        $requirement = array_filter($requirements, function ($requirement) use ($type) {
            return $requirement['item_type'] === $type;
        });

        return array_shift($requirement);
    }
}