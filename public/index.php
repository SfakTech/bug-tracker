<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../app/Core/Router.php';

$router = new Router();

/* AUTH */
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

/* HOME */
$router->get('/', 'HomeController@index');

/* TICKETS */
$router->get('/tickets', 'TicketController@index');
$router->get('/tickets/create', 'TicketController@create');
$router->post('/tickets', 'TicketController@store');
$router->get('/tickets/{id}/edit', 'TicketController@edit');
$router->post('/tickets/{id}/update', 'TicketController@update');
$router->post('/tickets/{id}/delete', 'TicketController@destroy');

$router->dispatch();
