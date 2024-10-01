<?php 
    require_once '../../models/validators/login_validation.php';
    if (isset($_POST['logout'])) logout();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User navbar</title>
</head>
<body>
    <nav class="bg-blue-900 p-4 w-full rounded-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <div id="logo-container">
                    <img id="logo-preview" src='<?= $user_pfp ?>' alt="Logo">
                </div>
                <div class="flex flex-col">
                    <h1 class="text-2xl text-white font-bold ml-4">PARKING PENTA</h1>
                    <h1 class="text-xl font-bold ml-4" style="color: #EEEEEE; text-transform: uppercase"><?=$user['nombre']?></h1>
                </div>
            </div>
            <form method="post">
                <button class="bg-white text-blue-800 px-4 py-2 rounded-lg shadow-md hover:bg-blue-100" name="logout">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </nav>
</body>
</html>