<?php

namespace Devel\Nollyak\Menu\Definition\Type;

use Devel\Nollyak\Menu\Definition\MenuDefinition;

use Devel\Nollyak\Menu\Settings\MenuSettingsImpl;

use Devel\Nollyak\Menu\Settings\Type\MenuType;

final class DoubleChestMenuDefinition extends MenuDefinition
{

    public function __construct()
    {
        parent::__construct(new MenuSettingsImpl(
            "Double Chest Menu",
            54,
            MenuType::DOUBLE_CHEST,
            []
        ));
    }

}