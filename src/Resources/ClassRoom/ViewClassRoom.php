<?php

namespace Hanafalah\ModuleClassRoom\Resources\ClassRoom;

use Illuminate\Http\Request;
use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewClassRoom extends ApiResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(Request $request): array
  {
    $arr = [
      'id'              => $this->id,
      'name'            => $this->name,
      'service_type_id' => $this->service_type_id,
      'service_type'    => $this->prop_service_type,
      'service'         => $this->prop_service,
      'status'          => $this->status,
      'class_room_items' => $this->class_room_items,
      'created_at'      => $this->created_at,
      'updated_at'      => $this->updated_at
    ];
    return $arr;
  }
}
