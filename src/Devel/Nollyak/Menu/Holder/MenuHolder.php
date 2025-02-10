<?php

namespace Devel\Nollyak\Menu\Holder;

use pocketmine\inventory\Inventory;

use pocketmine\level\Position;

interface MenuHolder
{

    public function getInventory(): Inventory;

    public function getPosition(): Position;

}