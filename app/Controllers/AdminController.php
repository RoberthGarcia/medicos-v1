<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Admin;
use App\Models\Medico;
use App\Core\ImageHandler;

class AdminController extends Controller
{

    public function index()
    {
        $this->checkSession();
        $data = [
            'title' => 'Dashboard Administrador'
        ];
        $this->view('admin/dashboard', $data);
    }

    public function medicos()
    {
        $this->checkSession();
        $medicos = Medico::all();
        $data = [
            'title' => 'Gestionar Médicos',
            'medicos' => $medicos
        ];
        $this->view('admin/medicos/index', $data);
    }

    public function crear()
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $medico = new Medico($_POST);
            $imageHandler = new ImageHandler();

            // Handle Image Upload
            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                $resultado = $imageHandler->subirImagen($_FILES['foto_perfil']);
                if ($resultado['exito']) {
                    $medico->foto_perfil = $resultado['nombre'];
                } else {
                    // Handle error
                    $data = ['error' => $resultado['mensaje'], 'medico' => $medico];
                    $this->view('admin/medicos/crear', $data);
                    return;
                }
            } else {
                $data = ['error' => 'La foto de perfil es obligatoria', 'medico' => $medico];
                $this->view('admin/medicos/crear', $data);
                return;
            }

            // Password Hash
            $medico->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Defaults
            $medico->activo = isset($_POST['activo']) ? 1 : 0;
            $medico->destacado = isset($_POST['destacado']) ? 1 : 0;

            if ($medico->guardar()) {
                $this->redirect('admin/medicos');
            } else {
                // Show errors
                $data = ['medico' => $medico, 'errores' => Medico::getAlertas()];
                $this->view('admin/medicos/crear', $data);
            }

        } else {
            $medico = new Medico();
            $this->view('admin/medicos/crear', ['medico' => $medico]);
        }
    }

    public function editar($id)
    {
        $this->checkSession();
        $medico = Medico::find($id);

        if (!$medico) {
            $this->redirect('admin/medicos');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $medico->sincronizar($_POST);

            // Handle Image Upload if new one provided
            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                $imageHandler = new ImageHandler();
                $resultado = $imageHandler->subirImagen($_FILES['foto_perfil']);
                if ($resultado['exito']) {
                    // Delete old image if exists
                    if ($medico->foto_perfil) {
                        $imageHandler->eliminarImagen($medico->foto_perfil);
                    }
                    $medico->foto_perfil = $resultado['nombre'];
                }
            }

            // Update password only if provided
            if (!empty($_POST['password'])) {
                $medico->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $medico->activo = isset($_POST['activo']) ? 1 : 0;
            $medico->destacado = isset($_POST['destacado']) ? 1 : 0;

            if ($medico->guardar()) {
                $this->redirect('admin/medicos');
            } else {
                $data = ['medico' => $medico, 'errores' => Medico::getAlertas()];
                $this->view('admin/medicos/editar', $data);
            }
        } else {
            $this->view('admin/medicos/editar', ['medico' => $medico]);
        }
    }

    public function eliminar()
    {
        $this->checkSession();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_medico'];
            $medico = Medico::find($id);
            if ($medico) {
                // Delete image
                if ($medico->foto_perfil) {
                    $imageHandler = new ImageHandler();
                    $imageHandler->eliminarImagen($medico->foto_perfil);
                }
                $medico->eliminar();
            }
            $this->redirect('admin/medicos');
        }
    }

    public function toggle()
    {
        $this->checkSession();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_medico'];
            $medico = Medico::find($id);
            if ($medico) {
                $medico->activo = !$medico->activo;
                $medico->guardar();
            }
            $this->redirect('admin/medicos');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = Admin::login($email, $password);

            if ($user) {
                $_SESSION['admin_id'] = $user->id_admin;
                $_SESSION['admin_email'] = $user->email;
                $_SESSION['admin_name'] = $user->nombre;
                $this->redirect('admin/dashboard');
            } else {
                $data = [
                    'email' => $email,
                    'password_err' => 'Credenciales incorrectas'
                ];
                $this->view('admin/login', $data);
            }
        } else {
            if (isset($_SESSION['admin_id'])) {
                $this->redirect('admin/dashboard');
            }
            $this->view('admin/login');
        }
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_name']);
        session_destroy();
        $this->redirect('admin');
    }

    private function checkSession()
    {
        if (!isset($_SESSION['admin_id'])) {
            $this->redirect('admin');
        }
    }
}
