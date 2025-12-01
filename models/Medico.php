<?php

namespace Model;

use Classes\ActiveRecord;

class Medico extends ActiveRecord
{
    protected static $tabla = 'medicos';
    protected static $primaryKey = 'id_medico';
    protected static $columnasDB = [
        'id_medico',
        'nombre',
        'apellido',
        'email',
        'password_hash',
        'telefono',
        'whatsapp',
        'especialidad',
        'cedula_profesional',
        'servicios',
        'biografia',
        'ciudad',
        'estado',
        'foto_perfil',
        'plan',
        'fecha_vencimiento_plan',
        'activo',
        'destacado',
        'fecha_registro',
        'ultimo_acceso'
    ];

    public $id_medico;
    public $nombre;
    public $apellido;
    public $email;
    public $password_hash;
    public $telefono;
    public $whatsapp;
    public $especialidad;
    public $cedula_profesional;
    public $servicios;
    public $biografia;
    public $ciudad;
    public $estado;
    public $foto_perfil;
    public $plan;
    public $fecha_vencimiento_plan;
    public $activo;
    public $destacado;
    public $fecha_registro;
    public $ultimo_acceso;

    public function __construct($args = [])
    {
        $this->id_medico = $args['id_medico'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password_hash = $args['password_hash'] ?? $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->whatsapp = $args['whatsapp'] ?? '';
        $this->especialidad = $args['especialidad'] ?? '';
        $this->cedula_profesional = $args['cedula_profesional'] ?? '';
        $this->servicios = $args['servicios'] ?? '';
        $this->biografia = $args['biografia'] ?? '';
        $this->ciudad = $args['ciudad'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->foto_perfil = $args['foto_perfil'] ?? '';
        $this->plan = $args['plan'] ?? 'basico';
        $this->fecha_vencimiento_plan = !empty($args['fecha_vencimiento_plan']) ? $args['fecha_vencimiento_plan'] : null;
        $this->activo = $args['activo'] ?? 1;
        $this->destacado = $args['destacado'] ?? 0;
    }

    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if (!$this->password_hash) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
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
        } else {
            // Assign ID and other properties from DB to this object for session use
            $this->id_medico = $usuario->id_medico;
            $this->nombre = $usuario->nombre;
            $this->apellido = $usuario->apellido;
            $this->plan = $usuario->plan;
        }
        return $autenticado;
    }

    public function autenticar()
    {
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['medico_id'] = $this->id_medico;
        $_SESSION['medico_nombre'] = $this->nombre . " " . $this->apellido;
        $_SESSION['medico_plan'] = $this->plan;

        header('Location: /medicos/panel');
    }

    public function validar()
    {
        if (!$this->nombre)
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        if (!$this->apellido)
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        if (!$this->email)
            self::$alertas['error'][] = 'El Email es Obligatorio';
        return self::$alertas;
    }

    // Override guardar to handle ID mapping if needed, but ActiveRecord uses 'id' usually.
    // Our table uses 'id_medico'. We need to fix ActiveRecord to support custom PK or map it.
    public static function getActiveMedicos()
    {
        $query = "SELECT * FROM medicos WHERE activo = 1 ORDER BY destacado DESC, fecha_registro DESC";
        return self::consultarSQL($query);
    }

    public static function search($term)
    {
        $term = self::$db->escape_string($term);
        $query = "SELECT * FROM medicos WHERE activo = 1 AND (nombre LIKE '%$term%' OR apellido LIKE '%$term%' OR especialidad LIKE '%$term%')";
        return self::consultarSQL($query);
    }
}
