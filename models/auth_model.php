<?php
class AuthModel {
    protected $email;
    protected $password;
    protected $role;
    private $connection;

    public function __construct($email, $password, $role) {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->connection = mysqli_connect('localhost', 'root', '', 'dbpenta');
    }

    public function login() : array | bool {
        // validating user's existance in the database
        $query = mysqli_query($this->connection, "SELECT * FROM usuarios WHERE email = '$this->email' AND tipo_usuario = '$this->role'");
        if (mysqli_num_rows($query) != 1) return false;

        $matchedUser = mysqli_fetch_assoc($query);
        if (!password_verify($this->password, $matchedUser['password'])) return false;

        return $matchedUser;
    }
}

?>