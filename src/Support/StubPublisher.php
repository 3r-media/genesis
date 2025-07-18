<?php

namespace Rrr\Genesis\Support;

use Illuminate\Support\Facades\File;

class StubPublisher
{
    protected string $stubDir;
    protected string $targetDir;

    public function __construct(string $stubDir, string $targetDir)
    {
        $this->stubDir = rtrim($stubDir, '/');
        $this->targetDir = rtrim($targetDir, '/');
    }

    public function publish(array $files, bool $force = false): array
    {
        $published = [];

        foreach ($files as $stubName => $targetName) {
            $from = "{$this->stubDir}/{$stubName}";
            $to = "{$this->targetDir}/{$targetName}";

            if (!File::exists($from)) {
                continue;
            }

            if (File::isDirectory($from)) {
                if (!File::exists($to) || $force) {
                    if ($force && File::exists($to)) {
                        File::deleteDirectory($to);
                    }

                    File::copyDirectory($from, $to);
                    $published[] = rtrim($targetName, '/') . '/';
                }
            } elseif (File::isFile($from)) {
                if (!File::exists($to) || $force) {
                    File::ensureDirectoryExists(dirname($to));
                    File::copy($from, $to);
                    $published[] = $targetName;
                }
            }
        }

        return $published;
    }
}