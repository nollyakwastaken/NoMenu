<?php

namespace Devel\Nollyak\Menu;

use Devel\Nollyak\Menu\Definition\MenuDefinition;


use Devel\Nollyak\Menu\Holder\MenuHolder;
use Devel\Nollyak\Menu\Holder\MenuHolderImpl;
use Devel\Nollyak\Menu\Settings\Type\MenuType;
use InvalidArgumentException;
use pocketmine\inventory\CustomInventory;

use pocketmine\inventory\InventoryType;
use pocketmine\level\Position;
use pocketmine\Player;

abstract class MenuImpl extends CustomInventory implements Menu
{

    protected MenuHolder $menuHolder;

    public function __construct(
        protected Position       $position,
        protected MenuDefinition $menuDefinition
    )
    {
        $this->menuHolder = new MenuHolderImpl($this, Position::fromObject($position->subtract(0, 2), $position->getLevel()));
        parent::__construct($this->getMenuHolder(), match ($this->getMenuDefinition()->getSettings()->getMenuType()) {
            MenuType::SINGLE_CHEST => InventoryType::get(InventoryType::CHEST),
            MenuType::DOUBLE_CHEST => InventoryType::get(InventoryType::DOUBLE_CHEST),
            MenuType::HOPPER => InventoryType::get(InventoryType::HOPPER),
            default => throw new InvalidArgumentException(sprintf("Invalid menu type %s", $this->getMenuDefinition()->getSettings()->getMenuType()))
        });
    }

    public function onOpen(Player $who): void
    {
        $this->viewers[spl_object_hash($who)] = $who;
        array_map(fn($player) => $this->renderMenu($player), $this->getViewers());
    }

    public abstract function renderMenu(Player $player): void;

    public function onClose(Player $who): void
    {
        array_map(fn($player) => $this->destroyMenu($player), $this->getViewers());
        unset($this->viewers[spl_object_hash($who)]);
    }

    public abstract function destroyMenu(Player $player): void;

    public function getMenuHolder(): MenuHolder
    {
        return $this->menuHolder;
    }

    public function getMenuDefinition(): MenuDefinition
    {
        return $this->menuDefinition;
    }

}