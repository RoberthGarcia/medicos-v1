<?php

namespace Model;

use Classes\ActiveRecord;

class InformacionPremium extends ActiveRecord
{
    protected static $tabla = 'informacion_premium';
    protected static $primaryKey = 'id_info';
    protected static $columnasDB = [
        'id_info',
        'id_medico',
        'titulo_pagina',
        'descripcion_extendida',
        'video_url',
        'horarios_texto',
        'direccion_completa',
        'mapa_url',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'color_tema',
        'fecha_actualizacion'
    ];

    public $id_info;
    public $id_medico;
    public $titulo_pagina;
    public $descripcion_extendida;
    public $video_url;
    public $horarios_texto;
    public $direccion_completa;
    public $mapa_url;
    public $facebook;
    public $instagram;
    public $twitter;
    public $linkedin;
    public $color_tema;
    public $fecha_actualizacion;

    public function __construct($args = [])
    {
        $this->id_info = $args['id_info'] ?? null;
        $this->id_medico = $args['id_medico'] ?? null;
        $this->titulo_pagina = $args['titulo_pagina'] ?? '';
        $this->descripcion_extendida = $args['descripcion_extendida'] ?? '';
        $this->video_url = $args['video_url'] ?? '';
        $this->horarios_texto = $args['horarios_texto'] ?? '';
        $this->direccion_completa = $args['direccion_completa'] ?? '';
        $this->mapa_url = $args['mapa_url'] ?? '';
        $this->facebook = $args['facebook'] ?? '';
        $this->instagram = $args['instagram'] ?? '';
        $this->twitter = $args['twitter'] ?? '';
        $this->linkedin = $args['linkedin'] ?? '';
        $this->color_tema = $args['color_tema'] ?? '#0066CC';
        $this->fecha_actualizacion = $args['fecha_actualizacion'] ?? date('Y-m-d H:i:s');
    }

    public function validar()
    {
        // Validaciones opcionales según requerimientos
        return self::$alertas;
    }
}
