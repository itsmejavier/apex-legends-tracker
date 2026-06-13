<?php

test('guests are redirected away from protected pages', function (string $path) {
    $this->get($path)
        ->assertRedirect(route('login'));
})->with([
    '/home',
    '/dashboard',
    '/chatbot',
]);

test('logged in sessions can access protected pages', function (string $path) {
    $this->withSession(['logged_in' => true])
        ->get($path)
        ->assertOk();
})->with([
    '/home',
    '/dashboard',
    '/chatbot',
]);

test('logged in sessions are redirected from login page to home', function () {
    $this->withSession(['logged_in' => true])
        ->get('/')
        ->assertRedirect(route('home'));
});
