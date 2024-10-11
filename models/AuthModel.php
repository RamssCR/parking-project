<?php
namespace Models;
use Abstracts\Connection;

spl_autoload_register(function($class){
    if (file_exists('models/' . str_replace('\\', '/', $class) . '.php')) {
        require_once 'models/' . str_replace('\\', '/', $class) . '.php';
    } 
});

class AuthModel extends Connection {
    protected $email;
    protected $password;
    protected $role;
    private $connection;

    public function __construct($email, $password, $role) {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->connection = $this->makeConnection();
    }

    public function login() : array | bool {
        // validating user's existance in the database
        $query = mysqli_execute_query($this->connection, "SELECT * FROM usuarios WHERE email = ? AND tipo_usuario = ?", [$this->email, $this->role]);
        if (mysqli_num_rows($query) != 1) return false;

        $matchedUser = mysqli_fetch_assoc($query);
        if (!password_verify($this->password, $matchedUser['password'])) return false;

        $requestedUser = mysqli_execute_query($this->connection, 
            'SELECT admin.id, admin.nombre, admin.email, admin.telefono, admin.documento, usuarios.tipo_usuario, usuarios.pic_user FROM admin, usuarios WHERE admin.email = ? AND usuarios.email = ?
            UNION
            SELECT empleados.id, empleados.nombre, empleados.email, empleados.telefono, empleados.documento, usuarios.tipo_usuario, usuarios.pic_user FROM empleados, usuarios WHERE empleados.email = ? AND usuarios.email = ?',
            [$this->email, $this->email, $this->email, $this->email]
        );
        return mysqli_fetch_assoc($requestedUser);
    }
}

?>