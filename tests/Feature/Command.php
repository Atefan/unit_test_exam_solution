<?php

it('has command page', function () {
    $response = $this->get('/command');

    $response->assertStatus(200);
});
