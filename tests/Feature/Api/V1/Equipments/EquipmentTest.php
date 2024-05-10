<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Equipments\Equipment;
use Illuminate\Http\UploadedFile;

test('create', function () {
    // Crear documentos simulados para la prueba
    $image = UploadedFile::fake()->image('equipment_image.jpg');
    $manual = UploadedFile::fake()->create('document.pdf');

    $response = $this->post('/api/equipments', [
        'equipment' => 'Unit Test Equipment',
        'equipment_image_storage' => $image,
        'serial_number' => 'SN-0001',
        'manufacture_date' => '2024-04-25',
        'work_hours' => 9,
        'barcode' => 'test-barcode',
        'description' => 'Unit test equipment register',
        'manual_storage' => $manual,
        'ct_equipment_code' => 'generador',
        'trademark_code' => 'generic_equipment',
        'trademark_model_code' => 'generic_model_equipment',
        'status_code' => 'operacion',
        'active' => true,
    ]);

    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/equipments');
    $response->assertStatus(200);
});

test('update', function () {
    $equipment = Equipment::where('equipment_code', 'unit_test_equipment')->first();

    $this->assertNotNull($equipment, 'Equipment not found');

    // Crear documentos simulados para la prueba
    $image = UploadedFile::fake()->image('equipment_image.jpg');
    $manual = UploadedFile::fake()->create('document.pdf');

    $response = $this->put('/api/equipments/update'.$equipment->equipment_uuid, [
        'equipment' => 'Unit Test Equipment',
        'equipment_image_storage' => $image,
        'serial_number' => 'field_updated',
        'manufacture_date' => '2024-04-25',
        'work_hours' => '1200',
        'barcode' => 'test-barcode',
        'description' => 'Unit test equipment register',
        'manual_storage' => $manual,
        'ct_equipment_code' => 'generador',
        'trademark_code' => 'generic_equipment',
        'trademark_model_code' => 'generic_model_equipment',
        'status_code' => 'operacion',
        'active' => true,
    ]);

    $equipmentUpdated = Equipment::where('equipment_uuid', $equipment->equipment_uuid)->first();

    $this->assertNotNull($equipmentUpdated, 'Equipment updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['serial_number']);
});

test('delete', function () {
    // Obtiene equipo por uuid
    $equipment = Equipment::where('equipment_code', 'unit_test_equipment')->first();
    // Verifica si el equipo existe
    $this->assertSame('unit_test_equipment', $equipment->equipment_code, 'Equipment not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/equipments/'.$equipment->equipment_uuid);
    // Recupero registro de equipo eliminado
    $equipmentDeleted = Equipment::where('equipment_code', 'unit_test_equipment')->first();
    // Prueba de equipo eliminado
    $this->assertNull($equipmentDeleted, 'Equipment cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
