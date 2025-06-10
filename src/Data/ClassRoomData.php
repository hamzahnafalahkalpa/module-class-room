<?php

namespace Hanafalah\ModuleClassRoom\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleClassRoom\Contracts\Data\ClassRoomData as DataClassRoomData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ClassRoomData extends Data implements DataClassRoomData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('service_id')]
    #[MapName('service_id')]
    public mixed $service_id = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}