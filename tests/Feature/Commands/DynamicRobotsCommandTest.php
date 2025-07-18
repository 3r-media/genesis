<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Rrr\Genesis\Support\DynamicRobotsTxt;

beforeEach(function () {
    $this->robotsPath = public_path('robots.txt');
    File::ensureDirectoryExists(public_path());
});

afterEach(function () {
    if (File::exists($this->robotsPath)) {
        File::delete($this->robotsPath);
    }
});

it('informs user when robots.txt does not exist', function () {
    if (File::exists($this->robotsPath)) {
        File::delete($this->robotsPath);
    }

    Artisan::call('robots:install');

    expect(Artisan::output())->toContain('No existing robots.txt file found.');
});

it('keeps existing robots.txt when user declines deletion', function () {
    File::put($this->robotsPath, 'User-agent: *');

    // Inject mock input for readline
    $mock = fn() => 'n';

    $result = DynamicRobotsTxt::checkAndPromptForRobotsTxt($mock);

    expect(File::exists($this->robotsPath))->toBeTrue()
        ->and($result)->toContain('Leaving existing robots.txt file.');
});

it('deletes robots.txt when user confirms', function () {
    File::put($this->robotsPath, 'User-agent: *');

    $mock = fn() => 'y';

    $result = DynamicRobotsTxt::checkAndPromptForRobotsTxt($mock);

    expect(File::exists($this->robotsPath))->toBeFalse()
        ->and($result)->toContain('Existing robots.txt file deleted.');
});
