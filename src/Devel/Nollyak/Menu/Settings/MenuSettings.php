<?php

namespace Devel\Nollyak\Menu\Settings;

use Devel\Nollyak\Menu\Item\MenuItem;

interface MenuSettings
{

    public function hasMenuItem(int $slot): bool;

    public function addMenuItem(MenuItem $item): void;

    public function getMenuItem(int $slot): ?MenuItem;

    public function delMenuItem(int $slot): void;

    public function getName(): string;

    public function getSize(): int;

    public function getMenuType(): string;

    public function getItems(): array;

}