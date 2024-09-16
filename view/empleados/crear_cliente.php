<?php
    session_start();

    require_once('../../controllers/customer_controller.php');
    require_once('../../models/validators/login_validation.php');
    require_once('../../connection.php');

    validateLogin();
    $user = $_SESSION['user'];
    $user_pfp = '../../images/' . $user['pic_user'];

    if (isset($_POST['send'])){
        
        $customer = [
            'document' => mysqli_real_escape_string($conn, strip_tags($_POST['document_ID'], ENT_QUOTES)),
            'name' => mysqli_real_escape_string($conn, strip_tags($_POST['name'], ENT_QUOTES)),
            'city' => mysqli_real_escape_string($conn, strip_tags($_POST['ciudad'], ENT_QUOTES)),
            'address' => mysqli_real_escape_string($conn, strip_tags($_POST['direccion'], ENT_QUOTES)),
            'email' => mysqli_real_escape_string($conn, strip_tags($_POST['email'], ENT_QUOTES)),
            'phone' => mysqli_real_escape_string($conn, strip_tags($_POST['phone'], ENT_QUOTES))
           
        ]; 

        $request = new CustomerController();
        $create_customer = $request->create_customer($customer);
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Penta | Crear Cliente</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="../../styles/admin.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <?php include '../reutils/navbar.php' ?>
    
    <!-- Main Content -->
    <div id="content" class="ml-64 p-6">
        <?php include '../reutils/navbar-user.php' ?>

        <!-- Formulario de Crear Empleado -->
        <main class="container mx-auto mt-10">
            <div id="status-message" class="mb-4 px-4 py-2 rounded-lg <?php echo isset($create_customer) && str_contains($create_customer, 'Cliente') ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?> <?php echo !isset($create_customer) ? 'hidden' : ''; ?>">
                <?php echo isset($create_customer) ? $create_customer : ''; ?>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg mx-auto">
                <h2 class="text-2xl font-semibold mb-4 text-center">Crear Cliente</h2>
                <form method="post" class="space-y-4">
                    <div class="flex flex-col">
                        <label for="document" class="text-gray-700">Documento</label>
                        <input type="text" id="document" name="document_ID" placeholder="ej. 100012345" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="name" class="text-gray-700">Nombre</label>
                        <input type="text" id="name" name="name" placeholder="ej. Ana Pérez" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="name" class="text-gray-700">Ciudad</label>
                        <input type="text" id="name" name="ciudad" placeholder="ej. Bogotá" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-gray-700">Direccion</label>
                        <input type="text" id="name" name="direccion" placeholder="ej.  Cl 93A No. 43-79 " required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="email" class="text-gray-700">Correo</label>
                        <input type="email" id="email" name="email" placeholder="ej. anaperez@ejemplo.com" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex flex-col">
                        <label for="phone" class="text-gray-700">Teléfono</label>
                        <input type="tel" id="phone" name="phone" placeholder="ej. 3000123456" required class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                   
                    <div>
                        <input type="submit" value="Enviar" name="send" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 cursor-pointer">
                    </div>
                </form>
            </div>
        </main>
    </div>

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
