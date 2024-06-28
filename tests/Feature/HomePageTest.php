<?php

test('check home page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
