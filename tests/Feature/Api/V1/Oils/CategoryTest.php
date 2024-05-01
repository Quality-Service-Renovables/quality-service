<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Oils\Category;

test('create', function () {
    $response = $this->post('/api/oil/categories', [
        'oil_category' => 'Unit Test Oil Category',
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

    $category = Category::where('oil_category_code', 'unit_test_oil_category')->first();

    $this->assertNotNull($category, 'Oil category not found');

    $response = $this->put('/api/oil/categories/'.$category->oil_category_uuid, [
        'oil_category' => 'Unit Test Oil Category',
        'description' => 'field_updated',
        'active' => true,
    ]);

    $categoryUpdated = Category::where('oil_category_uuid', $category->oil_category_uuid)->first();

    $this->assertNotNull($categoryUpdated, 'Oil category updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['description']);
});

test('delete', function () {
    // Obtiene categoria del aceite por uuid
    $category = Category::where('oil_category_code', 'unit_test_oil_category')->first();
    // Verifica si la categoria del aceite existe
    $this->assertSame('unit_test_oil_category', $category->oil_category_code, 'Oil category not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/oil/categories/'.$category->oil_category_uuid);
    // Recupera registro de la categoria del aceite eliminado
    $categoryDeleted = Category::where('oil_category_code', 'unit_test_oil_category')->first();
    // Prueba de categoria del aceite eliminado
    $this->assertNull($categoryDeleted, 'Oil category cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
