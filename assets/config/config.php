<?php

use Hanafalah\ModuleClassRoom\{
    Commands as ModuleClassRoomCommands,
};

return [
    'namespace' => 'Hanafalah\ModuleClassRoom',
    'app' => [
        'contracts'  => [
        ],
    ],
    'commands'   => [
        ModuleClassRoomCommands\InstallMakeCommand::class
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database' => [
        'models' => [
        ]
    ]
];
