<?php
use Controllers\CustomerController;

spl_autoload_register(function($class){
    if (file_exists('../../' . str_replace('\\', '/', $class) . '.php')) {
        require_once('../../' . str_replace('\\', '/', $class) . '.php');
    } 
});

$controller = new CustomerController();
$employees = $controller->showAll_customers();

if (isset($_POST['delete'])) {
    $delete_employee = $controller->disable_customer($_POST['document']);
    echo $delete_employee;
}

while ($employee = mysqli_fetch_assoc($employees)) {
    echo "<tr id='row-{$employee['documento']}'>";
    echo "<td class='py-3 px-4'>{$employee['documento']}</td>";
    echo "<td class='py-3 px-4'><a class='customer' href='cliente_info.php?id_cliente={$employee['id_cliente']}'><img src='../../images/user-regular.svg' alt='user' style='width: 1.5em' />{$employee['nombre']}</a></td>";
    echo "<td class='py-3 px-4'>{$employee['ciudad']}</td>";
    echo "<td class='py-3 px-4'>{$employee['telefono']}</td>";
    echo "<td class='py-3 px-4'>{$employee['email']}</td>";
    echo "<td class='py-3 px-4'>
            <a href='edit_cliente.php?id_cliente={$employee['id_cliente']}' class='text-blue-500 hover:underline'>Editar</a>
            <a href='#' class='text-red-500 hover:underline ml-2' onclick='deleteEmployee(\"{$employee['documento']}\")'>Eliminar</a>
          </td>";
    echo "</tr>";
}
?>
