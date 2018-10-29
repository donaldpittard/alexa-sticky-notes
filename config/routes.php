<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', 'index:index');

$app->get('/login', 'login:index');

$app->get('/login/google', 'login:loginWithGoogle');

$app->get('/logout', 'logout');

$app->get('/api/notes', 'notes:fetchAll');

$app->post('/api/notes/create', 'notes:create');

$app->post('/api/notes/remove', 'notes:remove');
