<?php

namespace Hanafalah\ModuleClassRoom\Models\ClassRoom;

use Hanafalah\ModuleClassRoom\Enums\ClassRoom\ClassRoomStatus;
use Hanafalah\ModuleClassRoom\Resources\ClassRoom\ViewClassRoom;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\ModuleService\Concerns\HasService;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ClassRoom extends BaseModel
{
    use HasUlids, SoftDeletes, HasProps, HasService;

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_ARCHIVE = 'ARCHIVE';

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $table      = 'class_rooms';
    protected $list       = [
        'id', 'name', 'service_type_id', 
        'status', 'props'
    ];
    protected $show       = [];

    protected $casts = [
        'name' => 'string',
        'service_name' => 'string',
        'service_type_id' => 'string'
    ];

    public function getPropsQuery(): array
    {
        return [
            'service_type_name' => 'props->prop_service_type->name'
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

    public function isUsingService(): bool{
        return true;
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return ['service','serviceType'];
    }

    public function getViewResource(){return ViewClassRoom::class;}
    public function getShowResource(){return ViewClassRoom::class;}
    public function serviceType(){return $this->belongsToModel('Service','service_type_id');}
}
