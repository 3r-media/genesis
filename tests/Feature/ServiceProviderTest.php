<?php

use Rrr\Genesis\GenesisServiceProvider;
use Illuminate\Contracts\Foundation\Application;

it('registers the GenesisServiceProvider', function () {
    $app = $this->app;
    $registeredProviders = array_keys($app->getLoadedProviders());
    expect($registeredProviders)->toContain(GenesisServiceProvider::class);
});
