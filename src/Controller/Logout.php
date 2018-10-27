<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class Logout
{
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * Logs the user out from the session
     * 
     * @param Request  $request
     * @param Response $response 
     * @param array    $args
     * 
     * @return Response
     */
    public function __invoke(
        Request $request, 
        Response $response, 
        array $args
    ): Response {
        $this->container
            ->session
            ->destroy();

        return $response->withRedirect('/', 303);
    }
}