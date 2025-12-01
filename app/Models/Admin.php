<?php

namespace App\Models;

use App\Core\ActiveRecord;

class Admin extends ActiveRecord
{
    protected static $tabla = 'admin';
    protected static $primaryKey = 'id_admin';
    protected static $columnasDB = ['id_admin', 'email', 'password_hash', 'nombre', 'fecha_creacion'];

    public $id_admin;
    public $email;
    public $password_hash;
    public $nombre;
    public $fecha_creacion;

    public function __construct($args = [])
    {
        $this->sincronizar($args);
    }

    public static function login($email, $password)
    {
        // Use 'where' which returns an array, take the first one
        $resultado = self::where('email', $email);
        $usuario = array_shift($resultado);

        if (!$usuario) {
            return false;
        }

        if (password_verify($password, $usuario->password_hash)) {
            return $usuario;
        } else {
            return false;
        }
    }
}
