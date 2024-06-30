<?php

namespace io\kyperbelt\util;

class Templates
{
    /**
     * @param array<int,mixed> $model
     */
    public static function apply(string $name, array $model, bool $extractModel = true): ?string
    {
        $file = __DIR__. DIRECTORY_SEPARATOR.
            "..".DIRECTORY_SEPARATOR.
            "..".DIRECTORY_SEPARATOR.
            "..".DIRECTORY_SEPARATOR.
            "..".DIRECTORY_SEPARATOR.
            "template".DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
        ob_start();
        if (file_exists($file)) {
            if ($extractModel) {
                extract($model);
                require $file;
            } else {
                require $file;
            }
        } else {
            echo "template $name not found @ $file";
        }
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    /**
     * @param array<int,mixed> $model
     */
    public static function render(string $name, array $model, bool $extractModel = true): void
    {
        echo Templates::apply($name, $model, $extractModel);
    }
}
