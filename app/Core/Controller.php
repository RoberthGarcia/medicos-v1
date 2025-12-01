<?php

namespace App\Core;

class Controller
{
    // Load model
    public function model($model)
    {
        // Require model file
        $modelClass = 'App\\Models\\' . $model;

        // Instantiate model
        return new $modelClass();
    }

    // Load view
    public function view($view, $data = [])
    {
        // Check for view file
        if (file_exists('../views/' . $view . '.php')) {
            require_once '../views/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }

    // Redirect helper
    public function redirect($url)
    {
        header('location: ' . URL_ROOT . '/' . $url);
        exit;
    }
}
