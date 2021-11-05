<?php

namespace FPFProVendor\WPDesk\View\Resolver;

use FPFProVendor\WPDesk\View\Renderer\Renderer;
use FPFProVendor\WPDesk\View\Resolver\Exception\CanNotResolve;
/**
 * This resolver never finds the file
 *
 * @package WPDesk\View\Resolver
 */
class NullResolver implements \FPFProVendor\WPDesk\View\Resolver\Resolver
{
    public function resolve($name, \FPFProVendor\WPDesk\View\Renderer\Renderer $renderer = null)
    {
        throw new \FPFProVendor\WPDesk\View\Resolver\Exception\CanNotResolve("Null Cannot resolve");
    }
}
