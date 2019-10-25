<?php

namespace App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SlimSession\Helper;

class Authentication
{
    public function __construct(Helper $session)
    {
        $this->session = $session;
    }

    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next
    ) {
        $session = $this->session;
        if (!$session->exists('access_token')) {
            return $response->withStatus(302)
                ->withHeader('Location', '/login');
        }

        $next($request, $response);

        return $response;
    }
}