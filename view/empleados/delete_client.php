<?php
//validacion para eliminar un empleado
require_once('../../controllers/customer_controller.php');

if (isset($_GET['document'])) {
    $controller = new CustomerController();
    $result = $controller->disable_customer($_GET['document']);
    echo $result;
}

?>