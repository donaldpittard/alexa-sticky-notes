<?php

namespace App\Controller;

use \Google_Service_Oauth2;
use Slim\Http\Request;
use Slim\Http\Response;

class Login
{
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * 
     * @return Response
     */
    public function index(Request $request, Response $response, array $args) {
        $session = $this->container->session;
    
        if ($session->exists('access_token')) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }
    
        $google                 = $this->container->google;
        $args['loginUrl']       = $google->createAuthUrl();
        $args['googleClientId'] = $google->getClientId();
    
        return $this->container->renderer->render($response, 'login.phtml', $args);
    }
    
    /**
     * Sends backend request to authenticate user via google client.
     * 
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * 
     * @return Response
     */
    public function loginWithGoogle(Request $request, Response $response, array $args)
    {
        $code         = $request->getParam('code');
        $googleClient = $this->container->get('google');
        $session      = $this->container->get('session');

        if ($session->exists('access_token')) {
            $googleClient->setAccessToken($session->get('access_token'));
        } elseif (isset($code)) {
            $token = $googleClient->fetchAccessTokenWithAuthCode($code);
            $session->set('access_token', $token);
        } else {
            return $response->withStatus(302)->withHeader('Location', '/login');
        }

        if ($googleClient->getAccessToken()) {
            $user   = $googleClient->verifyIdToken();
            $userId = $user['sub'];
            $session->set('user_id', $userId);

            return $response->withStatus(302)->withHeader('Location', '/');
        }
    }
}