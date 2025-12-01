<?php

namespace Controller;

use MVC\Router;
use Model\Medico;
use Classes\ImageHandler;
use Model\GaleriaMedico;
use Model\InformacionPremium;

class MedicosController
{
    /**
     * Verificar sesión de administrador
     */
    private static function verificarSesion()
    {
        session_start();
        if (!isset($_SESSION['login']) || !isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
    }

    public static function index(Router $router)
    {
        self::verificarSesion();
        $medicos = Medico::all();
        $router->render('admin/medicos/index', [
            'medicos' => $medicos
        ]);
    }

    public static function crear(Router $router)
    {
        self::verificarSesion();
        $medico = new Medico;
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST received in crear");
            error_log("POST data: " . print_r($_POST, true));
            $medico = new Medico($_POST);
            $imageHandler = new ImageHandler();

            // Image Upload
            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                $resultado = $imageHandler->subirImagen($_FILES['foto_perfil']);
                if ($resultado['exito']) {
                    $medico->foto_perfil = $resultado['nombre'];
                } else {
                    $errores['error'][] = $resultado['mensaje'];
                }
            }

            $medico->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Validar
            $validacion = $medico->validar();
            if (!empty($validacion)) {
                $errores = array_merge($errores, $validacion);
            }

            if (empty($errores)) {
                try {
                    if ($medico->guardar()) {
                        header('Location: /admin/medicos?success=created');
                    } else {
                        $errores['error'][] = 'Error al guardar en la base de datos. Verifique los datos.';
                    }
                } catch (\Throwable $th) {
                    $errores['error'][] = 'Error: ' . $th->getMessage();
                }
            }
        }

        $router->render('admin/medicos/crear', [
            'medico' => $medico,
            'errores' => $errores
        ]);
    }

    public static function editar(Router $router)
    {
        self::verificarSesion();
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
                } else {
                    $errores['error'][] = $resultado['mensaje'];
                }
            }

            if (!empty($_POST['password'])) {
                $medico->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            // Validar
            $validacion = $medico->validar();
            if (!empty($validacion)) {
                $errores = array_merge($errores, $validacion);
            }

            if (empty($errores)) {
                try {
                    if ($medico->guardar()) {
                        header('Location: /admin/medicos?success=updated');
                    } else {
                        $errores['error'][] = 'Error al actualizar en la base de datos.';
                    }
                } catch (\Throwable $th) {
                    $errores['error'][] = 'Error: ' . $th->getMessage();
                }
            }
        }

        $router->render('admin/medicos/editar', [
            'medico' => $medico,
            'errores' => $errores
        ]);
    }

    /**
     * Activar/Desactivar médico
     */
    public static function toggleActivo()
    {
        self::verificarSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_medico'] ?? null;

            if (!$id) {
                header('Location: /admin/medicos?error=invalid_id');
                exit;
            }

            $medico = Medico::find($id);

            if (!$medico) {
                header('Location: /admin/medicos?error=not_found');
                exit;
            }

            // Toggle el estado activo
            $medico->activo = $medico->activo ? 0 : 1;
            $resultado = $medico->guardar();

            if ($resultado) {
                $estado = $medico->activo ? 'activated' : 'deactivated';
                header("Location: /admin/medicos?success=$estado");
            } else {
                header('Location: /admin/medicos?error=toggle_failed');
            }
            exit;
        }
    }

    /**
     * Eliminar médico y todos sus datos relacionados
     */
    public static function eliminar()
    {
        self::verificarSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_medico'] ?? null;

            if (!$id) {
                header('Location: /admin/medicos?error=invalid_id');
                exit;
            }

            $medico = Medico::find($id);

            if (!$medico) {
                header('Location: /admin/medicos?error=not_found');
                exit;
            }

            // 1. Eliminar foto de perfil del servidor
            if ($medico->foto_perfil) {
                $imageHandler = new ImageHandler('medicos/');
                $imageHandler->eliminarImagen($medico->foto_perfil);
            }

            // 2. Eliminar imágenes de galería (si tiene plan premium)
            $galerias = GaleriaMedico::where('id_medico', $id);
            if (is_array($galerias) && count($galerias) > 0) {
                $imageHandlerGaleria = new ImageHandler('galerias/');
                foreach ($galerias as $img) {
                    $imageHandlerGaleria->eliminarImagen($img->nombre_archivo);
                    $img->eliminar();
                }
            }

            // 3. Eliminar información premium
            $infoPremium = InformacionPremium::where('id_medico', $id);
            if (is_array($infoPremium) && count($infoPremium) > 0) {
                $infoPremium[0]->eliminar();
            }

            // 4. Eliminar médico de la base de datos
            $resultado = $medico->eliminar();

            if ($resultado) {
                header('Location: /admin/medicos?success=deleted');
            } else {
                header('Location: /admin/medicos?error=delete_failed');
            }
            exit;
        }
    }
}
