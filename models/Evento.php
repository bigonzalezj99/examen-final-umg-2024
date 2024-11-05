<?php
    namespace Model;

    class Evento extends ActiveRecord {
        protected static $tabla = 'evento';
        protected static $columnasDB = ['id', 'nombre', 'descripcion', 'id_categoria', 'id_dia', 'id_hora', 'id_ponente', 'disponible'];

        public $id;
        public $nombre;
        public $descripcion;
        public $id_categoria;
        public $id_dia;
        public $id_hora;
        public $id_ponente;
        public $disponible;

        // El constructor es para la entrada de datos.
        public function __construct($args = []) {
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->descripcion = $args['descripcion'] ?? '';
            $this->id_categoria = $args['id_categoria'] ?? '';
            $this->id_dia = $args['id_dia'] ?? '';
            $this->id_hora = $args['id_hora'] ?? '';
            $this->id_ponente = $args['id_ponente'] ?? '';
            $this->disponible = $args['disponible'] ?? '';
        }

        public function validar() {
            if (!$this->nombre) {
                self::$alertas['error'][] = '¡El nombre del evento es obligatorio!';
            } else if (!preg_match('/[a-zA-ZÑñáéíóúÁÉÍÓÚ]{3,60}/', $this->nombre)) {
                self::$alertas['error'][] = '¡Formato no válido para el nombre del evento!';
            }

            if (!$this->descripcion) {
                self::$alertas['error'][] = '¡La descripción del evento es obligatoria!';
            }

            if(!$this->id_categoria  || !filter_var($this->id_categoria, FILTER_VALIDATE_INT)) {
                self::$alertas['error'][] = '¡Por favor seleccione una categoría!';
            }

            if(!$this->id_dia  || !filter_var($this->id_dia, FILTER_VALIDATE_INT)) {
                self::$alertas['error'][] = '¡Por favor seleccione un día!';
            }

            if(!$this->id_hora  || !filter_var($this->id_hora, FILTER_VALIDATE_INT)) {
                self::$alertas['error'][] = '¡Por favor seleccione una hora!';
            }

            if(!$this->id_ponente  || !filter_var($this->id_ponente, FILTER_VALIDATE_INT)) {
                self::$alertas['error'][] = '¡Por favor seleccione un ponente!';
            }

            if(!$this->disponible  || !filter_var($this->disponible, FILTER_VALIDATE_INT)) {
                self::$alertas['error'][] = '¡Por favor seleccione una cantidad de lugares disponibles!';
            }

            return self::$alertas;
        }
    }