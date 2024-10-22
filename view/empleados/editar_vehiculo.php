<?php
    session_start();
    use Controllers\VehicleController;

    spl_autoload_register(function($class){
        if (file_exists('../../' . str_replace('\\', '/', $class) . '.php')) {
            require_once('../../' . str_replace('\\', '/', $class) . '.php');
        } 
    });

    require_once('../../Models/validators/login_validation.php');
    require_once('../../connection.php');

    validateLogin();
    $user = $_SESSION['user'];

    if (isset($_GET['placa'])) {
        $plate = $_GET['placa'];
    } else {
        header('location: empleado.php');
    }
    $request = new VehicleController();
    $fetch_vehicle = $request->show_vehicle($plate);

    if (isset($_POST['send'])){
        $vehicle = [
            'brand' => mysqli_real_escape_string($conn, strip_tags($_POST['marca'], ENT_QUOTES)),
            'model' => mysqli_real_escape_string($conn, strip_tags($_POST['modelo'], ENT_QUOTES)),
            'year' => mysqli_real_escape_string($conn, strip_tags($_POST['year'], ENT_QUOTES)),
        ]; 

        $edit_vehicle = $request->edit_vehicle($plate, $vehicle);
        if (str_contains($edit_vehicle, 'modificada')) header('location: cliente_info.php?id_cliente='.$fetch_vehicle['id_cliente']);
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Penta | Editar Vehículo</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="../../styles/admin.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <?php include '../reutils/navbar.php' ?>
    
    <!-- Main Content -->
    <div id="content" class="ml-64 p-6 w-90 overflow-hidden">
        <?php include '../reutils/navbar-user.php' ?>

        <!-- Formulario de Crear Empleado -->
        <main class="container mx-auto mt-10">
            <div id="status-message" class="mb-4 px-4 py-2 rounded-lg <?php echo isset($edit_vehicle) && str_contains($edit_vehicle, 'Vehículo') ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?> <?php echo !isset($edit_vehicle) ? 'hidden' : ''; ?>">
                <?php echo isset($edit_vehicle) ? $edit_vehicle : ''; ?>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg mx-auto">
                <h2 class="text-2xl font-semibold mb-4 text-center changer">Editar vehiculo</h2>
                <form method="post" class="space-y-4">
                    <div class="flex flex-col">
                        <label for="document" class="text-gray-700">Placa</label>
                        <input type="text" id="document" value="<?= $fetch_vehicle['placa'] ?>" name="placa" disabled placeholder="ej. SMC53G" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="name" class="text-gray-700">Marca</label>
                        <input type="text" id="name" value="<?= $fetch_vehicle['marca'] ?>" name="marca" placeholder="ej. Chapin" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="name" class="text-gray-700">Modelo</label>
                        <input type="text" id="name" value="<?= $fetch_vehicle['modelo'] ?>" name="modelo" placeholder="ej. 2019" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-gray-700">Año</label>
                        <input type="text" id="name" value="<?= $fetch_vehicle['ano'] ?>" name="year" placeholder="ej.  2022 " required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    
                   
                    <div>
                        <input type="submit" value="Enviar" name="send" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 cursor-pointer">
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="../../JS/showBgPicture.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded',() => {
            const statusMessage = document.getElementById('status-message');
            if (statusMessage && statusMessage.classList.contains('hidden') === false) {
                setTimeout(() => {
                    statusMessage.classList.add('fade-out');
                    setTimeout(() => {
                        statusMessage.classList.add('hidden');
                    }, 1000); 
                }, 4000);
            }
        });
    </script>
</body>
</html>
