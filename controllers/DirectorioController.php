<?php

namespace Controller;

use MVC\Router;
use Model\Medico;

class DirectorioController
{
    public static function index(Router $router)
    {
        $medicos = Medico::getActiveMedicos();
        $router->render('directorio/index', [
            'medicos' => $medicos
        ]);
    }

    public static function buscar(Router $router)
    {
        $term = $_GET['q'] ?? '';
        $medicos = Medico::search($term);
        $router->render('directorio/index', [
            'medicos' => $medicos,
            'term' => $term
        ]);
    }

    public static function perfil($id)
    {
        $medico = Medico::find($id);

        if (!$medico) {
            header('Location: /');
        }

        $view = $medico->plan === 'premium' ? 'directorio/perfil-premium' : 'directorio/perfil-basico';

        $router = new Router();
        $router->render($view, [
            'medico' => $medico
        ]);
    }
}
