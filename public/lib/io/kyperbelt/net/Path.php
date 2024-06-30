<?php

namespace io\kyperbelt\net;

use Exception;

class Path
{
    private const PARAM_REGEX = "/^\{([a-zA-Z_][a-zA-Z0-9_]*)\}$/";
    private $children = [];
    private $handler = null;
    private $params = [];

    public function __construct()
    {
    }

    public function getHandler(): ?callable
    {
        return $this->handler;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param callable(): void $handler
     *
     * @return bool true if path successfully added false if conflict found.
     */
    public function push(?string $path, callable $handler): bool
    {
        $current = $this;
        $pathParts = self::getPartsFromString($path);

        $params = [];
        // navigate the tree of this path until you find
        // where the given path ends and add the handler to that path.
        foreach ($pathParts as $index => $part) {

            $item = $part;
            $matches = [];
            // paramters are turned into wildcards for the path.
            if (preg_match(self::PARAM_REGEX, $item, $matches)) {
                $item = "*";
                if (isset($params[$matches[1]])) {
                    throw new Exception("Duplicate param names found in Path'$path'");
                }
                $params[$matches[1]] = $index;
            } elseif (strpos($item, '{') !== false || strpos($item, "}") !== false) {
                throw new Exception("Invalid Parameter syntax '$item' in Path: '$path'");
            }

            if (!isset($current->children[$item])) {
                $current->children[$item] = new Path();
            }
            $current = $current->children[$item];
        }

        // if path already has a handler then this is an error.
        if ($current->handler != null) {
            return false;
        }
        $current->handler = $handler;
        $current->params = $params;
        return true;
    }

    public function findMatch(?string $path): ?Path
    {
        $pathParts = self::getPartsFromString($path);
        $current = &$this;

        // navigate the tree of this path until you find
        // where the given path ends and add the handler to that path.
        foreach ($pathParts as $index => $part) {

            $item = $part;
            if (!isset($current->children[$item])) {
                $item = "*";
                if (!isset($current->children[$item])) {
                    return null;
                }
            }
            $current = $current->children[$item];
        }
        return $current;
    }

    // remove all '/' from the path and return all individual pieces.
    public static function getPartsFromString(?string $path): array
    {
        return array_values(array_filter(explode("/", $path ?? "/"), function ($value) {
            return $value !== '';
        }));
    }


}
