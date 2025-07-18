<?php

namespace Rrr\Genesis\Support;

class DynamicRobotsTxt
{
    public static function checkAndPromptForRobotsTxt(?callable $ask = null): string
    {
        $ask = $ask ?? fn($prompt) => readline($prompt);

        if (file_exists(public_path('robots.txt'))) {
            $response = strtolower($ask('A robots.txt file already exists. Do you want to delete it? (y/n): '));

            if ($response === 'y') {
                unlink(public_path('robots.txt'));
                return 'Existing robots.txt file deleted.';
            }

            return 'Leaving existing robots.txt file.';
        }

        return 'No existing robots.txt file found.';
    }
}
