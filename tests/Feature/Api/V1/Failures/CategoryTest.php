<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Failures\Category;

test('create', function () {
    $response = $this->post('/api/failure/categories', [
        'failure_category' => 'Unit Test Failure Category',
        'description' => 'Unit Test Failure Category',
        'active' => true
    ]);

    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/failure/categories');
    $response->assertStatus(200);
});

test('update', function () {
    $failure= Category::where('failure_category_code', 'unit_test_failure_category')->first();

    $this->assertNotNull($failure, 'Failure category not found');

    $response = $this->put('/api/failure/categories/'.$failure->failure_category_uuid, [
        'failure_category' => 'Unit Test Failure Category',
        'description' => 'field_updated',
        'active' => true
    ]);

    $failureUpdated = Category::where('failure_category_uuid', $failure->failure_category_uuid)->first();

    $this->assertNotNull($failureUpdated, 'Failure category updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['description']);
});

test('delete', function () {
    // Obtiene la falla por uuid
    $failure= Category::where('failure_category_code', 'unit_test_failure_category')->first();

    // Verifica si la falla existe
    $this->assertSame('unit_test_failure_category', $failure->failure_category_code, 'Failure category not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/failure/categories/'.$failure->failure_category_uuid);
    // Recupero registro de falla eliminada
    $failureDeleted = Category::where('failure_category_code', 'unit_test_failure_category')->first();
    // Prueba de falla eliminada
    $this->assertNull($failureDeleted, 'Failure category cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
