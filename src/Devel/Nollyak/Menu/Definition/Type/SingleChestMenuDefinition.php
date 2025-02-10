<?php

namespace Devel\Nollyak\Menu\Definition\Type;

use Devel\Nollyak\Menu\Definition\MenuDefinition;

use Devel\Nollyak\Menu\Settings\MenuSettingsImpl;
use Devel\Nollyak\Menu\Settings\Type\MenuType;

final class SingleChestMenuDefinition extends MenuDefinition
{

    public function __construct()
    {
        parent::__construct(new MenuSettingsImpl(
            "Single Chest Menu",
            27,
            MenuType::SINGLE_CHEST,
            []
        ));
    }

}