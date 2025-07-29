<?php

namespace Hanafalah\ModuleClassRoom\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleClassRoom\Contracts\Data\ClassRoomData as DataClassRoomData;
use Hanafalah\ModuleService\Contracts\Data\ServiceData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ClassRoomData extends Data implements DataClassRoomData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('service_type_id')]
    #[MapName('service_type_id')]
    public mixed $service_type_id = null;

    #[MapInputName('service')]
    #[MapName('service')]
    public ?ServiceData $service = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        if (isset($attributes['service'])){
            $attributes['service']['name'] ??= $attributes['name'];
        }
    }

    public static function after(self $data): self{
        $new = self::new();

        $props = &$data->props;

        $service = $new->ServiceModel();
        $service = isset($data->service_type_id) ? $service->findOrFail($data->service_type_id) : $service;
        $props['prop_service_type'] = $service->toViewApi()->resolve();
        return $data;
    }
}