<?php

namespace Gilanggustina\ModuleClassRoom\Models\ClassRoom;

use Gilanggustina\ModuleClassRoom\Enums\ClassRoom\ClassRoomStatus;
use Gilanggustina\ModuleClassRoom\Resources\ClassRoom\ViewClassRoom;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zahzah\LaravelSupport\Models\BaseModel;
use Zahzah\LaravelHasProps\Concerns\HasProps;

class ClassRoom extends BaseModel{
    use SoftDeletes, HasProps;

    protected $table = 'class_rooms';
    protected $show = ['props'];
    protected $list = ['id','name','props'];

    protected $casts = [
        'name' => 'string'
    ];

    protected static function booted(): void{
        parent::booted();
        static::creating(function($query){
            if (!isset($query->status)) $query->status = ClassRoomStatus::ACTIVE->value;
        });
    }

    public function toViewApi(){
        return new ViewClassRoom($this);
    }

    public function toShowApi(){
        return new ViewClassRoom($this);
    }
}