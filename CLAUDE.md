# CLAUDE.md - Module Class Room

This file provides guidance to Claude Code when working with this module.

## Module Overview

**`hanafalah/module-class-room`** is a Laravel package for managing class rooms (hospital room classes/categories) in the Wellmed healthcare system. It handles room classification for inpatient services, enabling categorization of rooms by service type (e.g., VK - Verlos Kamer/Delivery Room, Inpatient wards).

### Purpose

This module manages:
- Room classifications/categories for healthcare facilities
- Association between rooms and medical service types
- Room status lifecycle (DRAFT, ACTIVE, INACTIVE)

## CRITICAL: Memory Exhaustion Warning

**This module uses `registers(['*'])` in its ServiceProvider, which can cause memory issues.**

```php
// In ModuleClassRoomServiceProvider.php
public function register()
{
    $this->registerMainClass(ModuleClassRoom::class)
        ->registerCommandService(Providers\CommandServiceProvider::class)
        ->registers(['*']);  // CAUTION: Can cause memory issues
}
```

**Risk Assessment:**
- The `registers(['*'])` call auto-registers all components including Schema classes
- `Schemas\ClassRoom` extends `PackageManagement` which uses `HasModelConfiguration` trait
- This chain can trigger memory exhaustion during bootstrap

**Safe Alternative (if issues occur):**
```php
public function register()
{
    $this->registerMainClass(ModuleClassRoom::class)
        ->registerCommandService(Providers\CommandServiceProvider::class);
    // Register specific components manually instead of ['*']
}
```

See `laravel-support/CLAUDE.md` for detailed memory issue documentation.

## Architecture

```
module-class-room/
├── assets/
│   ├── config/
│   │   └── config.php              # Module configuration
│   └── database/
│       └── migrations/
│           └── 0000_00_00_000110_create_class_rooms_table.php
├── src/
│   ├── Commands/
│   │   ├── EnvironmentCommand.php  # Base command class
│   │   └── InstallMakeCommand.php  # php artisan module-class-room:install
│   ├── Concerns/
│   │   └── HasClassRoom.php        # Trait for models with class room relations
│   ├── Contracts/
│   │   ├── Data/
│   │   │   └── ClassRoomData.php   # Data contract
│   │   ├── Schemas/
│   │   │   └── ClassRoom.php       # Schema contract with method signatures
│   │   └── ModuleClassRoom.php     # Main module contract
│   ├── Data/
│   │   └── ClassRoomData.php       # Spatie Data Transfer Object
│   ├── Enums/
│   │   ├── ClassRoom/
│   │   │   └── ClassRoomStatus.php # DRAFT, ACTIVE, INACTIVE
│   │   └── MedicService/
│   │       └── MedicServiceFlag.php # VK (Verlos Kamer), INPATIENT
│   ├── Facades/
│   │   └── ModuleClassRoom.php     # Laravel Facade
│   ├── Models/
│   │   └── ClassRoom/
│   │       └── ClassRoom.php       # Eloquent model
│   ├── Providers/
│   │   └── CommandServiceProvider.php
│   ├── Resources/
│   │   ├── ClassRoom/
│   │   │   └── ViewClassRoom.php   # API resource
│   │   └── ClassRoomItem/
│   │       ├── ViewClassRoomItem.php
│   │       └── ShowClassRoomItem.php
│   ├── Schemas/
│   │   └── ClassRoom.php           # Business logic layer
│   ├── Supports/
│   │   └── BaseModuleClassRoom.php # Base class extending PackageManagement
│   ├── ModuleClassRoom.php         # Main module class
│   └── ModuleClassRoomServiceProvider.php
└── composer.json
```

## Key Classes

### ClassRoom Model

Located at: `src/Models/ClassRoom/ClassRoom.php`

**Features:**
- Uses ULID primary keys (`HasUlids`)
- Soft deletes enabled
- Props storage (`HasProps`)
- Service relationship (`HasService`)

**Status Constants:**
```php
const STATUS_ACTIVE = 'ACTIVE';
const STATUS_ARCHIVE = 'ARCHIVE';
```

**Key Relationships:**
```php
// Belongs to a service type
public function serviceType() {
    return $this->belongsToModel('Service', 'service_type_id');
}
```

**Auto-set default status on create:**
```php
static::creating(function ($query) {
    $query->status ??= $query->getClassRoomStatus('ACTIVE');
});
```

### ClassRoom Schema

Located at: `src/Schemas/ClassRoom.php`

Business logic layer implementing `Contracts\Schemas\ClassRoom`.

**Key Methods:**
- `prepareStoreClassRoom(ClassRoomData $dto)` - Create/update class room with service association
- Uses caching with tags: `class_room`, `class_room-index`

**Cache Configuration:**
```php
protected array $__cache = [
    'index' => [
        'name'     => 'class_room',
        'tags'     => ['class_room', 'class_room-index'],
        'forever'  => 24*60*7  // 7 days
    ]
];
```

### ClassRoomData DTO

Located at: `src/Data/ClassRoomData.php`

Spatie Laravel Data object for data transfer:
```php
public mixed $id = null;
public string $name;
public mixed $service_type_id = null;
public ?ServiceData $service = null;
public ?array $props = null;
```

## Enums

### ClassRoomStatus
```php
case DRAFT    = 'DRAFT';
case ACTIVE   = 'ACTIVE';
case INACTIVE = 'INACTIVE';
```

### MedicServiceFlag (Label)
```php
case VERLOS_KAMER = 'VK';      // Delivery Room
case INPATIENT    = 'INPATIENT';
```

## Database Schema

**Table: `class_rooms`**

| Column | Type | Description |
|--------|------|-------------|
| id | ULID (string) | Primary key |
| service_type_id | string (FK) | Reference to services table |
| name | string | Room class name |
| status | string(50) | ACTIVE, DRAFT, INACTIVE |
| props | JSON | Extended properties storage |
| created_at | timestamp | |
| updated_at | timestamp | |
| deleted_at | timestamp | Soft delete |

## Dependencies

```json
{
    "require": {
        "hanafalah/laravel-support": "dev-main",
        "hanafalah/module-service": "dev-main",
        "hanafalah/module-warehouse": "dev-main"
    }
}
```

**Key Dependencies:**
- `laravel-support` - Base classes, traits, and utilities
- `module-service` - Service type relationship and ServiceData DTO
- `module-warehouse` - Warehouse/inventory integration

## Configuration

Located at: `assets/config/config.php`

```php
return [
    'namespace' => 'Hanafalah\\ModuleClassRoom',
    'app' => [
        'contracts' => []
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database' => [
        'models' => []
    ],
    'commands' => [
        ModuleClassRoomCommands\InstallMakeCommand::class
    ]
];
```

## Installation

```bash
php artisan module-class-room:install
```

This publishes:
- Configuration file to `config/module-class-room.php`
- Migration files

## Usage Patterns

### Using the Facade
```php
use Hanafalah\ModuleClassRoom\Facades\ModuleClassRoom;

// Access schema methods
ModuleClassRoom::useSchema('class_room')
    ->storeClassRoom($classRoomDto);
```

### Using the Schema Contract
```php
use Hanafalah\ModuleClassRoom\Contracts\Schemas\ClassRoom;

$schema = app(ClassRoom::class);
$schema->prepareStoreClassRoom($dto);
$schema->viewClassRoomList();
$schema->viewClassRoomPaginate($paginateDto);
```

### Creating a Class Room
```php
use Hanafalah\ModuleClassRoom\Data\ClassRoomData;

$dto = ClassRoomData::from([
    'name' => 'VIP Room',
    'service_type_id' => $serviceTypeId,
    'service' => [
        'name' => 'VIP Room Service',
        // ServiceData properties
    ]
]);

$classRoom = $schema->prepareStoreClassRoom($dto);
```

## API Resources

### ViewClassRoom
Returns:
```php
[
    'id'              => $this->id,
    'name'            => $this->name,
    'service_type_id' => $this->service_type_id,
    'service_type'    => $this->prop_service_type,
    'service'         => $this->prop_service,
    'status'          => $this->status,
    'class_room_items' => $this->class_room_items,
    'created_at'      => $this->created_at,
    'updated_at'      => $this->updated_at
]
```

## Known Issues

### HasClassRoom Trait Namespace
The `HasClassRoom` trait has an incorrect namespace:
```php
// Current (incorrect):
namespace Hanafalah\Moduletreatment\Concerns;

// Should be:
namespace Hanafalah\ModuleClassRoom\Concerns;
```

This trait is currently non-functional due to the namespace mismatch.

### InstallMakeCommand Provider Reference
The install command references an incorrect provider:
```php
// Current (incorrect):
$provider = 'Hanafalah\ModuleClassRoom\ModuleTreatmentServiceProvider';

// Should be:
$provider = 'Hanafalah\ModuleClassRoom\ModuleClassRoomServiceProvider';
```

## Development Notes

### Testing Changes

After modifying this module:
```bash
# Clear caches
docker exec -it wellmed-backbone php artisan config:clear
docker exec -it wellmed-backbone php artisan cache:clear

# Reload Octane
docker exec -it wellmed-backbone php artisan octane:reload

# Monitor for memory issues
docker logs wellmed-backbone 2>&1 | grep -i "memory\|fatal"
```

### Adding New Features

When extending this module:
1. Add contracts first in `Contracts/`
2. Implement in `Schemas/` or `Models/`
3. Update resources in `Resources/`
4. Update DTO if needed in `Data/`
5. Be cautious of memory issues - avoid adding to `registers(['*'])` chain

## Modification Checklist

Before modifying this module:
- [ ] Understand the relationship with `module-service`
- [ ] Check if changes affect the Schema class loading
- [ ] Test with multiple tenants (multi-tenancy context)
- [ ] Verify cache invalidation for `class_room` tags
- [ ] Reload Octane after changes
- [ ] Monitor memory usage during bootstrap
