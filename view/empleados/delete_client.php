<?php
//validacion para eliminar un cliente
use Controllers\CustomerController;

spl_autoload_register(function($class){
    if (file_exists('../../' . str_replace('\\', '/', $class) . '.php')) {
        require_once('../../' . str_replace('\\', '/', $class) . '.php');
    } 
});

if (isset($_GET['document'])) {
    $controller = new CustomerController();
    $result = $controller->disable_customer($_GET['document']);
    echo $result;
}

?>