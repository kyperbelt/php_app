<?php

namespace io\kyperbelt\net;

class Router
{
    // @var Path
    private $getRootPath;

    // @var Path
    private $postRootPath;

    // @var Path
    private $deleteRootPath;

    // @var Path
    private $putRootPath;


    public function __construct()
    {
        echo "router constructed <br>";
        echo "<br> SERVER:";
        echo "<pre>".var_export($_SERVER, true)."</pre>";
        echo "<br> REQUEST";
        echo "<pre>".var_export($_REQUEST, true)."</pre>";
        echo "<br>";

        $this->getRootPath = new Path();
        $this->postRootPath = new Path();
        $this->putRootPath = new Path();
        $this->deleteRootPath = new Path();
    }
    /**
     * Add a get handler for the given path.
     *
     * @param string $path
     * @param callable(): void $handler
     */
    public function get(string $path, callable $handler): void
    {
        $this->getRootPath->push($path, $handler);
    }

    /**
     * Add a post handler for the given path.
     *
     * @param string $path
     * @param callable(): void $handler
     */
    public function post(string $path, callable $handler): void
    {
        $this->postRootPath->push($path, $handler);
    }

    /**
     * Add a put handler for the given path.
     *
     * @param string $path
     * @param callable(): void $handler
     */
    public function put(string $path, callable $handler): void
    {
        $this->putRootPath->push($path, $handler);
    }

    /**
     * Add a delete handler for the given path.
     *
     * @param string $path
     * @param callable(): void $handler
     */
    public function delete(string $path, callable $handler): void
    {
        $this->deleteRootPath->push($path, $handler);
    }

    /**
     * Try and match the current URI to any of the specified route handlers.
     */
    public function route(): void
    {
        $pathString = $_SERVER['PATH_INFO'];
        $method = $_SERVER['REQUEST_METHOD'];
        // @var Path
        $path = null;
        switch ($method) {
            case 'GET':
                $path = $this->getRootPath->findMatch($pathString);
                break;
            case 'POST':
                $path = $this->getPostPath->findMatch($pathString);
                break;
            default:
                echo "Unsupported method@";
                break;
        }
        if ($path == null || $path->getHandler() == null) {
            http_response_code(404);
            echo "<h1>Page not Found</h1>";
            return;
        }

        $pathParts = Path::getPartsFromString($pathString);
        $context = [];
        $params = $path->getParams();
        $context['path_params'] = [];
        foreach ($params as $name => $index) {
            $context['path_params'][$name] = $pathParts[$index];
        }
        $path->getHandler()($context);
    }


}
