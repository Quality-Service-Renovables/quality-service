<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Inspections\Category;

test('create', function () {
    $response = $this->post('/api/inspection/categories', [
        'ct_inspection' => 'Unit Test Inspection Category',
        'description' => 'unit test inspection category',
        'active' => true,
    ]);
    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/inspection/categories');
    $response->assertStatus(200);
});

test('update', function () {

    $category = Category::where('ct_inspection_code', 'unit_test_ct_inspection')->first();

    $this->assertNotNull($category, 'Inspection category not found');

    $response = $this->put('/api/inspection/categories/'.$category->ct_inspection_uuid, [
        'ct_inspection' => 'Unit Test Inspection Category',
        'description' => 'field_updated',
        'active' => true,
    ]);

    $categoryUpdated = Category::where('ct_inspection_uuid', $category->ct_inspection_uuid)->first();

    $this->assertNotNull($categoryUpdated, 'Inspection category updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['description']);
});

test('delete', function () {
    // Obtiene la categoria de inspección por uuid
    $category = Category::where('ct_inspection_code', 'unit_test_ct_inspection')->first();
    // Verifica si la categoria de inspección existe
    $this->assertSame('unit_test_ct_inspection', $category->ct_inspection_code, 'Inspection category not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/inspection/categories/'.$category->ct_inspection_uuid);
    // Recupero registro de catagoria de inspección eliminada
    $categoryDeleted = Category::where('ct_inspection_code', 'unit_test_ct_inspection')->first();
    // Prueba de categoria de inspección eliminada
    $this->assertNull($categoryDeleted, 'Inspection category cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
