<?php
    namespace Backend\models;

    class Usuario {
        public $id;
        public $nombre;
        public $apaterno;
        public $amaterno;
        public $direccion;
        public $telefono;
        public $ciudad;
        public $pais;
        public $usuario;
        public $password;
        public $rol;

        public function __construct($id = null, $nombre, $apaterno, $amaterno, $direccion, $telefono, $ciudad, $pais, $usuario, $password, $rol) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apaterno = $apaterno;
            $this->amaterno = $amaterno;
            $this->direccion = $direccion;
            $this->telefono = $telefono;
            $this->ciudad = $ciudad;
            $this->pais = $pais;
            $this->usuario = $usuario;
            $this->password = $password;
            $this->rol = $rol;
        }
        
            
        }
    