<?php

namespace Devel\Nollyak\Menu\Settings;

use Devel\Nollyak\Menu\Item\MenuItem;

final class MenuSettingsImpl implements MenuSettings
{

    public function __construct(
        protected string $name,
        protected int $size,
        protected string $menuType,
        protected array $items = []
    ) { }

    public function hasMenuItem(int $slot): bool
    {
        return array_key_exists($slot, $this->items);
    }

    public function addMenuItem(MenuItem $item): void
    {
        $this->items[$item->getSlot()] = $item;
    }

    public function getMenuItem(int $slot): ?MenuItem
    {
        return $this->items[$slot] ?? null;
    }

    public function delMenuItem(int $slot): void
    {
        unset($this->items[$slot]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getMenuType(): string
    {
        return $this->menuType;
    }

    public function getItems(): array
    {
        return $this->items;
    }

}