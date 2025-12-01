<?php

namespace Model;

use Classes\ActiveRecord;

class Admin extends ActiveRecord
{
    protected static $tabla = 'admin';
    protected static $columnasDB = ['id_admin', 'email', 'password_hash', 'nombre', 'fecha_creacion'];

    public $id_admin;
    public $email;
    public $password_hash;
    public $nombre;
    public $fecha_creacion;

    public function __construct($args = [])
    {
        $this->id_admin = $args['id_admin'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password_hash = $args['password_hash'] ?? $args['password'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? '';
    }

    public function validar()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }
        if (!$this->password_hash) { // In login form this holds the plain password
            self::$alertas['error'][] = 'El Password es obligatorio';
        }
        return self::$alertas;
    }

    public function existeUsuario()
    {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if (!$resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario no existe';
            return false;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado)
    {
        $usuario = $resultado->fetch_object();
        $autenticado = password_verify($this->password_hash, $usuario->password_hash);

        if (!$autenticado) {
            self::$alertas['error'][] = 'El Password es Incorrecto';
            return false;
        }

        // Assign values to object
        $this->id_admin = $usuario->id_admin;
        $this->nombre = $usuario->nombre;

        return true;
    }

    public function autenticar()
    {
        session_start();
        $_SESSION['usuario'] = $this->email;
        $_SESSION['admin_id'] = $this->id_admin;
        $_SESSION['admin_name'] = $this->nombre;
        $_SESSION['login'] = true;

        header('Location: /admin/dashboard');
    }
}
