<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Trademarks\TrademarkModel;

test('create', function () {
    $response = $this->post('/api/trademark/models', [
        'trademark_model' => 'Unit Test Trademark Model',
        'trademark_code' => 'generic_equipment',
    ]);
    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/trademark/models');
    $response->assertStatus(200);
});

test('update', function () {

    $trademark = TrademarkModel::where('trademark_model_code', 'unit_test_trademark_model')->first();

    $this->assertNotNull($trademark, 'Trademark Model not found');

    $response = $this->put('/api/trademark/models/'.$trademark->trademark_model_uuid, [
        'trademark_model' => 'Unit Test Trademark Model',
        'trademark_code' => 'generic_equipment',
        'active' => false,
    ]);

    $trademarkUpdated = TrademarkModel::where('trademark_model_uuid', $trademark->trademark_model_uuid)->first();

    $this->assertNotNull($trademarkUpdated, 'Trademark Model updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame(0, $jsonResponse['data']['active']);
});

test('delete', function () {
    // Obtiene la marca por uuid
    $trademark = TrademarkModel::where('trademark_model_code', 'unit_test_trademark_model')->first();
    // Verifica si la marca existe
    $this->assertSame('unit_test_trademark_model', $trademark->trademark_model_code, 'Trademark Model not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/trademark/models/'.$trademark->trademark_model_uuid);
    // Recupera registro de marca
    $trademarkDeleted = TrademarkModel::where('trademark_model_code', 'unit_test_trademark_model')->first();
    // Prueba de marca eliminada
    $this->assertNull($trademarkDeleted, 'Trademark cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
