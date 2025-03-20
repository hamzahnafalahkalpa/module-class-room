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
      'id'         => $this->id,
      'name'       => $this->name,
      'service_id' => $this->service_id,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];

    return $arr;
  }
}
