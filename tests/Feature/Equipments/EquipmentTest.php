<?php

use App\Models\User;

test('read', function () {
    $user = User::where('email','admin@quality-service.com')->first();
    $response = $this->get('/api/equipments');
    $response->assertStatus(200);
});
