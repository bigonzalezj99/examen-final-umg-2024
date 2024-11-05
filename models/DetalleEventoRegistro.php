<?php
    namespace Model;

    class DetalleEventoRegistro extends ActiveRecord {
        protected static $tabla = 'detalle_evento_registro';
        protected static $columnasDB = ['id', 'id_evento', 'id_registro'];

        public $id;
        public $id_evento;
        public $id_registro;

        public function __construct($args = []) {
            $this->id = $args['id'] ?? null;
            $this->id_evento = $args['id_evento'] ?? '';
            $this->id_registro = $args['id_registro'] ?? '';
        }
    }