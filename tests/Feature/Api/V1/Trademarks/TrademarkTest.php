<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Trademarks\Trademark;

test('create', function () {
    $response = $this->post('/api/trademarks', [
        'trademark' => 'Unit Test Trademark',
        'trademark_category_code' => 'equipos',
    ]);

    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/trademarks');
    $response->assertStatus(200);
});

test('update', function () {

    $trademark = Trademark::where('trademark_code', 'unit_test_trademark')->first();

    $this->assertNotNull($trademark, 'Trademark not found');

    $response = $this->put('/api/trademarks/'.$trademark->trademark_uuid, [
        'trademark' => 'Unit Test Trademark',
        'trademark_category_code' => 'equipos',
        'active' => false,
    ]);

    $trademarkUpdated = Trademark::where('trademark_uuid', $trademark->trademark_uuid)->first();

    $this->assertNotNull($trademarkUpdated, 'Trademark updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame(0, $jsonResponse['data']['active']);
});

test('delete', function () {
    // Obtiene la marca por uuid
    $trademark = Trademark::where('trademark_code', 'unit_test_trademark')->first();
    // Verifica si la marca existe
    $this->assertSame('unit_test_trademark', $trademark->trademark_code, 'Trademark not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/trademarks/'.$trademark->trademark_uuid);
    // Recupera registro de marca
    $trademarkDeleted = Trademark::where('trademark_code', 'unit_test_trademark')->first();
    // Prueba de marca eliminada
    $this->assertNull($trademarkDeleted, 'Trademark cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
