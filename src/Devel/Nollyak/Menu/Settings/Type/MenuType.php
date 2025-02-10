<?php

namespace Devel\Nollyak\Menu\Settings\Type;

interface MenuType
{

    /**
     * A menu with a single chest.
     * @var string
     */
    const SINGLE_CHEST = "menu:single_chest";

    /**
     * A menu with a double chest.
     * @var string
     */
    const DOUBLE_CHEST = "menu:double_chest";

    /**
     * A menu with a hopper.
     * @var string
     */
    const HOPPER = "menu:hopper";

}