<?php

namespace Hanafalah\ModuleClassRoom\Models\ClassRoom;

use Hanafalah\ModuleClassRoom\Enums\ClassRoom\ClassRoomStatus;
use Hanafalah\ModuleClassRoom\Resources\ClassRoom\ViewClassRoom;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ClassRoom extends BaseModel
{
    use HasUlids, SoftDeletes, HasProps;

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $table      = 'class_rooms';
    protected $list       = [
        'id', 'name', 'service_id', 
        'daily_rate', 'status', 'props'
    ];
    protected $show       = [];

    protected $casts = [
        'name' => 'string',
        'service_name' => 'string',
        'service_id' => 'string'
    ];

    public function getPropsQuery(): array
    {
        return [
            'service_name' => 'props->prop_service->name'
        ];
    }

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            $query->status ??= $query->getClassRoomStatus('ACTIVE');
        });
    }

    public function getClassRoomStatus(?string $status = null): string{
        return ClassRoomStatus::from($status ?? $this->status)->value;
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return ['service'];
    }

    public function getViewResource(){return ViewClassRoom::class;}
    public function getShowResource(){return ViewClassRoom::class;}
    public function service(){return $this->belongsToModel('Service');}
}
