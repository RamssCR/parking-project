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
    <link rel="stylesheet" href="../,,/empleado.css">
</head>
<body>
    <form method="post">
        <input type="text" name="document_ID" placeholder="document">
        <input type="text" name="name" placeholder="name">
        <input type="text" name="email" placeholder="email">
        <input type="text" name="phone" placeholder="phone">
        <select name="role">
            <option value="">Seleccione rol</option>
            <option value="Admin">Administrador</option>
            <option value="Empleado">Empleado</option>
        </select>
        <input type="submit" name="send" value="Enviar">     
    </form>
</body>
</html>
