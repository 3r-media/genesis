<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

it('updates the README.md file with all Composer and NPM dependencies', function () {
    // Setup: Fake a storage disk for isolated file handling
    Storage::fake('temp');

    // Create mock composer.json with both require and require-dev
    Storage::disk('temp')->put('composer.json', json_encode(['require' => [
            'laravel/framework' => '^10.10'
        ],
        'require-dev' => [
            'pestphp/pest' => '^3.8'
        ],
    ]));

    // Create mock package.json with both dependencies and devDependencies
    Storage::disk('temp')->put('package.json', json_encode([
        'dependencies' => [
            'vue' => '^3.0'
        ],
        'devDependencies' => [
            'vite' => '^4.0'
        ],
    ]));

    // Initial stub README structure with expected section headers
    Storage::disk('temp')->put('README.md', "## Composer Dependencies\n\n\n## Composer Dev Dependencies\n\n\n## NPM Dependencies\n\n\n## NPM Dev Dependencies\n\n\n");

    // Run the command using mocked paths
    Artisan::call('readme:update', [
        'composerPath' => Storage::disk('temp')->path('composer.json'),
        'packagePath' => Storage::disk('temp')->path('package.json'),
        'readmePath' => Storage::disk('temp')->path('README.md'),
    ]);

    // Assertions
    $updated = Storage::disk('temp')->get('README.md');

    expect($updated)->toContain('- laravel/framework: ^10.10')
        ->and($updated)->toContain('- pestphp/pest: ^3.8')
        ->and($updated)->toContain('- vue: ^3.0')
        ->and($updated)->toContain('- vite: ^4.0');
});
