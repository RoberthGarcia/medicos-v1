<?php

namespace Controller;

use MVC\Router;
use Model\Admin;

class LoginController
{
    public static function login(Router $router)
    {
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);
            $errores = $auth->validar();

            if (empty($errores)) {
                $resultado = $auth->existeUsuario();

                if (!$resultado) {
                    $errores = Admin::getAlertas();
                } else {
                    $autenticado = $auth->comprobarPassword($resultado);

                    if ($autenticado) {
                        $auth->autenticar();
                    } else {
                        $errores = Admin::getAlertas();
                    }
                }
            } else {
                // Validation errors are already in $errores
            }
        }

        $router->render('admin/login', [
            'errores' => $errores
        ]);
    }

    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
}
