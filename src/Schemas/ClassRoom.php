<?php

namespace Hanafalah\ModuleClassRoom\Schemas;

use Hanafalah\ModuleClassRoom\Contracts;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleClassRoom\Contracts\Data\ClassRoomData;

class ClassRoom extends PackageManagement implements Contracts\Schemas\ClassRoom
{
    protected string $__entity = 'ClassRoom';
    public static $class_room_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'class-room',
            'tags'     => ['class-room', 'class-room-index'],
            'forever'  => 24*60*7
        ]
    ];

    public function prepareStoreClassRoom(ClassRoomData $class_room_dto): Model
    {
        $class_room = $this->classRoom()->updateOrCreate([
            'id' => $class_room_dto->id ?? null
        ], [
            'name'       => $class_room_dto->name,
            'service_id' => $class_room_dto->service_id
        ]);
        $this->fillingProps($class_room,$class_room_dto->props);
        $this->forgetTags('class-room');
        return static::$class_room_model = $class_room;
    }
}
