<?php
//validacion para eliminar un empleado
require_once('../../controllers/parking_controller.php');

if (isset($_GET['document']) && isset($_GET['email'])) {
    $controller = new EmployeeController();
    $result = $controller->delete_employee($_GET['document'], $_GET['email']);
    echo $result;
}

?>