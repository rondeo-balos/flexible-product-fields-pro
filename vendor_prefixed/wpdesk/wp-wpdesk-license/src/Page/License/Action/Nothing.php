<?php

namespace FPFProVendor\WPDesk\License\Page\License\Action;

use FPFProVendor\WPDesk\License\Page\Action;
/**
 * Do nothing.
 *
 * @package WPDesk\License\Page\License\Action
 */
class Nothing implements \FPFProVendor\WPDesk\License\Page\Action
{
    public function execute(array $plugin)
    {
        // NOOP
    }
}
