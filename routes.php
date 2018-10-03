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
    $notes = $this->db->query('SELECT * FROM notes;');

    foreach ($notes as $note) {
        $data[] = $note;
    }

    return $response->withJson($data);
});

$app->post('/api/notes/new', function (Request $request, Response $response, array $args) {
    $data = $request->getParsedBody();
    $this->logger->addInfo($data);
    
});

$app->get('/privacy', function (Request $request, Response $response, array $args) {
    $this->renderer->render($response, 'privacy.phtml', $args);
});