<?php
//validacion para eliminar un empleado
use Controllers\EmployeeController;

spl_autoload_register(function($class){
    if (file_exists('../../' . str_replace('\\', '/', $class) . '.php')) {
        require_once('../../' . str_replace('\\', '/', $class) . '.php');
    } 
});

if (isset($_GET['document']) && isset($_GET['email'])) {
    $controller = new EmployeeController();
    $result = $controller->delete_employee($_GET['document'], $_GET['email']);
    echo $result;
}

?>