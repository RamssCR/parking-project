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
            <h2 class="form-title">Crear empleado</h2>
            <?php
                if (isset($create_employee)) {
                    echo str_contains($create_employee, 'Empleado') ? '<span class="success">' . $create_employee . '</span>' : '<span class="error">' . $create_employee . '</span>';
                }
            ?>
            <div class="form-group">
                <label for="document">Documento</label>
                <input type="text" id="document" name="document_ID" class="form-input" placeholder="ej. 100012345" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="ej. Ana Pérez" required>
            </div>
            <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="ej. anaperez@ejemplo.com" required>
            </div>
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="tel" id="phone" name="phone" class="form-input" placeholder="ej. 3000123456" required>
            </div>
            <div class="form-group">
                <label for="role">Rol</label>
                <select id="role" name="role" class="form-input" required>
                    <option value="">-- Seleccione Rol --</option>
                    <option value="Admin">Administrador</option>
                    <option value="Empleado">Empleado</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Enviar" name="send" class="form-submit">
            </div>
        </form>
    </div>   
    </form>
</body>
</html>
