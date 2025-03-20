<?php

namespace Hanafalah\ModuleClassRoom\Contracts;

use Hanafalah\LaravelSupport\Contracts\DataManagement;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ClassRoom extends DataManagement
{
  public function prepareViewClassRoomList(?array $attributes = null): Collection;
  public function viewClassRoomList(): array;
  public function showUsingRelation(): array;
  public function prepareShowClassRoom(?Model $model = null, array $attributes = null): Model;
  public function showClassRoom(?Model $model = null): array;
  public function prepareStoreClassRoom(?array $attributes = null): Model;
  public function storeClassRoom(): array;
  public function prepareDeleteClassRoom(?array $attributes = null): bool;
  public function deleteClassRoom(): bool;
  public function classRoom(): Builder;
}
