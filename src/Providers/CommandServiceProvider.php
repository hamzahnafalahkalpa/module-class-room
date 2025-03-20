<?php

declare(strict_types=1);

namespace Gilanggustina\ModuleClassRoom\Providers;

use Gilanggustina\ModuleClassRoom\Commands;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    private $commands = [
        Commands\InstallMakeCommand::class,
    ];


    public function register(){
        $this->commands(config('module-class-room.commands',$this->commands));
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */

    public function provides()
    {
        return $this->commands;
    }
}
