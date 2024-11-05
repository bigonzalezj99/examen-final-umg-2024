<?php
    namespace Model;

    class Hora extends ActiveRecord {
        protected static $tabla = 'hora';
        protected static $columnasDB = ['id', 'hora'];

        public $id;
        public $hora;
    }