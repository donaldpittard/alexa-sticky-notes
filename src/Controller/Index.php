<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use SlimSession\Helper;

class Index
{
    public function __construct(PhpRenderer $renderer, Helper $session)
    {
        $this->isLoggedIn = false;
        $this->renderer   = $renderer;
        $this->session    = $session;

        if ($this->session->exists('access_token')) {
            $this->isLoggedIn = true;
        }
    }

    public function index(Request $request, Response $response, array $args)
    {
        if (!$this->isLoggedIn) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }

        return $this->renderer->render($response, 'index.phtml', $args);
    }
}
