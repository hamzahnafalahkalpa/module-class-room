<?php

use Hanafalah\ModuleClassRoom\{
    Models,
    Commands as ModuleClassRoomCommands,
    Contracts
};

return [
    'namespace' => 'Hanafalah\\ModuleClassRoom',
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACTS HERE
        ]
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
    ],
    'commands'   => [
        ModuleClassRoomCommands\InstallMakeCommand::class
    ],
];
