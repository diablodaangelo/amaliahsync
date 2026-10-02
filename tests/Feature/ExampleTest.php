<?php

test('the application redirects unauthenticated guest from root to login', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});
