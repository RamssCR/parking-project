<?php
session_start();

require_once('../../controllers/customer_controller.php');
require_once('../../models/validators/login_validation.php');
require_once('../../controllers/vehicle_controller.php');
require_once('../../connection.php');

validateLogin();
$user = $_SESSION['user'];
$user_pfp = '../../images/' . $user['pic_user'];

if (isset($_GET['id_cliente'])) {
    $id = $_GET['id_cliente'];

    $request = new CustomerController();
    $vehicle_request = new VehicleController();

    $showCustomer = $request->show_customer($id);
    $countedCars = $vehicle_request->countAll_vehicles_customer($id);
    $showAll_vehicles = $vehicle_request->showAll_vehicles_customer($id);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Penta | Información del Cliente</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/customer-information.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php include '../reutils/navbar.php' ?>
    
    <div id="content" class="ml-64 p-6 w-100">
        <?php include '../reutils/navbar-user.php'?>

        <main class="mt-10 px-5">
            <h2 class="text-3xl font-semibold mb-4 pl-4">Información del Cliente</h2>
            <div class="customer-container">
                <img src="../../images/blank-avatar.webp" alt="customer" class="customer-logo">
                <h2 class="text-xl font-semibold mb-4"><?= $showCustomer['nombre'] ?></h2>
                <div class="customer-info-container mx-6 px-6">
                    <div class="info-card">
                        <span class="info-title font-semibold">Documento</span>
                        <span class="info-data"><?= $showCustomer['documento'] ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Ciudad de Residencia</span>
                        <span class="info-data"><?= $showCustomer['ciudad'] ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Dirección</span>
                        <span class="info-data"><?= $showCustomer['direccion'] ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Télefono</span>
                        <span class="info-data"><?= $showCustomer['telefono'] ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Email</span>
                        <span class="info-data"><?= $showCustomer['email'] ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Vehículos Registrados</span>
                        <span class="info-data"><?= $countedCars > 0 ? $countedCars : 'Ninguno' ?></span>
                    </div>
                </div>
            </div>
            <div class="to-register">
                <h2 class="text-2xl font-semibold my-4 pl-4">Vehículos registrados</h2>
                <a href="crear_vehiculo.php"><span class="add">+</span></a>
            </div>
            <section class="all-vehicles px-4">
                <?php
                    if ($countedCars == 0) echo '<span class="empty">No hay Vehículos Registrados</span>';

                    while ($vehicles = mysqli_fetch_assoc($showAll_vehicles)) {?>                    
                        <div class="vehicle-card">
                            <header class="car-card-header">
                                <img src="../../images/<?= $vehicles['tipo_vehiculo'] == 'carro' ? 'car-solid.svg' : 'motorcycle-solid.svg' ?>" alt="car">
                                <h3 class="car-card-title"><?= $vehicles['modelo'] ?></h3>
                            </header>
                            <div class="car-card-info">
                                <div class="card-info-group">
                                    <span class="title">Placa</span>
                                    <span class="data"><?= $vehicles['placa'] ?></span>
                                </div>
                                <div class="card-info-group">
                                    <span class="title">Marca</span>
                                    <span class="data"><?= $vehicles['marca'] ?></span>
                                </div>
                                <div class="card-info-group">
                                    <span class="title">Año</span>
                                    <span class="data"><?= $vehicles['ano'] ?></span>
                                </div>
                                <div class="card-info-group">
                                    <span class="title">Modelo</span>
                                    <span class="data"><?= $vehicles['modelo'] ?></span>
                                </div>
                            </div>
                            <div class="btns-group">
                                <a href="#">Ver Vehículo</a>
                                <a href="#">Eliminar</a>
                            </div>
                        </div>
                    <?php
                    }
                ?>
            </section>
        </main>
    </div>
</body>
</html>