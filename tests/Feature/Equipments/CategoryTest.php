<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Equipments\Category;

test('create', function () {
    $response = $this->post('/api/equipment/categories', [
        'equipment_category' => 'Unit Test Equipment Category',
        'description' => 'unit test equipment category',
        'active' => true,
    ]);
    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/equipment/categories');
    $response->assertStatus(200);
});

test('update', function () {

    $category = Category::where('equipment_category_code', 'unit_test_equipment_category')->first();

    $this->assertNotNull($category, 'Equipment category not found');

    $response = $this->put('/api/equipment/categories/'.$category->equipment_category_uuid, [
        'equipment_category' => 'Unit Test Equipment Category',
        'description' => 'field_updated',
        'active' => true,
    ]);

    $categoryUpdated = Category::where('equipment_category_uuid', $category->equipment_category_uuid)->first();

    $this->assertNotNull($categoryUpdated, 'Equipment category updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['description']);
});

test('delete', function () {
    // Obtiene equipo por uuid
    $category = Category::where('equipment_category_code', 'unit_test_equipment_category')->first();
    // Verifica si el equipo existe
    $this->assertSame('unit_test_equipment_category', $category->equipment_category_code, 'Equipment category not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/equipment/categories/'.$category->equipment_category_uuid);
    // Recupero registro de equipo eliminado
    $categoryDeleted = Category::where('equipment_category_code', 'unit_test_equipment_category')->first();
    // Prueba de equipo eliminado
    $this->assertNull($categoryDeleted, 'Equipment category cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
