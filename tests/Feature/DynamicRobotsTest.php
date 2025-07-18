<?php

it('renders the robots.txt', function () {
    $this->get('/robots.txt')
        ->assertOk();
});

it('allows all bots in production', function () {
    $this->app->detectEnvironment(function () {
        return 'production';
    });

    $this->get('/robots.txt')
        ->assertSeeText('User-agent: *')
        ->assertDontSeeText('Disallow: /');
});

it('disallows all bots in non-production environments', function ($env) {
    $this->app->detectEnvironment(function () use ($env) {
        return $env;
    });

    $this->get('/robots.txt')
        ->assertSeeText('User-agent: *')
        ->assertSeeText('Disallow: /');
})->with(['local', 'staging', 'feature']);
