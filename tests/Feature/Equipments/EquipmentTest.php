<?php

use App\Models\Equipments\Equipment;

test('create', function () {
    $response = $this->post('/api/equipments', [
        'equipment' => 'Unit Test Equipment',
        'equipment_category_code' => 'generador',
        'trademark_code' => 'generic',
        'status_code' => 'operacion',
        'model' => 'Test',
        'serial_number' => 'unit_test_parameter',
    ]);
    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/equipments');
    $response->assertStatus(200);
});

test('update', function () {

    $equipment = Equipment::where('equipment_code', 'unit_test_equipment')->first();
    if (! $equipment) {
        echo '⚠️ No se ha encontrado el equipo!'.'/n';

        return false;
    }

    $response = $this->put('/api/equipments/'.$equipment->equipment_uuid, [
        'equipment' => 'Unit Test Equipment',
        'equipment_category_code' => 'generador',
        'trademark_code' => 'generic',
        'status_code' => 'operacion',
        'model' => 'Test',
        'serial_number' => 'field_updated',
    ]);

    $equipmentUpdated = Equipment::where('equipment_uuid', $equipment->equipment_uuid)->first();
    if (! $equipmentUpdated) {
        echo '⚠️ No se ha encontrado el equipo actualizado!'.'/n';

        return false;
    }

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
