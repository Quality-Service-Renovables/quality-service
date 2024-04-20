<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Status\Status;

test('create', function () {
    $response = $this->post('/api/status', [
        'status' => 'Unit Test Status',
        'description' => 'Unit Test Status',
        'active' => true,
    ]);
    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/status');
    $response->assertStatus(200);
});

test('update', function () {

    $status = Status::where('status_code', 'unit_test_status')->first();

    $this->assertNotNull($status, 'Status not found');

    $response = $this->put('/api/status/'.$status->status_uuid, [
        'status' => 'Unit Test Status',
        'description' => 'field_updated',
        'active' => true,
    ]);

    $statusUpdated = Status::where('status_uuid', $status->status_uuid)->first();

    $this->assertNotNull($statusUpdated, 'Status updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['description']);
});

test('delete', function () {
    // Obtiene equipo por uuid
    $status = Status::where('status_code', 'unit_test_status')->first();
    // Verifica si el equipo existe
    $this->assertSame('unit_test_status', $status->status_code, 'Status not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/status/'.$status->status_uuid);
    // Recupero registro de equipo eliminado
    $statusDeleted = Status::where('status_code', 'unit_test_status')->first();
    // Prueba de equipo eliminado
    $this->assertNull($statusDeleted, 'Status cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
