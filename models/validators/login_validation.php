<?php
    function validateLogin() {
        if (!isset($_SESSION['user']) && !isset($_SESSION['isAuth']) && !$_SESSION['isAuth']) {
            unset($_SESSION['user']);
            $_SESSION['isAuth'] = false;
            header('location: ../../index.php');
        }
    }
?>