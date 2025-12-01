<?php

namespace Model;

use Classes\ActiveRecord;

class GaleriaMedico extends ActiveRecord
{
    protected static $tabla = 'galeria_medicos';
    protected static $primaryKey = 'id_galeria';
    protected static $columnasDB = ['id_galeria', 'id_medico', 'nombre_archivo', 'descripcion', 'orden', 'activo', 'fecha_subida'];

    public $id_galeria;
    public $id_medico;
    public $nombre_archivo;
    public $descripcion;
    public $orden;
    public $activo;
    public $fecha_subida;

    public function __construct($args = [])
    {
        $this->id_galeria = $args['id_galeria'] ?? null;
        $this->id_medico = $args['id_medico'] ?? null;
        $this->nombre_archivo = $args['nombre_archivo'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->orden = $args['orden'] ?? 0;
        $this->activo = $args['activo'] ?? 1;
        $this->fecha_subida = $args['fecha_subida'] ?? date('Y-m-d H:i:s');
    }

    public function validar()
    {
        if (!$this->nombre_archivo) {
            self::$alertas['error'][] = 'La imagen es obligatoria';
        }
        return self::$alertas;
    }
}
