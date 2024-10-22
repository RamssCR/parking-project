<?php
use Controllers\EmployeeController;

spl_autoload_register(function($class){
    if (file_exists('../../' . str_replace('\\', '/', $class) . '.php')) {
        require_once('../../' . str_replace('\\', '/', $class) . '.php');
    } 
});

$controller = new EmployeeController();
$employees = $controller->showAll_employees();

if (isset($_POST['delete'])) {
    $delete_employee = $controller->delete_employee($_POST['document'], $_POST['email']);
    echo $delete_employee;
}

while ($employee = mysqli_fetch_assoc($employees)) {
    echo "<tr id='row-{$employee['documento']}'>";
    echo "<td class='py-3 px-4'>{$employee['documento']}</td>";
    echo "<td class='py-3 px-4'>{$employee['nombre']}</td>";
    echo "<td class='py-3 px-4'>{$employee['email']}</td>";
    echo "<td class='py-3 px-4'>{$employee['telefono']}</td>";
    echo "<td class='py-3 px-4'>{$employee['tipo_usuario']}</td>";
    echo "<td class='py-3 px-4'>
            <a href='edit_employee.php?document={$employee['documento']}' class='text-blue-500 hover:underline'>Editar</a>
            <a href='#' class='text-red-500 hover:underline ml-2' onclick='deleteEmployee(\"{$employee['documento']}\", \"{$employee['email']}\")'>Eliminar</a>
          </td>";
    echo "</tr>";
}
?>
