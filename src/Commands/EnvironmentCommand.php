<?php

namespace Gilanggustina\ModuleClassRoom\Commands;

use Zahzah\LaravelSupport\{
    Commands\BaseCommand
};
use Zahzah\LaravelSupport\Concerns\ServiceProvider\HasMigrationConfiguration;

class EnvironmentCommand extends BaseCommand{
    use HasMigrationConfiguration;

    protected function init(): self{
        //INITIALIZE SECTION
        $this->setLocalConfig('module-class-room');
        return $this;
    }

    protected function dir(): string{
        return __DIR__.'/../';
    }    
}
