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

        $this->db = $container->get('db');
    }

    public function fetchAll(Request $request, Response $response, array $args)
    {
        if (!$this->isLoggedIn) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }

        $data  = [];
        $notes = $this->db->query('SELECT * FROM notes ORDER BY id DESC;');

        foreach ($notes as $note) {
            $data[] = [
                'id'    => $note['id'],
                'text'  => htmlspecialchars($note['text']),
                'color' => htmlspecialchars($note['color']),
            ];
        }

        return $response->withJson($data);
    }

    public function create(Request $request, Response $response, array $args) {
        if (!$this->isLoggedIn) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }

        $data  = json_decode($request->getBody());
        $color = $data->color;
        $text  = $data->text;
    
        if (!$color || !$text) {
            return;
        }
    
        $statement = $this->db->prepare("INSERT INTO notes (text, color) VALUES (?, ?)");
        $statement->execute([$text, $color]);
    
        $responseData = [];
        $responseData = [
            'id'    => $this->db->lastInsertId(),
            'text'  => htmlspecialchars($text),
            'color' => htmlspecialchars($color),
        ];
    
        return $response
            ->withJson($responseData, 200, JSON_UNESCAPED_UNICODE);
    }

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