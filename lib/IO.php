<?php

namespace Mpyw\HatenaBookmarkCleaner;

class IO
{
    public static function input(string $prompt): string
    {
        echo $prompt;
        return rtrim(fgets(STDIN));
    }
}
