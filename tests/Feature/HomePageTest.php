<?php

declare(strict_types=1);

test('check home page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
