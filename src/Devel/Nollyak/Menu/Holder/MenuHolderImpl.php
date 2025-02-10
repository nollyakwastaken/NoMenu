<?php

namespace Devel\Nollyak\Menu\Holder;

use pocketmine\inventory\Inventory;

use pocketmine\inventory\InventoryHolder;

use pocketmine\level\Position;

final class MenuHolderImpl implements MenuHolder, InventoryHolder
{

    public function __construct(
        protected Inventory $inventory,
        protected Position $position
    ) { }

    public function getInventory(): Inventory
    {
        return $this->inventory;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

}