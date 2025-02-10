<?php

namespace Devel\Nollyak\Menu;

use Devel\Nollyak\Menu\Definition\MenuDefinition;

use Devel\Nollyak\Menu\Holder\MenuHolder;

interface Menu
{

    public function getMenuHolder(): MenuHolder;

    public function getMenuDefinition(): MenuDefinition;

}