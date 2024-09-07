<?php
    session_start();

    require_once('../../controllers/parking_controller.php');
    require_once('../../models/validators/login_validation.php');
    require_once('../../connection.php');

<<<<<<< HEAD
    if (isset($_POST['send'])) {
        if (!empty($_POST['document_ID']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['role'])) {
            $employee = [
                'document' => mysqli_real_escape_string($conn, strip_tags($_POST['document_ID'], ENT_QUOTES)),
                'name' => mysqli_real_escape_string($conn, strip_tags($_POST['name'], ENT_QUOTES)),
                'email' => mysqli_real_escape_string($conn, strip_tags($_POST['email'], ENT_QUOTES)),
                'phone' => mysqli_real_escape_string($conn, strip_tags($_POST['phone'], ENT_QUOTES)),
                'role' => mysqli_real_escape_string($conn, strip_tags($_POST['role'], ENT_QUOTES))
            ]; 
    
            $request = new ParkingController();
            $create_employee = $request->create_employee($employee);
        } else {
            echo 'Los campos no pueden estar vacíos.';
        }
=======
    validateLogin();
    $user = $_SESSION['user'];

    if (isset($_POST['send'])){
        
        $employee = [
            'document' => mysqli_real_escape_string($conn, strip_tags($_POST['document_ID'], ENT_QUOTES)),
            'name' => mysqli_real_escape_string($conn, strip_tags($_POST['name'], ENT_QUOTES)),
            'email' => mysqli_real_escape_string($conn, strip_tags($_POST['email'], ENT_QUOTES)),
            'phone' => mysqli_real_escape_string($conn, strip_tags($_POST['phone'], ENT_QUOTES)),
            'role' => mysqli_real_escape_string($conn, strip_tags($_POST['role'], ENT_QUOTES))
        ]; 

        $request = new EmployeeController();
        $create_employee = $request->create_employee($employee);
>>>>>>> 9c4d4587a4322f4cf94881c8de9eabebd1b7bc9b
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Penta | Crear Empleado</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="../../styles/admin.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <?php include '../reutils/navbar.php' ?>
    
    <!-- Main Content -->
    <div id="content" class="ml-64 p-6">
        <nav class="bg-blue-900 p-4 w-full rounded-md mb-6">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <div id="logo-container">
                        <img id="logo-preview" src="default-logo.png" alt="Logo">
                        <input id="logo-input" type="file" accept="image/*" class="hidden">
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

        <!-- Formulario de Crear Empleado -->
        <main class="container mx-auto mt-10">
            <div id="status-message" class="mb-4 px-4 py-2 rounded-lg <?php echo isset($create_employee) && str_contains($create_employee, 'Empleado') ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?> <?php echo !isset($create_employee) ? 'hidden' : ''; ?>">
                <?php echo isset($create_employee) ? $create_employee : ''; ?>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg mx-auto">
                <h2 class="text-2xl font-semibold mb-4 text-center">Crear Empleado</h2>
                <form action="crear_empleado.php" method="post" class="space-y-4">
                    <div class="flex flex-col">
                        <label for="document" class="text-gray-700">Documento</label>
                        <input type="text" id="document" name="document_ID" placeholder="ej. 100012345" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="name" class="text-gray-700">Nombre</label>
                        <input type="text" id="name" name="name" placeholder="ej. Ana Pérez" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="email" class="text-gray-700">Correo</label>
                        <input type="email" id="email" name="email" placeholder="ej. anaperez@ejemplo.com" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="phone" class="text-gray-700">Teléfono</label>
                        <input type="tel" id="phone" name="phone" placeholder="ej. 3000123456" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="role" class="text-gray-700">Rol</label>
                        <select id="role" name="role" required class="mt-1 p-2 border border-gray-300 rounded-md">
                            <option value="">-- Seleccione Rol --</option>
                            <option value="Admin">Administrador</option>
                            <option value="Empleado">Empleado</option>
                        </select>
                    </div>
                    <div>
                        <input type="submit" value="Enviar" name="send" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 cursor-pointer">
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusMessage = document.getElementById('status-message');
            if (statusMessage && statusMessage.classList.contains('hidden') === false) {
                setTimeout(function() {
                    statusMessage.classList.add('fade-out');
                    setTimeout(function() {
                        statusMessage.classList.add('hidden');
                    }, 1000); 
                }, 4000); // Tiempo en milisegundos (4 segundos)
            }
        });
    </script>
</body>
</html>
