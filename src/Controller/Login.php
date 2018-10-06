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

    public function loginWithGoogle(Request $request, Response $response, array $args)
    {
        $code         = $request->getParam('code');
        $googleClient = $this->container->get('google');
        $session      = $this->container->get('session');

        if ($session->exists('acces_token')) {
            $googleClient->setAccessToken($session->get('access_token'));
        } elseif (isset($code)) {
            $token = $googleClient->fetchAccessTokenWithAuthCode($code);
            $session->set('access_token', $token);
        } else {
            return $response->withStatus(302)->withHead('Location', '/login');
        }

        $oAuth = new Google_Service_Oauth2($googleClient);
        $userData = $oAuth->userinfo_v2_me->get();


        $session->set('id', $userData['id']);
        $session->set('name', $userData['givenName']);

        return $response->withStatus(302)->withHeader('Location', '/');
    }
}