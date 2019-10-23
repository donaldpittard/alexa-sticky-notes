<?php

namespace App\Controller;

use PDO;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SlimSession\Helper;

class Notes
{
    private $db;

    public function __construct(PDO $db, Helper $session)
    {
        $this->db      = $db;
        $this->session = $session;
    }

    /**
     * Fetches all the notes for the current user.
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array    $args
     * @return ResponseInterface
     */
    public function fetchAll(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $data      = [];
        $userId    = $this->session->get('user_id');
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
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param array    $args
     * @return ResponseInterface
     */
    public function create(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $data   = json_decode($request->getBody());
        $color  = $data->color;
        $text   = $data->text;
        $userId = $this->session->get('user_id');

        if (!$color || !$text) {
            return $response->withStatus(500);
        }

        $statement = $this->db
            ->prepare("INSERT INTO notes (text, color, user_id) VALUES (?, ?, ?)");
        $statement->execute([$text, $color, $userId]);

        $responseData = [];
        $responseData = [
            'id'    => $this->db->lastInsertId(),
            'text'  => htmlspecialchars($text),
            'color' => htmlspecialchars($color),
        ];

        return $response
            ->withJson(
                $responseData,
                200,
                JSON_UNESCAPED_UNICODE
            );
    }

    /**
     * Deletes a note from the database
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array    $args
     * @return ResponseInterface
     */
    public function remove(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ) {
        $data = json_decode($request->getBody());
        $id   = $data->id;

        if (!$id) {
            return $response->withStatus(500);
        }

        $statement = $this->db
            ->prepare("DELETE FROM notes WHERE id = ?");

        $statement->execute([$id]);

        return $response->withJson([
            'id' => $id
        ], 200, JSON_UNESCAPED_UNICODE);
    }
}
