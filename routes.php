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

$app->get('/api', function (Request $request, Response $response, array $args){
    $args['test'] = getenv('TEST_VALUE');
    return $this->renderer->render($response,'api.phtml', $args);
});

$app->get('/api/notes', function (Request $request, Response $response, array $args) {
    $this->logger->addInfo('Fetching notes');
    $data = [];

    $notes = $this->db->query('SELECT * FROM notes;');

    foreach ($notes as $note) {
        $data[] = $note;
    }
    
    return $response->withJson($data);
});

// $app->get('/api/note/new', function (Request $request, Response $response, array $args) {
//     $data = $request->getParsedBody();
//     $noteData = [];
//     $noteData['color'] = 
// });

$app->get('/privacy', function (Request $request, Response $response, array $args) {
    $this->renderer->render($response, 'privacy.phtml', $args);
});