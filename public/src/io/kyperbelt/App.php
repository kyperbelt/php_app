<?php

namespace io\kyperbelt;

use io\kyperbelt\net\Router;
use io\kyperbelt\util\Templates;

class App
{
    /**
     * Application Entrypoint.
     *
     */
    public function start(): void
    {
        echo "<br><pre>".var_export(getallheaders(), true)."</pre>";
        $router = new Router();

        // Add Route Mappings here.
        $router->get("/", function ($context) {
            Templates::render("layout/default", ["content" => "<h1>Application Root Maybe?!</h1>"]);
        });

        $router->get("/about", function ($context) {
            echo "<h1>Application About!</h1>";
        });

        $router->get("/users/{id}", function ($context) {
            $pathParams = $context['path_params'];
            $id = $pathParams['id'];
            echo "<h1>Application Users with id '$id'!</h1>";
        });

        // route to appropriate handler.
        $router->route();
    }
}
