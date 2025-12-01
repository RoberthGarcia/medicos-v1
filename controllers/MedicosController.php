<?php

namespace Controller;

use MVC\Router;
use Model\Medico;
use Classes\ImageHandler;

class MedicosController
{
    public static function index(Router $router)
    {
        $medicos = Medico::all();
        $router->render('admin/medicos/index', [
            'medicos' => $medicos
        ]);
    }

    public static function crear(Router $router)
    {
        $medico = new Medico;
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $medico = new Medico($_POST);
            $imageHandler = new ImageHandler();

            // Image Upload
            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                $resultado = $imageHandler->subirImagen($_FILES['foto_perfil']);
                if ($resultado['exito']) {
                    $medico->foto_perfil = $resultado['nombre'];
                }
            }

            $medico->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $errores = $medico->validar();

            if (empty($errores)) {
                $medico->guardar();
                header('Location: /admin/medicos');
            }
        }

        $router->render('admin/medicos/crear', [
            'medico' => $medico,
            'errores' => $errores
        ]);
    }

    public static function editar(Router $router)
    {
        $id = validarORedireccionar('/admin/medicos');
        $medico = Medico::find($id);
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $medico->sincronizar($_POST);
            $imageHandler = new ImageHandler();

            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                $resultado = $imageHandler->subirImagen($_FILES['foto_perfil']);
                if ($resultado['exito']) {
                    $medico->foto_perfil = $resultado['nombre'];
                }
            }

            if (!empty($_POST['password'])) {
                $medico->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $errores = $medico->validar();

            if (empty($errores)) {
                $medico->guardar();
                header('Location: /admin/medicos');
            }
        }

        $router->render('admin/medicos/editar', [
            'medico' => $medico,
            'errores' => $errores
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_medico']; // Ensure view sends this
            $medico = Medico::find($id);
            $medico->eliminar();
            header('Location: /admin/medicos');
        }
    }
}
