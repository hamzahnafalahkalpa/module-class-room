<?php

use Gilanggustina\ModuleClassRoom\{
    Models,
    Commands as ModuleClassRoomCommands,
    Contracts
};
use Hanafalah\ModuleMedicService\Models\MedicService;

return [
    'contracts'  => [
        'class_room'        => Contracts\ClassRoom::class,
        'module_class_room' => Contracts\ModuleClassRoom::class
    ],
    'commands'   => [
        ModuleClassRoomCommands\InstallMakeCommand::class
    ],
    'database' => [
        'models' => [
            'ClassRoom'    => Models\ClassRoom\ClassRoom::class,
            'MedicService' => MedicService::class,
        ]
    ]
];
