<?php

namespace Hanafalah\ModuleClassRoom\Supports;

use Hanafalah\LaravelSupport\Supports\PackageManagement;

class BaseModuleClassRoom extends PackageManagement
{
    protected $__config_name = 'module-class-room';
    protected $__module_class_room_config = [];

    /**
     * A description of the entire PHP function.
     *
     * @param Container $app The Container instance
     * @throws Exception description of exception
     * @return void
     */
    public function __construct()
    {
        $this->setConfig($this->__config_name, $this->__module_class_room_config);
    }
}
