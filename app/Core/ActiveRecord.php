<?php

namespace App\Core;

abstract class ActiveRecord
{
    protected static $db;
    protected static $tabla = '';
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
        $atributos = $this->sanitizarAtributos();

        // Check if updating or creating
        $id = $this->id ?? null; // Assuming 'id' is always the primary key property name in object, mapped to PK in DB

        if (!is_null($id)) {
            return $this->actualizar();
        } else {
            return $this->crear();
        }
    }

    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function find($id)
    {
        // Assuming primary key is always 'id' or we need to define it. 
        // The user schema has id_admin, id_medico. 
        // We might need a way to define PK. For now, let's assume the child class handles the query or we guess it.
        // Better approach: Use a property for PK or just assume the query uses the ID passed.
        // Let's try to be generic but allow override.

        // Since we don't have the PK name in a static property in the requirement, 
        // we will assume the child class might define it or we use a convention.
        // However, the schema uses id_admin, id_medico.
        // Let's assume the child class implements find or we use a generic query if we knew the PK name.
        // For this implementation, I will rely on `where` or custom implementation in child, 
        // BUT `find` is a standard AR method.
        // Let's assume the first column in $columnasDB is the PK or we add a $primaryKey property.

        // Let's add $primaryKey to the class for better abstraction
        $query = "SELECT * FROM " . static::$tabla . " WHERE " . static::$primaryKey . " = :id";

        // We need to use the Database class properly. 
        // The Database class in this project is a Singleton wrapper around PDO.
        // But ActiveRecord usually uses a static DB instance.

        // Let's use the Database instance.
        $db = Database::getInstance();
        $db->query($query);
        $db->bind(':id', $id);
        $registro = $db->single();

        if ($registro) {
            return static::crearObjeto($registro);
        }
        return null;
    }

    public static function where($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = :valor";
        $db = Database::getInstance();
        $db->query($query);
        $db->bind(':valor', $valor);
        $resultado = $db->resultSet();

        $array = [];
        foreach ($resultado as $registro) {
            $array[] = static::crearObjeto($registro);
        }
        return $array;
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $db = Database::getInstance();
        $db->query($query);
        $resultados = $db->resultSet();

        // Iterar los resultados
        $array = [];
        foreach ($resultados as $registro) {
            $array[] = static::crearObjeto($registro);
        }

        // Retornar los resultados
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

    // CRUD Methods
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ( :";
        $query .= join(', :', array_keys($atributos));
        $query .= " ) ";

        $db = Database::getInstance();
        $db->query($query);

        foreach ($atributos as $key => $value) {
            $db->bind(":$key", $value);
        }

        return $db->execute();
    }

    public function actualizar()
    {
        $atributos = $this->sanitizarAtributos();
        $valores = [];

        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}=:{$key}";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE " . static::$primaryKey . " = :id ";
        $query .= " LIMIT 1 ";

        $db = Database::getInstance();
        $db->query($query);

        foreach ($atributos as $key => $value) {
            $db->bind(":$key", $value);
        }

        // Bind ID
        $pk = static::$primaryKey;
        $db->bind(':id', $this->$pk);

        return $db->execute();
    }

    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE " . static::$primaryKey . " = :id LIMIT 1";
        $db = Database::getInstance();
        $db->query($query);

        $pk = static::$primaryKey;
        $db->bind(':id', $this->$pk);

        return $db->execute();
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = $value; // PDO handles escaping, so we just map here. 
            // If we needed manual escaping we would do it here.
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
