<?php

namespace Classes;

class ActiveRecord
{
    protected static $db;
    protected static $tabla = '';
    protected static $primaryKey = 'id';
    protected static $columnasDB = [];
    protected static $alertas = [];

    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }

    public static function getAlertas()
    {
        return static::$alertas;
    }

    public function validar()
    {
        static::$alertas = [];
        return static::$alertas;
    }

    public function guardar()
    {
        $resultado = '';
        if (!is_null($this->{static::$primaryKey})) {
            $resultado = $this->actualizar();
        } else {
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE " . static::$primaryKey . " = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function where($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function consultarSQL($query)
    {
        $resultado = self::$db->query($query);
        $array = [];
        if ($resultado) {
            while ($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObjeto($registro);
            }
            $resultado->free();
        }
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    public function crear()
    {
        $atributos = $this->sanitizarAtributos();

        $columnas = join(', ', array_keys($atributos));

        $valores = [];
        foreach ($atributos as $value) {
            if ($value === null) {
                $valores[] = "NULL";
            } else {
                $valores[] = "'" . $value . "'";
            }
        }
        $valores_str = join(', ', $valores);

        $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ($valores_str)";

        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->{static::$primaryKey} = self::$db->insert_id;
        }

        return $resultado;
    }

    public function actualizar()
    {
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach ($atributos as $key => $value) {
            if ($value === null) {
                $valores[] = "{$key}=NULL";
            } else {
                $valores[] = "{$key}='{$value}'";
            }
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);

        $id = $this->{static::$primaryKey};
        $idSanitizado = $id !== null ? self::$db->escape_string($id) : 'NULL';

        $query .= " WHERE " . static::$primaryKey . " = '" . $idSanitizado . "' ";
        $query .= " LIMIT 1 ";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function eliminar()
    {
        $id = $this->{static::$primaryKey};
        $idSanitizado = $id !== null ? self::$db->escape_string($id) : 'NULL';

        $query = "DELETE FROM " . static::$tabla . " WHERE " . static::$primaryKey . " = " . $idSanitizado . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            if ($value === null) {
                $sanitizado[$key] = null;
            } else {
                $sanitizado[$key] = self::$db->escape_string($value);
            }
        }
        return $sanitizado;
    }

    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === static::$primaryKey)
                continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
}
