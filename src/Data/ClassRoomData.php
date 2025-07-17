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

    #[MapInputName('daily_rate')]
    #[MapName('daily_rate')]
    public int $daily_rate = 0;

    #[MapInputName('service_id')]
    #[MapName('service_id')]
    public mixed $service_id = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(self $data): self{
        $new = self::new();

        $props = &$data->props;

        $service = $new->ServiceModel();
        $service = isset($data->service_id) ? $service->findOrFail($data->service_id) : $service;
        $props['prop_service'] = $service->toViewApi()->resolve();
        return $data;
    }
}