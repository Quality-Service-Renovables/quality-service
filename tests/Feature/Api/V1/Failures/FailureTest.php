<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Failures\Failure;

test('create', function () {
    $response = $this->post('/api/failures', [
        'failure' => 'Unit Test Failure',
        'description' => 'unit test failure',
        'ct_failure_code' => 'general',
        'active' => true
    ]);

    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/failures');
    $response->assertStatus(200);
});

test('update', function () {
    $failure= Failure::where('failure_code', 'unit_test_failure')->first();

    $this->assertNotNull($failure, 'Failure not found');

    $response = $this->put('/api/failures/'.$failure->failure_uuid, [
        'failure' => 'Unit Test Failure',
        'description' => 'field_updated',
        'ct_failure_code' => 'general',
        'active' => true
    ]);

    $failureUpdated = Failure::where('failure_uuid', $failure->failure_uuid)->first();

    $this->assertNotNull($failureUpdated, 'Failure updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['description']);
});

test('delete', function () {
    // Obtiene la falla por uuid
    $failure= Failure::where('failure_code', 'unit_test_failure')->first();
    // Verifica si la falla existe
    $this->assertSame('unit_test_failure', $failure->failure_code, 'Failure not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/failures/'.$failure->failure_uuid);
    // Recupero registro de falla eliminada
    $failureDeleted = Failure::where('failure_code', 'unit_test_failure')->first();
    // Prueba de falla eliminada
    $this->assertNull($failureDeleted, 'Failure cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
