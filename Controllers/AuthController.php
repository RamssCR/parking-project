<?php
namespace Controllers;
use Models\AuthModel;

spl_autoload_register(function($class){
   if (file_exists(str_replace('\\', '/', $class) . '.php')) {
       require_once str_replace('\\', '/', $class) . '.php';
   } 
});

require_once('models/validators/password_validation.php');

class AuthController {
    protected $email;
    protected $password;
    protected $role;

    public function __construct($email, $password, $role) {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function login() {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) return 'El correo ingresado es invalido';

        $validate_password = validatePassword($this->password);
        if (is_string($validate_password)) return $validate_password;

        $init_login = new AuthModel($this->email, $this->password, $this->role);
        $login = $init_login->login();
        if (!$login) return 'Usuario o contraseña incorrectas';
        return $login;
    }
}

?>