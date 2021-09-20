<?php

namespace FPFProVendor\WPDesk\PluginBuilder\Storage;

class StorageFactory
{
    /**
     * @return PluginStorage
     */
    public function create_storage()
    {
        return new \FPFProVendor\WPDesk\PluginBuilder\Storage\WordpressFilterStorage();
    }
}
