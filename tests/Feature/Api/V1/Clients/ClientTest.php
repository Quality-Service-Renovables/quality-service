<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

use App\Models\Clients\Client;

test('create', function () {
    $response = $this->post('/api/clients', [
        'client' => 'Unit Test Client',
        'logo' => null,
        'legal_name' => 'Unit Test Legal Name',
        'address' => 'C./Col Petrolera Plaza 21 s/c n.4 Salina Cruz Oaxaca Mex.',
        'zip_code' => '70620',
        'phone' => '9712084735',
        'phone_office' => '9711335323',
        'open_time' => '08:00',
        'close_time' => '16:00',
        'office_days' => 'Lunes a Sábado',
        'website' => 'https://qualityservicerenovables.com.mx/',
        'email' => 'unit-test@example.com',
        'active' => true,
    ]);
    $response->assertStatus(201);
});

test('read', function () {
    $response = $this->get('/api/clients');
    $response->assertStatus(200);
});

test('update', function () {

    $category = Client::where('client_code', 'unit_test_client')->first();

    $this->assertNotNull($category, 'Client not found');

    $response = $this->put('/api/clients/'.$category->client_uuid, [
        'client' => 'Unit Test Client',
        'logo' => null,
        'legal_name' => 'field_updated',
        'address' => 'C./Col Petrolera Plaza 21 s/c n.4 Salina Cruz Oaxaca Mex.',
        'zip_code' => '70620',
        'phone' => '9712084735',
        'phone_office' => '9711335323',
        'open_time' => '08:00',
        'close_time' => '16:00',
        'office_days' => 'Lunes a Sábado',
        'website' => 'https://qualityservicerenovables.com.mx/',
        'email' => 'unit-test@example.com',
        'active' => true,
    ]);

    $categoryUpdated = Client::where('client_uuid', $category->client_uuid)->first();

    $this->assertNotNull($categoryUpdated, 'Client updated not found');

    $jsonResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

    $response->assertStatus(200);
    $this->assertSame('field_updated', $jsonResponse['data']['legal_name']);
});

test('delete', function () {
    // Obtiene equipo por uuid
    $category = Client::where('client_code', 'unit_test_client')->first();
    // Verifica si el equipo existe
    $this->assertSame('unit_test_client', $category->client_code, 'Client category not found');
    // Ejecuta proceso de eliminación
    $response = $this->delete('/api/clients/'.$category->client_uuid);
    // Recupero registro de equipo eliminado
    $categoryDeleted = Client::where('client_code', 'unit_test_client')->first();
    // Prueba de equipo eliminado
    $this->assertNull($categoryDeleted, 'Client category cant be deleted');
    // Prueba código de estado
    $response->assertStatus(200);
});
