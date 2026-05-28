<?php

class Controller
{
    protected function view(string $view, array $data = [])
    {
        extract($data);
        require __DIR__ . '/../Views/' . $view . '.php';
    }

    protected function redirect(string $path)
    {
        header("Location: $path");
        exit;
    }
}
