<?php
    namespace Model;

    class Ponente extends ActiveRecord {
        protected static $tabla = 'ponente';
        protected static $columnasDB = ['id', 'nombre', 'apellido', 'ciudad', 'pais', 'imagen', 'tags', 'redes'];

        public function __construct($args = []) {
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->apellido = $args['apellido'] ?? '';
            $this->ciudad = $args['ciudad'] ?? '';
            $this->pais = $args['pais'] ?? '';
            $this->imagen = $args['imagen'] ?? '';
            $this->tags = $args['tags'] ?? '';
            $this->redes = $args['redes'] ?? '';
        }

        public function validar() {
            if (!$this->nombre) {
                self::$alertas['error'][] = '¡El nombre del usuario es obligatorio!';
            } else if (!preg_match('/[a-zA-ZÑñáéíóúÁÉÍÓÚ]{3,60}/', $this->nombre)) {
                self::$alertas['error'][] = '¡Formato no válido para el nombre!';
            }

            if (!$this->apellido) {
                self::$alertas['error'][] = '¡El apellido del usuario es obligatorio!';
            } else if (!preg_match('/[a-zA-ZÑñáéíóúÁÉÍÓÚ]{3,60}/', $this->apellido)) {
                self::$alertas['error'][] = '¡Formato no válido para el apellido!';
            }

            if (!$this->ciudad) {
                self::$alertas['error'][] = '¡La ciudad del ponente es obligatoria!';
            } else if (!preg_match('/[a-zA-ZÑñáéíóúÁÉÍÓÚ]{3,60}/', $this->ciudad)) {
                self::$alertas['error'][] = '¡Formato no válido para la ciudad!';
            }

            if (!$this->pais) {
                self::$alertas['error'][] = '¡El país del ponente es obligatorio!';
            } else if (!preg_match('/[a-zA-ZÑñáéíóúÁÉÍÓÚ]{4,60}/', $this->pais)) {
                self::$alertas['error'][] = '¡Formato no válido para el país!';
            }

            if (!$this->imagen) {
                self::$alertas['error'][] = '¡La imagen del ponente es obligatoria!';
            }

            if (!$this->tags) {
                self::$alertas['error'][] = '¡Las áreas del ponente son obligatorias!';
            }

            return self::$alertas;
        }
    }