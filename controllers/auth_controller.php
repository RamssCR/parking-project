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
        $validate_password = validatePassword($this->password);
        if ($validate_password != true) return $validate_password;

        $init_login = new AuthModel($this->email, $this->password, $this->role);
        $login = $init_login->login();
        if (!$login) return 'Usuario o contraseña incorrectas';
        return $login;

        // todo --> admin and employee website
        // $login['tipo_usuario'] == 'Admin' ? header('location: admin') : header('location: employee');
    }
}

?>