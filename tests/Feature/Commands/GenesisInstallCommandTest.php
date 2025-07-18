<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

it('publishes the .gitignore stub using the StubPublisher and genesis:install command', function (string $stub, string $content) {
    $tempPath = base_path('tests/tmp-' . Str::random(8));
    File::ensureDirectoryExists($tempPath);

    $targetFile = $tempPath . $stub;
    expect(File::exists($targetFile))->toBeFalse();

    $exitCode = Artisan::call('genesis:install', [
        'appPath' => $tempPath,
    ]);

    expect($exitCode)->toBe(0)
        ->and(File::exists($targetFile))->toBeTrue()
        ->and(File::get($targetFile))->toContain($content);

    File::deleteDirectory($tempPath);
})->with("stubsAndContent");
