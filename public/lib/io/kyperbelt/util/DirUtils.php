<?php

namespace io\kyperbelt\util;

class DirUtils
{
    public static function getProjectRoot(): string
    {
        return __DIR__. DIRECTORY_SEPARATOR.
                "..".DIRECTORY_SEPARATOR.
                "..".DIRECTORY_SEPARATOR.
                "..".DIRECTORY_SEPARATOR.
                "..".DIRECTORY_SEPARATOR;
    }
}
