<?php

namespace Classes;

class ImageHandler
{
    private $carpetaImagenes;
    private $tiposPermitidos = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    private $pesoMaximo = 5242880; // 5MB

    public function __construct($carpeta = 'medicos/')
    {
        $this->carpetaImagenes = __DIR__ . '/../public/imagenes/' . $carpeta;
        if (!is_dir($this->carpetaImagenes)) {
            mkdir($this->carpetaImagenes, 0755, true);
        }
    }

    public function subirImagen($archivo)
    {
        $resultado = [
            'exito' => false,
            'mensaje' => '',
            'nombre' => ''
        ];

        if (!$this->validarImagen($archivo)) {
            $resultado['mensaje'] = 'Archivo no válido o excede el tamaño permitido.';
            return $resultado;
        }

        $nombreArchivo = $this->generarNombreUnico($archivo['name']);
        $rutaDestino = $this->carpetaImagenes . $nombreArchivo;

        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            $resultado['exito'] = true;
            $resultado['nombre'] = $nombreArchivo;
        } else {
            $resultado['mensaje'] = 'Error al guardar el archivo.';
        }

        return $resultado;
    }

    public function eliminarImagen($nombre)
    {
        $ruta = $this->carpetaImagenes . $nombre;
        if (file_exists($ruta)) {
            return unlink($ruta);
        }
        return false;
    }

    private function validarImagen($archivo)
    {
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        if ($archivo['size'] > $this->pesoMaximo) {
            return false;
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($archivo['tmp_name']);

        if (!in_array($mime, $this->tiposPermitidos)) {
            return false;
        }

        return true;
    }

    private function generarNombreUnico($nombreOriginal)
    {
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        return md5(uniqid(rand(), true)) . "." . $extension;
    }
}
