<?php

require_once __DIR__ . '/AuthMiddleware.php';

class AdminMiddleware
{
    public static function handle()
    {
        AuthMiddleware::handle();

        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: /');
            exit;
        }
    }
}
