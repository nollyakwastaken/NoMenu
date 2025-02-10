<?php

namespace Devel\Nollyak\Menu\Definition;

use Devel\Nollyak\Menu\Settings\MenuSettings;

abstract class MenuDefinition
{

    public function __construct(
        protected MenuSettings $settings
    ) { }

    public function getSettings(): MenuSettings
    {
        return $this->settings;
    }

}