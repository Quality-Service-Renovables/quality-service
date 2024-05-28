<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Oils\Category;

test('create', function () {
    $response = $this->post('/api/oil/categories', [
        'ct_oil' => 'Unit Test Oil Category',
        'description' => 'Unit Test Oil Category',
        'active' => true,
    ]);
    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/oil/categories');
    $response->assertStatus(200);
});

test('update', function () {

    $category = Category::where('ct_oil_code', 'unit_test_ct_oil')->first();

    $this->assertNotNull($category, 'Oil category not found');

    $response = $this->put('/api/oil/categories/'.$category->ct_oil_uuid, [
        'ct_oil' => 'Unit Test Oil Category',
        'description' => 'field_updated',
        'active' => true,
    ]);

    $categoryUpdated = Category::where('ct_oil_uuid', $category->ct_oil_uuid)->first();

    $this->assertNotNull($categoryUpdated, 'Oil category updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['description']);
});

test('delete', function () {
    // Obtiene categoria del aceite por uuid
    $category = Category::where('ct_oil_code', 'unit_test_ct_oil')->first();
    // Verifica si la categoria del aceite existe
    $this->assertSame('unit_test_ct_oil', $category->ct_oil_code, 'Oil category not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/oil/categories/'.$category->ct_oil_uuid);
    // Recupera registro de la categoria del aceite eliminado
    $categoryDeleted = Category::where('ct_oil_code', 'unit_test_ct_oil')->first();
    // Prueba de categoria del aceite eliminado
    $this->assertNull($categoryDeleted, 'Oil category cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
