<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Trademarks\Category;

test('create', function () {
    $response = $this->post('/api/trademark/categories', [
        'trademark_category' => 'Unit Test Trademark Category',
    ]);

    $jsonResponse = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

    if ($response->status() !== 201) {
        dump($jsonResponse);
    }

    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/trademark/categories');
    $response->assertStatus(200);
});

test('update', function () {

    $category = Category::where('trademark_category_code', 'unit_test_trademark_category')->first();

    $this->assertNotNull($category, 'Trademark category not found');

    $response = $this->put('/api/trademark/categories/'.$category->trademark_category_uuid, [
        'trademark_category' => 'Unit Test Trademark Category',
        'active' => false,
    ]);

    $categoryUpdated = Category::where('trademark_category_uuid', $category->trademark_category_uuid)->first();

    $this->assertNotNull($categoryUpdated, 'Trademark category updated not found');

    $jsonResponse = json_decode($response->getContent(), false, 512, JSON_THROW_ON_ERROR);

    if ($response->status() !== 200) {
        dump($jsonResponse);
    }

    $response->assertStatus(200);
    $this->assertSame(0, $jsonResponse->data->active);
});

test('delete', function () {
    // Obtiene la marca por uuid
    $trademark = Category::where('trademark_category_code', 'unit_test_trademark_category')->first();
    // Verifica si la marca existe
    $this->assertSame('unit_test_trademark_category', $trademark->trademark_category_code, 'Trademark not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/trademark/categories/'.$trademark->trademark_category_uuid);
    // Recupera registro de marca
    $trademarkDeleted = Category::where('trademark_category_code', 'unit_test_trademark_category')->first();
    // Prueba de marca eliminada
    $this->assertNull($trademarkDeleted, 'Trademark category cant be deleted');

    if ($response->status() !== 200) {
        dump($jsonResponse);
    }
    // Prueba código de estado
    $response->assertStatus(200);
});
