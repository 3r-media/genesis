<?php

namespace Rrr\Genesis\Support;

class DynamicReadme
{
    public static function updateReadme(string $composerPath, string $packagePath, string $readmePath): void
    {

        $composerJson = json_decode(file_get_contents($composerPath), true);
        $packageJson = json_decode(file_get_contents($packagePath), true);

        $composerDependencies = $composerJson['require'] ?? [];
        $composerDevDependencies = $composerJson['require-dev'] ?? [];
        $nodeDependencies = $packageJson['dependencies'] ?? [];
        $nodeDevDependencies = $packageJson['devDependencies'] ?? [];

        $readmeContent = self::getReadmeContent($readmePath);

        $readmeContent = self::updateDependenciesSection($readmeContent, '## Composer Dependencies', $composerDependencies);
        $readmeContent = self::updateDependenciesSection($readmeContent, '## Composer Dev Dependencies', $composerDevDependencies);
        $readmeContent = self::updateDependenciesSection($readmeContent, '## NPM Dependencies', $nodeDependencies);
        $readmeContent = self::updateDependenciesSection($readmeContent, '## NPM Dev Dependencies', $nodeDevDependencies);

        file_put_contents($readmePath, $readmeContent);

    }

    public static function getReadmeContent($readmePath): bool|string
    {
        return file_get_contents($readmePath);
    }

    private static function updateDependenciesSection(string $content, string $sectionHeading, array $dependencies): string
    {
        $dependencyString = '';
        foreach ($dependencies as $dependency => $version) {
            $dependencyString .= "- {$dependency}: {$version}\n";
        }

        // Match from heading to either next heading or end of file
        $pattern = '/(' . preg_quote($sectionHeading, '/') . '\n)(.*?)(?=(\n## |\z))/s';

        return preg_replace_callback($pattern, function ($matches) use ($dependencyString) {
            return $matches[1] . $dependencyString;
        }, $content);
    }
}
