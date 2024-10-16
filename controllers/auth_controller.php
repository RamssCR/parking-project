<?php
require('models/auth_model.php');
require('models/validators/password_validation.php');

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