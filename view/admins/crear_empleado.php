<?php
    require_once('../../controllers/parking_controller.php');
    require_once('../../connection.php');

    if (isset($_POST['send'])){
        
        $employee = [
            'document' => mysqli_real_escape_string($conn, strip_tags($_POST['document_ID'], ENT_QUOTES)),
            'name' => mysqli_real_escape_string($conn, strip_tags($_POST['name'], ENT_QUOTES)),
            'email' => mysqli_real_escape_string($conn, strip_tags($_POST['email'], ENT_QUOTES)),
            'phone' => mysqli_real_escape_string($conn, strip_tags($_POST['phone'], ENT_QUOTES)),
            'role' => mysqli_real_escape_string($conn, strip_tags($_POST['role'], ENT_QUOTES))
        ]; 

        $request = new parkingcontroller();
        $create_employee = $request->create_employee($employee); 

        echo $create_employee;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/empleado.css">
</head>
<body>
<div class="form-container">
        <form action="#" method="post">
            <div class="form-group">
                <label for="document">Documento:</label>
                <input type="text" id="document" name="document" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="email">Correo:</label>
                <input type="email" id="email" name="email" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="phone">Teléfono:</label>
                <input type="tel" id="phone" name="phone" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="role">Rol:</label>
                <select id="role" name="role" class="form-input" required>
                    <option value="empleado">Empleado</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Enviar" class="form-submit">
            </div>
        </form>
    </div>   
    </form>
</body>
</html>
