<?php

namespace Hanafalah\ModuleClassRoom\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleClassRoom\Contracts\Data\ClassRoomData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
* @see \Hanafalah\ModuleClassRoom\Schemas\ClassRoom
* @method self conditionals(mixed $conditionals)
* @method bool deleteClassRoom()
* @method bool prepareDeleteClassRoom(? array $attributes = null)
* @method mixed getClassRoom()
* @method ?Model prepareShowClassRoom(?Model $model = null, ?array $attributes = null)
* @method array showClassRoom(?Model $model = null)
* @method Collection prepareViewClassRoomList()
* @method array viewClassRoomList()
* @method LengthAwarePaginator prepareViewClassRoomPaginate(PaginateData $paginate_dto)
* @method array viewClassRoomPaginate(?PaginateData $paginate_dto = null)
* @method array storeClassRoom(?ClassRoomData $class_room_dto = null)
* @method Builder classRoom(mixed $conditionals = null)
*/
interface ClassRoom extends DataManagement{}
