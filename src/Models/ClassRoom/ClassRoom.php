<?php

namespace Hanafalah\ModuleClassRoom\Models\ClassRoom;

use Hanafalah\ModuleClassRoom\Enums\ClassRoom\ClassRoomStatus;
use Hanafalah\ModuleClassRoom\Resources\ClassRoom\ViewClassRoom;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\LaravelHasProps\Concerns\HasProps;

class ClassRoom extends BaseModel
{
    use SoftDeletes, HasProps;

    protected $table = 'class_rooms';
    protected $show = ['props'];
    protected $list = ['id', 'name', 'props'];

    protected $casts = [
        'name' => 'string'
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->status)) $query->status = ClassRoomStatus::ACTIVE->value;
        });
    }

    public function toViewApi()
    {
        return new ViewClassRoom($this);
    }

    public function toShowApi()
    {
        return new ViewClassRoom($this);
    }
}
