<?php
    namespace Model;

    class Paquete extends ActiveRecord {
        protected static $tabla = 'paquete';
        protected static $columnasDB = ['id', 'nombre'];

        public $id;
        public $nombre;

        public function __construct($args = []) {
        }
    }