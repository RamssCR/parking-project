<?php
session_start();

use Controllers\LockerController;

spl_autoload_register(function($class){
    if (file_exists('../../' . str_replace('\\', '/', $class) . '.php')) {
        require_once('../../' . str_replace('\\', '/', $class) . '.php');
    } 
});

require_once('../../Models/validators/login_validation.php');
validateLogin();

$user = $_SESSION['user'];

$request = new LockerController();
$fetchLockers = $request->getAll_lockers();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Penta | Casilleros</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/lockers.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php include '../reutils/navbar.php' ?>
    
    <div id="content" class="ml-64 p-6">
        <?php include '../reutils/navbar-user.php'?>

        <main class="mt-10 px-5">
            <h2 class="text-3xl font-semibold mb-4 pl-4 changer">Casilleros</h2>
            <div class="customer-container">
                <h2 class="text-xl font-semibold mb-6">Lista de Casilleros</h2>
                <div class="locker-info-container mx-6 px-6">
                    <?php
                        while ($locker = mysqli_fetch_assoc($fetchLockers)) { ?>
                            <div class="locker <?= $locker['asignado'] == 0 ? 'free' : 'taken' ?>">
                                <span class="code"><?= $locker['codigo_locker'] ?></span>
                            </div> 
                        <?php
                        }
                    ?>
                </div>

                <div class="leyends-container">
                    <div class="groups">
                        <div class="leyend-color free"></div>
                        <span class="leyend-item">Libre</span>
                    </div>
                    <div class="groups">
                        <div class="leyend-color taken"></div>
                        <span class="leyend-item">Asignado</span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../../JS/showBgPicture.js"></script>
</body>
</html>
