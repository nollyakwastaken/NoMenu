<?php

namespace Devel\Nollyak\Menu\Item;

use pocketmine\item\Item;

use Closure;

interface MenuItem
{

    public function getSlot(): int;

    public function getIcon(): Item;

    public function onClick(): Closure;

}