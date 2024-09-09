<?php
    session_start();
    require_once('../../controllers/parking_controller.php');
    require_once('../../models/validators/login_validation.php');

    validateLogin();
    $user = $_SESSION['user'];
    $user_pfp = '../../images/' . $user['pic_user'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Penta | Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="../../styles/admin.css" rel="stylesheet">
    <script>
        function deleteEmployee(documento, email) {
            if (confirm("¿Estás seguro de que deseas eliminar este empleado?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `delete_employee.php?document=${documento}&email=${email}`, true);
                xhr.onreadystatechange = () => {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        const response = xhr.responseText;
                        if (response.includes("exitosamente")) {
                            const row = document.getElementById(`row-${documento}`);
                            if (row) {
                                row.parentNode.removeChild(row);
                            }
                            alert("Empleado eliminado exitosamente");
                        } else {
                            alert("Error al eliminar el empleado");
                        }
                    }
                };
                xhr.send();
            }
        }
    </script>
</head>
<body class="bg-gray text-gray-900">
    <?php include '../reutils/navbar.php'; ?>

    <!-- Main Content -->
    <div id="content" class="m-0">
        <nav class="bg-blue-900 p-4 w-full rounded-md">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <div id="logo-container">
                        <img id="logo-preview" src='<?= $user_pfp ?>' alt="Logo">
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-2xl text-white font-bold ml-4">PARKING PENTA</h1>
                        <h1 class="text-xl font-bold ml-4" style="color: #EEEEEE;"><?=$user['nombre_usuario']?></h1>
                    </div>
                </div>
                <div>
                    <button class="bg-white text-blue-800 px-4 py-2 rounded-lg shadow-md hover:bg-blue-100">
                        Cerrar Sesión
                    </button>
                </div>
            </div>
        </nav>

        <main class="container mx-auto mt-10">
            <div id="status-message" class="mb-4 px-4 py-2 rounded-lg hidden"></div>

            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-semibold">Lista de Empleados</h2>
            </div>

            <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Documento</th>
                            <th class="py-3 px-4 text-left">Nombre</th>
                            <th class="py-3 px-4 text-left">Email</th>
                            <th class="py-3 px-4 text-left">Teléfono</th>
                            <th class="py-3 px-4 text-left">Puesto</th>
                            <th class="py-3 px-4 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="inventory-body" class="bg-gray-50">
                        <?php include 'list_employee.php'; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        const registers = document.querySelector('#inventory-body')

        if (registers.childElementCount === 0) {
            registers.insertAdjacentHTML("afterbegin", '<span class="text-center font-semibold w-100 block py-3">No hay empleados</span>');
        }
    </script>
</body>
</html>
