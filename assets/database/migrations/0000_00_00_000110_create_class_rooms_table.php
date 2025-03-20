<?php

use Hanafalah\ModuleMedicService\Models\MedicService;
use Gilanggustina\ModuleTreatment\Enums\Treatment\TreatmentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Gilanggustina\ModuleClassRoom\Models\ClassRoom\ClassRoom;

return new class extends Migration
{
    private $__table, $__table_medic_service;

    public function __construct()
    {
        $this->__table = app(config('database.models.ClassRoom', ClassRoom::class));
        $this->__table_medic_service = app(config('database.models.MedicService', MedicService::class));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (!$this->isTableExists()) {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable(false);
                $table->tinyInteger('status')->default(TreatmentStatus::ACTIVE->value);
                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table($table_name, function (Blueprint $table) {
                $table->foreignIdFor($this->__table_medic_service, 'medic_service_id')->nullable()->after('id')->index()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->__table->getTable());
    }
};
