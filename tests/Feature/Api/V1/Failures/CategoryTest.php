<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Failures\Category;

test('create', function () {
    $response = $this->post('/api/failure/categories', [
        'ct_failure' => 'Unit Test Failure CtInspection',
        'description' => 'Unit Test Failure CtInspection',
        'active' => true
    ]);

    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/failure/categories');
    $response->assertStatus(200);
});

test('update', function () {
    $failure= Category::where('ct_failure_code', 'unit_test_ct_failure')->first();

    $this->assertNotNull($failure, 'Failure category not found');

    $response = $this->put('/api/failure/categories/'.$failure->ct_failure_uuid, [
        'ct_failure' => 'Unit Test Failure CtInspection',
        'description' => 'field_updated',
        'active' => true
    ]);

    $failureUpdated = Category::where('ct_failure_uuid', $failure->ct_failure_uuid)->first();

    $this->assertNotNull($failureUpdated, 'Failure category updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['description']);
});

test('delete', function () {
    // Obtiene la falla por uuid
    $failure= Category::where('ct_failure_code', 'unit_test_ct_failure')->first();

    // Verifica si la falla existe
    $this->assertSame('unit_test_ct_failure', $failure->ct_failure_code, 'Failure category not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/failure/categories/'.$failure->ct_failure_uuid);
    // Recupero registro de falla eliminada
    $failureDeleted = Category::where('ct_failure_code', 'unit_test_ct_failure')->first();
    // Prueba de falla eliminada
    $this->assertNull($failureDeleted, 'Failure category cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
