<?php
// app/Routes/routes.php

use App\Controllers\AuthController;
use App\Controllers\HomeController;


// --- Rotas de Teste ---
// $router->get('/teste-conexao', TestController::class, 'testConnection');

// --- Auth ---
$router->get('/login', AuthController::class, 'loginForm');
$router->post('/login', AuthController::class, 'authenticate'); // Atualizado para authenticate
$router->get('/logout', AuthController::class, 'logout');

// --- Painel ---
$router->get('/', HomeController::class, 'index');
$router->get('/home', HomeController::class, 'index');

