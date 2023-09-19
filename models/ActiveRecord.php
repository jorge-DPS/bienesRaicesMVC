<?php

namespace Model;

class ActiveRecord
{
    /* los statics no se instacion solo se llaman a los metodos; asi para evitar instanciar nuevamente */
    //Base de datos
    protected static $db;
    protected static $columnasDB = [];

    protected static $tabla = '';
    // errores o validaciones 
    protected static $errores = [];

    //Definir la conexion a al abase de datos

    public static function setDB($database)
    {
        self::$db = $database;
    }


    public function guardar()
    {
        if (!is_null($this->id)) {
            // Actualizar
            $this->actualizar();
        } else {
            // Creando el nuevo registro
            $this->crear();
        }
    }

    public function crear()
    {

        // sanitizar los datos
        $atributos = $this->sanitizaratributos();

        $keyStrings = join(', ', array_keys($atributos));
        $valueStrings = join("', '", array_values($atributos));
        // debuguear($valueStrings);

        /* Begin::insertar en la base de datos */
        $query = "INSERT INTO " . static::$tabla . " ($keyStrings)
        VALUES ( '$valueStrings' )";
        $resultado = self::$db->query($query);

        if ($resultado) {
            // redireccionar al usuario, una vez que el formulario se lleno correctamente
            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar()
    {
        $atributos = $this->sanitizaratributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $valores = join(', ', $valores);
        $consulta = " UPDATE " . static::$tabla . " SET $valores WHERE id = '" . self::$db->escape_string($this->id) . "' LIMIT 1 ";
        $resultado = self::$db->query($consulta);
        // debuguear($resultado);
        if ($resultado) {
            // redireccionar al usuario, una vez que el formulario se lleno correctamente
            header('Location: /admin?resultado=2');
        }
    }

    public function eliminar()
    {
        // Elminar registro
        $consulta = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($consulta);
        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }


    // Identificar y unir los atributos de la DB
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    public function sanitizaratributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // suboda de archivos

    public function setImagen($imagen)
    {
        // Eliminar Imagen Previa
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }
        //asignar el atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Eliminar el Archivo
    public function borrarImagen()
    {
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //validacion
    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    //Lista todas las Registros
    public static function all()
    {
        $consulta = "SELECT * FROM " . static::$tabla; //-> con el modificador de acceso static podemos asignar a la variable tabla desde otra clase
        $resultado = self::consultarSQL($consulta);
        return $resultado;
    }

    // obtener la cantidad de la propiedad
    public static function get($cantidad)
    {
        $consulta = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad; //-> con el modificador de acceso static podemos asignar a la variable tabla desde otra clase
        $resultado = self::consultarSQL($consulta);
        return $resultado;
    }

    // Buscar un registro por su id

    public static function find($id)
    {
        $consulta = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";

        $resultado = self::consultarSQL($consulta);

        return array_shift($resultado); //-> array_shift devuelve la primera posicion de un arreglo
    }

    public static function consultarSQL($consulta)
    {
        // consultar la db

        $resRegistros = self::$db->query($consulta);
        //iterar los resultados
        $arrayRegistros = [];
        while ($filaRegistro = $resRegistros->fetch_assoc()) {
            $arrayRegistros[] = static::crearObjeto($filaRegistro);
        }

        // debuguear($arrayRegistros);

        //liberar la memoria 
        $resRegistros->free(); // -> liberar la memoria; al terminar de hacer la consulta

        //retornar los resultados
        return $arrayRegistros;
    }

    protected static function crearObjeto($filaRegistro)
    {
        // convertir a un objeto cada fila que devuelve la base de datos
        $objeto = new static; // es como decir una nueva propiedad para un objeto
        foreach ($filaRegistro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincronizar el objeto en memoria con los cambios realizados por el usuario

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
