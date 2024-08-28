<?php 
require_once("controllers/auth_controller.php");

if (isset($_POST['login'])){

    $auth = new AuthController($_POST['email'], $_POST['password'], $_POST['role']);
    $login = $auth->login();

}
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parking Penta | Login</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="login-container">
        <div class="form-container">
            <h1>Iniciar sesión</h1>
            <?php
                if (is_string($login)) {
                    echo '<span>' . $login . '<span>';
                } else { 
                    echo '<span>' . $login['email'] . '<span>';
                }  
            ?>
            <form method="post">
                <div class="container-group">
                    <label for="email">Correo</label>
                    <input type="text" id="email" placeholder="Ingresa tu correo" name="email" />
                </div>
                <div class="container-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" placeholder="Ingresa tu contraseña"  name="password"/>
                </div>
                <div class="container-group">
                    <label for="role">Rol</label>
                    <select name="role" id="role" class="role-select">
                        <option value="">-- Seleccione rol --</option>
                        <option value="admin">Administrador</option>
                        <option value="empleado">Empleado</option>
                    </select>
                </div>
                <div class="btns-group">
                    <button type="submit" name="login">Ingresar</button>
                    <a href="#">¿Olvidaste tu contraseña?</a>
                </div>
            </form>
        </div>
        <div class="image-container">
            <img src="images/parqueadero2.jpg" alt="banner">
        </div>
    </div>
</body>
</html>