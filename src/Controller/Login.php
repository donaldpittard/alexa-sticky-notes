<?php

namespace App\Controller;

use Google_Client;
use PDO;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use SlimSession\Helper;

class Login
{
    public function __construct(
        PDO $db,
        Google_Client $google,
        PhpRenderer $renderer,
        Helper $session
    ) {
        $this->db       = $db;
        $this->google   = $google;
        $this->renderer = $renderer;
        $this->session  = $session;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * 
     * @return Response
     */
    public function index(Request $request, Response $response, array $args)
    {
        if ($this->session->exists('access_token')) {
            return $response->withStatus(302)
                ->withHeader('Location', '/');
        }

        $args['loginUrl']       = $this->google->createAuthUrl();
        $args['googleClientId'] = $this->google->getClientId();

        return $this->renderer
            ->render($response, 'login.phtml', $args);
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
        $googleClient = $this->google;
        $session      = $this->session;

        if ($session->exists('access_token')) {
            $googleClient->setAccessToken(
                $session->get('access_token')
            );
        } elseif (isset($code)) {
            $token = $googleClient->fetchAccessTokenWithAuthCode($code);
            $session->set('access_token', $token);
        } else {
            return $response->withStatus(302)
                ->withHeader('Location', '/login');
        }

        if ($googleClient->getAccessToken()) {
            $user   = $googleClient->verifyIdToken();
            $userId = $user['sub'];

            $user = $this->fetchUserByGoogleUserId($userId);

            if (!$user) {
                $this->createGoogleUser($userId);
                $this->session->set('user_id', $this->db->lastInsertId());
            } else {
                $this->session->set('user_id', $user->id);
            }

            return $response->withStatus(302)
                ->withHeader('Location', '/');
        }
    }

    private function createGoogleUser(string $userId)
    {
        $this->db
            ->prepare("INSERT INTO users (google_user_id) VALUES (?)")
            ->execute([$userId]);
    }

    private function fetchUserByGoogleUserId(string $googleUserId)
    {
        $statement = $this->db
            ->prepare("SELECT id FROM users WHERE google_user_id = ?");
        $statement->execute([$googleUserId]);

        return $statement->fetch(PDO::FETCH_OBJ);
    }
}
