<?php
    namespace Model;

    class Dia extends ActiveRecord {
        protected static $tabla = 'dia';
        protected static $columnasDB = ['id', 'nombre'];

        public $id;
        public $nombre;

        public function __construct($args = []) {
            
        }
    }