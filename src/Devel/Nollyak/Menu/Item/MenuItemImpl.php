<?php

namespace Devel\Nollyak\Menu\Item;

use Closure;

use pocketmine\item\Item;

final class MenuItemImpl implements MenuItem
{

    public function __construct(
        protected int $slot,
        protected Item $icon,
        protected Closure $onClick
    ) { }

    public function getSlot(): int
    {
        return $this->slot;
    }

    public function getIcon(): Item
    {
        return $this->icon;
    }

    public function onClick(): Closure
    {
        return $this->onClick;
    }

}