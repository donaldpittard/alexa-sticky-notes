<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/api/notes', function (Request $request, Response $response, array $args) {
    $data  = [];
    $notes = $this->db->query('SELECT * FROM notes ORDER BY id desc;');

    foreach ($notes as $note) {
        $data[] = [
            'id'    => $note['id'],
            'text'  => htmlspecialchars($note['text']),
            'color' => htmlspecialchars($note['color']),
        ];
    }

    return $response->withJson($data);
});

$app->post('/api/notes/create', function (Request $request, Response $response, array $args) {
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
});

$app->post('/api/notes/remove', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $id   = $data->id;

    if (!$id) {
        return;
    }

    $statement = $this->db->prepare("DELETE FROM notes WHERE id = ?");
    $statement->execute([$id]);

    return $response->withJson(['id' => $id], 200, JSON_UNESCAPED_UNICODE);
});

$app->get('/privacy', function (Request $request, Response $response, array $args) {
    $this->renderer->render($response, 'privacy.phtml', $args);
});