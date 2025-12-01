<?php

namespace App\Models;

use App\Core\ActiveRecord;

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
        $this->sincronizar($args);
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        return self::$alertas;
    }

    public static function getActiveMedicos()
    {
        $query = "SELECT * FROM medicos WHERE activo = 1 ORDER BY destacado DESC, fecha_registro DESC";
        return self::consultarSQL($query);
    }

    public static function search($term, $especialidad = null, $ciudad = null)
    {
        $sql = "SELECT * FROM medicos WHERE activo = 1";
        $params = [];

        if ($term) {
            $sql .= " AND (nombre LIKE :term OR apellido LIKE :term OR especialidad LIKE :term)";
            $params[':term'] = "%$term%";
        }
        if ($especialidad) {
            $sql .= " AND especialidad = :especialidad";
            $params[':especialidad'] = $especialidad;
        }
        if ($ciudad) {
            $sql .= " AND ciudad = :ciudad";
            $params[':ciudad'] = $ciudad;
        }

        // Custom query execution using Database class directly since ActiveRecord base might not handle complex binding in helper
        $db = \App\Core\Database::getInstance();
        $db->query($sql);
        foreach ($params as $key => $val) {
            $db->bind($key, $val);
        }

        $resultados = $db->resultSet();
        $array = [];
        foreach ($resultados as $registro) {
            $array[] = static::crearObjeto($registro);
        }
        return $array;
    }

    public function esPremiumActivo()
    {
        if ($this->plan !== 'premium')
            return false;
        if (!$this->fecha_vencimiento_plan)
            return false;
        return strtotime($this->fecha_vencimiento_plan) >= time();
    }
}
