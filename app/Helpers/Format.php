<?php

namespace App\Helpers;

class Format
{
    public static function avatarLabel(string $name): string
    {
        $names = explode(' ', $name);

        if (count($names) > 1) {
            return strtoupper($names[0][0].$names[1][0]);
        }

        return strtoupper($names[0][0].$names[0][1]);
    }
}
