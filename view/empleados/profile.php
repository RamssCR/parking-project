<?php
session_start();
require_once('../../models/validators/login_validation.php');
require_once('../../controllers/parking_controller.php');

validateLogin();
$user = $_SESSION['user'];

if (!isset($_GET['id_employee'])) $user['tipo_usuario'] == 'admin' ? header('location: ../admins/admin.php') : header('empleado.php');
if (isset($_POST['change'])) {
    $request = new EmployeeController();
    if ($_FILES['pfp']){
        $changePFP = $request->change_profile_picture($user['email'], $user['documento'], $_FILES['pfp']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Penta | Perfil del Empleado</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/profile.css">
</head>
<body class="bg-gray-100 text-gray-900 bg">
    <?php include '../reutils/navbar.php' ?>
    <div id="content" class="ml-64 p-6">
        <?php include '../reutils/navbar-user.php'?>
        
        <main class="mt-10 px-5">
            <div id="status-message" class="mb-4 px-4 py-2 rounded-lg <?php echo isset($changePFP) && str_contains($changePFP, 'exitosamente') ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?> <?php echo !isset($changePFP) ? 'hidden' : ''; ?>">
                <?php echo isset($changePFP) ? $changePFP : ''; ?>
            </div>
            <h2 class="text-3xl font-semibold mb-10 pl-4 changer">Información del Empleado</h2>
            <section class="profile-container-all">
                <article class="profile-card">
                    <img src='<?= $user_pfp ?>' alt="user picture" class="profile-img">
                    <h2 class="text-3xl font-semibold my-3 text-center"><?= $user['nombre'] ?></h2>
                    <h3 class="text-2xl font-semibold mb-3">Datos Básicos</h3>
                    <div class="info-container">
                        <div class="info-groups">
                            <span class="title">Nombres</span>
                            <span class="desc"><?= $user['nombre'] ?></span>
                        </div>
                        <div class="info-groups">
                            <span class="title">Cargo</span>
                            <span class="desc"><?= $user['tipo_usuario'] == 'Admin' ? 'Administrador' : 'Empleado' ?></span>
                        </div>
                        <div class="info-groups">
                            <span class="title">Email</span>
                            <span class="desc"><?= $user['email'] ?></span>
                        </div>
                        <div class="info-groups">
                            <span class="title">Teléfono</span>
                            <span class="desc"><?= $user['telefono'] ?></span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-semibold mt-10 mb-6">Configuración de la Cuenta</h3>
                    <form method="post" class="profile-pic-form" enctype="multipart/form-data">
                        <label for="pfp">Cambiar Foto de Perfil</label>
                        <div class="input-group">
                            <input type="file" name="pfp" id="pfp" />
                            <input type="submit" value="Cambiar" name="change" />
                        </div>
                    </form>
                    <div class="bg-pic-container">
                        <h4 class="text-xl font-semibold mt-6 mb-4">Cambiar Fondo de Pantalla</h4>
                        <button class="show">Motrar Fondos</button>
                        <div class="pics-container">
                            <img src="../../images/background/background-1.jpg" alt="background" id="1">
                            <img src="../../images/background/background-3.jpg" alt="background" id="3">
                            <img src="../../images/background/background-4.jpg" alt="background" id="4">
                            <img src="../../images/background/background-8.jpg" alt="background" id="8">
                        </div>
                    </div>
                </article>
            </section>
        </main>
    </div>
    <script src="../../JS/background-picture.js"></script>
</body>
</html>