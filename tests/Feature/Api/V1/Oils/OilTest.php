<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */


use App\Models\Oils\Oil;

test('create', function () {
    $response = $this->post('/api/oils', [
        'oil' => 'Unit Test Oil',
        'viscosity' => 'SAE 40',
        'description' => 'Unit Test Oil',
        'oil_category_code' => 'motor',
        'trademark_code' => 'generic_oil',
        'trademark_model_code' => 'generic_model_oil',
        'production_date' => '2024-04-23',
        'expiration_date' => '2024-04-23',
        'quantity' => 5,
        'active' => true,
    ]);
    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/oils');
    $response->assertStatus(200);
});

test('update', function () {

    $category = Oil::where('oil_code', 'unit_test_oil')->first();

    $this->assertNotNull($category, 'Oil not found');

    $response = $this->put('/api/oils/'.$category->oil_uuid, [
        'oil' => 'Unit Test Oil',
        'viscosity' => 'SAE 40',
        'description' => 'field_updated',
        'oil_category_code' => 'motor',
        'trademark_code' => 'generic_oil',
        'trademark_model_code' => 'generic_model_oil',
        'production_date' => '2024-04-23',
        'expiration_date' => '2024-04-23',
        'quantity' => 5,
        'active' => true,
    ]);

    $categoryUpdated = Oil::where('oil_uuid', $category->oil_uuid)->first();

    $this->assertNotNull($categoryUpdated, 'Oil updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['description']);
});

test('delete', function () {
    // Obtiene el aceite por uuid
    $category = Oil::where('oil_code', 'unit_test_oil')->first();
    // Verifica si el aceite existe
    $this->assertSame('unit_test_oil', $category->oil_code, 'Oil not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/oils/'.$category->oil_uuid);
    // Recupera registro del aceite eliminado
    $categoryDeleted = Oil::where('oil_code', 'unit_test_oil')->first();
    // Prueba del aceite eliminado
    $this->assertNull($categoryDeleted, 'Oil cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
