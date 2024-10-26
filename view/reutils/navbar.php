<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="../../styles/admin.css" rel="stylesheet">
    <title>navbar</title>
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar" class="p-4">
        <h2 class="text-xl font-semibold mb-6">Menú</h2>
        <ul>
            <?php
                if ($user['tipo_usuario'] == 'Admin') { ?>
                    <li><a href="../admins/admin.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Lista de Empleados</a></li>
                    <li><a href="../admins/crear_empleado.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Crear Empleado</a></li>
                    <li><a href="../empleados/empleado.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Lista de Clientes</a></li>
                    <li><a href="../empleados/crear_cliente.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Crear Cliente</a></li>
                    <li><a href="../empleados/lockers.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Casilleros</a></li>
                    <li><a href="../empleados/profile.php?id_employee=<?= $user['documento'] ?>" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Perfil</a></li>
                    <?php
                }
                ?>
            <?php
                if ($user['tipo_usuario'] == 'Empleado') { ?>
                    <li><a href="empleado.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Lista de Clientes</a></li>
                    <li><a href="crear_cliente.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Crear Cliente</a></li>
                    <li><a href="../empleados/lockers.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Casilleros</a></li>
                    <li><a href="profile.php?id_employee=<?= $user['documento'] ?>" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-200">Perfil</a></li>
                <?php
                }
            ?>
        </ul>
    </div>
</body>
</html>