<?php

namespace Controller;

use MVC\Router;
use Model\Medico;
use Model\GaleriaMedico;
use Classes\ImageHandler;

class PanelMedicoController
{
    public static function login(Router $router)
    {
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Medico($_POST);
            $errores = $auth->validarLogin();

            if (empty($errores)) {
                $resultado = $auth->existeUsuario();
                if (!$resultado) {
                    $errores = Medico::getAlertas();
                } else {
                    $autenticado = $auth->comprobarPassword($resultado);
                    if ($autenticado) {
                        $auth->autenticar();
                    } else {
                        $errores = Medico::getAlertas();
                    }
                }
            }
        }

        $router->render('medico-panel/login', [
            'errores' => $errores
        ]);
    }

    public static function dashboard(Router $router)
    {
        session_start();
        if (!isset($_SESSION['login']) || !isset($_SESSION['medico_id'])) {
            header('Location: /medicos/login');
        }

        $router->render('medico-panel/dashboard', [
            'nombre' => $_SESSION['medico_nombre']
        ]);
    }

    public static function editarPerfil(Router $router)
    {
        session_start();
        if (!isset($_SESSION['login']) || !isset($_SESSION['medico_id'])) {
            header('Location: /medicos/login');
        }

        $id = $_SESSION['medico_id'];
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

            $errores = $medico->validar();

            if (empty($errores)) {
                $medico->guardar();
                $_SESSION['medico_nombre'] = $medico->nombre . ' ' . $medico->apellido;
                header('Location: /medicos/panel');
            }
        }

        $router->render('medico-panel/editar-perfil', [
            'medico' => $medico,
            'errores' => $errores
        ]);
    }

    public static function galeria(Router $router)
    {
        session_start();
        if (!isset($_SESSION['medico_plan']) || $_SESSION['medico_plan'] !== 'premium') {
            header('Location: /medicos/panel');
        }

        $id = $_SESSION['medico_id'];
        $imagenes = GaleriaMedico::where('id_medico', $id);

        $router->render('medico-panel/galeria', [
            'imagenes' => $imagenes
        ]);
    }

    public static function subirImagen()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imageHandler = new ImageHandler('galerias/');

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $resultado = $imageHandler->subirImagen($_FILES['imagen']);
                if ($resultado['exito']) {
                    $galeria = new GaleriaMedico([
                        'id_medico' => $_SESSION['medico_id'],
                        'nombre_archivo' => $resultado['nombre'],
                        'descripcion' => $_POST['descripcion'] ?? ''
                    ]);
                    $galeria->guardar();
                }
            }
            header('Location: /medicos/galeria');
        }
    }

    public static function eliminarImagen()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $imagen = GaleriaMedico::find($id);

            if ($imagen && $imagen->id_medico == $_SESSION['medico_id']) {
                $imageHandler = new ImageHandler('galerias/');
                $imageHandler->eliminarImagen($imagen->nombre_archivo);
                $imagen->eliminar();
            }
            header('Location: /medicos/galeria');
        }
    }

    public static function infoPremium(Router $router)
    {
        session_start();
        if (!isset($_SESSION['medico_plan']) || $_SESSION['medico_plan'] !== 'premium') {
            header('Location: /medicos/panel');
        }

        $id = $_SESSION['medico_id'];
        // Buscar si ya existe info
        $info = \Model\InformacionPremium::where('id_medico', $id);

        // Si devuelve un array de objetos, tomamos el primero, si no, creamos uno nuevo
        if (is_array($info)) {
            $info = $info[0] ?? new \Model\InformacionPremium(['id_medico' => $id]);
        } else {
            $info = new \Model\InformacionPremium(['id_medico' => $id]);
        }

        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $info->sincronizar($_POST);
            $errores = $info->validar();

            if (empty($errores)) {
                $info->guardar();
                // Recargar para mostrar datos actualizados
                header('Location: /medicos/info-premium');
            }
        }

        $router->render('medico-panel/info-premium', [
            'info' => $info,
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
