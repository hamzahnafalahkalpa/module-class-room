<?php

namespace Gilanggustina\ModuleClassRoom\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Gilanggustina\ModuleClassRoom\Contracts;
use Gilanggustina\ModuleClassRoom\Resources\ClassRoom\ViewClassRoom;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;

class ClassRoom extends PackageManagement implements Contracts\ClassRoom
{
    protected array $__guard   = ['id', 'service_id'];
    protected array $__add     = ['name', 'status', 'service_id'];
    protected string $__entity = 'ClassRoom';
    public static $class_room_model;


    protected array $__resources = [
        'view' => ViewClassRoom::class,
        'show' => ViewClassRoom::class
    ];

    protected array $__cache = [
        'index' => [
            'name'     => 'class-room',
            'tags'     => ['class-room', 'class-room-index'],
            'forever'  => true
        ]
    ];

    public function prepareViewClassRoomList(?array $attributes = null): Collection
    {
        $attributes ??= request()->all();

        return static::$class_room_model = $this->cacheWhen(!$this->isSearch(), $this->__cache['index'], function () {
            return $this->classRoom()->get();
        });
    }

    public function viewClassRoomList(): array
    {
        return $this->transforming($this->__resources['view'], function () {
            return $this->prepareViewClassRoomList();
        });
    }

    public function showUsingRelation(): array
    {
        return ['service'];
    }

    public function prepareShowClassRoom(?Model $model = null, array $attributes = null): Model
    {
        $attributes ??= request()->all();
        $model ??= $this->getClassRoom();

        if (!isset($model)) {
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('No class room id provided', 422);

            $model = $this->classRoom()->with($this->showUsingRelation())->find($id);
        } else {
            $model->load($this->showUsingRelation());
        }

        return static::$class_room_model = $model;
    }

    public function showClassRoom(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], function () use ($model) {
            return $this->prepareShowClassRoom($model);
        });
    }

    public function prepareStoreClassRoom(?array $attributes = null): Model
    {
        $attributes ??= request()->all();

        $class_room = $this->ClassRoomModel()->updateOrCreate([
            'id' => $attributes['id'] ?? null
        ], [
            'name' => $attributes['name'],
            'service_id' => $attributes['service_id'],

        ]);

        $this->forgetTags('class-room');
        return static::$class_room_model = $class_room;
    }

    public function storeClassRoom(): array
    {
        return $this->transaction(function () {
            return $this->showClassRoom($this->prepareStoreClassRoom());
        });
    }

    public function prepareDeleteClassRoom(?array $attributes = null): bool
    {
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('No id provided', 422);
        $this->forgetTags('class-room');
        return $this->ClassRoomModel()->destroy($attributes['id']);
    }

    public function deleteClassRoom(): bool
    {
        return $this->transaction(function () {
            return $this->prepareDeleteClassRoom();
        });
    }

    public function classRoom(): Builder
    {
        $this->booting();
        return $this->ClassRoomModel()->with('service')->withParameters()->orderBy('name', 'asc');
    }
}
