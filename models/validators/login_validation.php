<?php
    function validateLogin() {
        if (!isset($_SESSION['user']) && !$_SESSION['isAuth']) {
            unset($_SESSION['user']);
            $_SESSION['isAuth'] = false;
            header('location: ../../index.php');
        }
    }

    function isLogged() {
        if (isset($_SESSION['user']) && $_SESSION['isAuth']) {
            $logged = $_SESSION['user'];

            $logged['tipo_usuario'] == 'Admin' ? header('location: view/admins/admin.php') : header('location: view/empleados/empleado.php');
        }
    }

    function logout() {
        unset($_SESSION['user']);
        $_SESSION['isAuth'] = false;
        header('location: ../../index.php');
    }
?>