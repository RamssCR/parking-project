<?php


require_once('../../controllers/parking_controller.php');

$controller = new ParkingController();
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
    echo "<td class='py-3 px-4'>
            <a href='edit_employee.php?document={$employee['documento']}' class='text-blue-500 hover:underline'>Editar</a>
            <a href='#' class='text-red-500 hover:underline ml-2' onclick='deleteEmployee(\"{$employee['documento']}\", \"{$employee['email']}\")'>Eliminar</a>
          </td>";
    echo "</tr>";
}
?>
