<?php

namespace Hanafalah\ModuleClassRoom\Schemas;

use Hanafalah\ModuleClassRoom\Contracts;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleClassRoom\Contracts\Data\ClassRoomData;

class ClassRoom extends PackageManagement implements Contracts\Schemas\ClassRoom
{
    protected string $__entity = 'ClassRoom';
    public $class_room_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'class_room',
            'tags'     => ['class_room', 'class_room-index'],
            'forever'  => 24*60*7
        ]
    ];

    public function prepareStoreClassRoom(ClassRoomData $class_room_dto): Model{
        $class_room = $this->usingEntity()->updateOrCreate([
            'id' => $class_room_dto->id ?? null
        ], [
            'name' => $class_room_dto->name,
            'service_type_id' => $class_room_dto->service_type_id
        ]);

        if (isset($class_room_dto->service)){
            $service_dto = &$class_room_dto->service;
            $service_dto->reference_id   = $class_room->getKey();
            $service_dto->reference_type = $class_room->getMorphClass();
            $service = $this->schemaContract('service')->prepareStoreService($service_dto);
            $class_room_dto->props['props_service'] = $service->toViewApi()->resolve();
        }

        $this->fillingProps($class_room,$class_room_dto->props);
        $class_room->save();
        return $this->class_room_model = $class_room;
    }
}