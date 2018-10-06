<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class Index
{
    public function __construct($container) {
        $this->container = $container;
    }

    public function index(Request $request, Response $response, array $args)
    {
        // Check to see if the session access token is set.
        $session = $this->container->get('session');

        if (!$session->exists('access_token')) {
            return $response->withStatus(302)->withHeader('Location', '/login');
        }
        
        return $this->container->renderer->render($response, 'index.phtml', $args);
    }
}