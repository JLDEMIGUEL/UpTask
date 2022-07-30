<?php


namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla='usuarios';
    protected static $columnasDB=['id','nombre','email','password','token','confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $token;
    public $confirmado;

    public function __construct($args=[])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 1;
    }

    public function validarLogin($email,$password){

        if(!$this->email){
            self::$alertas['error'][]='El email del usuario es obligatorio';
        }
        else if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][]='El email no es valido';
        }
        if(!$this->password){
            self::$alertas['error'][]='El password es obligatorio';
        }

        return self::$alertas;

    }

    public function validarCuentasNuevas(){
        if(!$this->nombre){
            self::$alertas['error'][]='El nombre del usuario es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][]='El email del usuario es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][]='El password es obligatorio';
        }
        if(strlen($this->password)<6){
            self::$alertas['error'][]='El password debe tener al menos 6 caracteres';
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][]='Los passwords son diferentes';
        }

        return self::$alertas;
    }


    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]='El password es obligatorio';
        }
        if(strlen($this->password)<6){
            self::$alertas['error'][]='El password debe tener al menos 6 caracteres';
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][]='Los passwords son diferentes';
        }
        return self::$alertas;
    }

    public function validarNuevoPassword(){
        if(!$this->password_actual){
            self::$alertas['error'][]='El password actual es obligatorio';
        }
        if(!$this->password_nuevo){
            self::$alertas['error'][]='El password nuevo es obligatorio';
        }
        if(strlen($this->password_nuevo)<6){
            self::$alertas['error'][]='El password debe tener al menos 6 caracteres';
        }
        // if($this->password_actual !== $this->password2){
        //     self::$alertas['error'][]='Los passwords son diferentes';
        // }
        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][]='El email del usuario es obligatorio';
        }
        else if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][]='El email no es valido';
        }
        return self::$alertas;
    }

    public function validarPerfil(){
        if(!$this->nombre){
            self::$alertas['error'][]='El nombre del usuario es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][]='El email del usuario es obligatorio';
        }
        else if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][]='El email no es valido';
        }
        return self::$alertas;
    }

    public function comprobarPassword(){
        return password_verify($this->password_actual,$this->password);
    }

    public function hashPassword(){
        $this->password=password_hash($this->password,PASSWORD_BCRYPT);
    }

    public function generarToken(){
        $this->token=uniqid();
    }


}