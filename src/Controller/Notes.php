<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class Notes
{
    private $db;
    private $isLoggedIn;

    public function __construct($container)
    {
        $this->isLoggedIn = false;

        $session = $container->get('session');

        if ($session->exists('access_token')) {
            $this->isLoggedIn = true;
        }

        $this->session = $session;
        $this->db      = $container->get('db');
    }

    /**
     * Fetches all the notes for the current user.
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function fetchAll(Request $request, Response $response, array $args)
    {
        if (!$this->isLoggedIn) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }

        $data   = [];
        $userId = $this->session->get('user_id');

        $sql       = "SELECT * FROM notes WHERE user_id = ? ORDER BY id DESC;";
        $statement = $this->db->prepare($sql);
        $statement->execute([$userId]);
        $notes = $statement->fetchAll();

        foreach ($notes as $note) {
            $data[] = [
                'id'    => $note['id'],
                'text'  => htmlspecialchars($note['text']),
                'color' => htmlspecialchars($note['color']),
            ];
        }

        return $response->withJson($data);
    }

    /**
     * Creates a note for the current user.
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function create(Request $request, Response $response, array $args) {
        if (!$this->isLoggedIn) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }

        $data   = json_decode($request->getBody());
        $color  = $data->color;
        $text   = $data->text;
        $userId = $this->session->get('user_id');
    
        if (!$color || !$text) {
            return;
        }
    
        $statement = $this->db->prepare("INSERT INTO notes (text, color, user_id) VALUES (?, ?, ?)");
        $statement->execute([$text, $color, $userId]);
    
        $responseData = [];
        $responseData = [
            'id'    => $this->db->lastInsertId(),
            'text'  => htmlspecialchars($text),
            'color' => htmlspecialchars($color),
        ];
    
        return $response
            ->withJson($responseData, 200, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Deletes a note from the database
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function remove(Request $request, Response $response, array $args) {
        if (!$this->isLoggedIn) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }

        $data = json_decode($request->getBody());
        $id   = $data->id;
    
        if (!$id) {
            return;
        }
    
        $statement = $this->db->prepare("DELETE FROM notes WHERE id = ?");
        $statement->execute([$id]);
    
        return $response->withJson(['id' => $id], 200, JSON_UNESCAPED_UNICODE);
    }
}