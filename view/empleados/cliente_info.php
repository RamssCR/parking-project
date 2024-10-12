<?php
session_start();

use Controllers\CustomerController;
use Controllers\VehicleController;
use Controllers\ServiceController;
use Controllers\LockerController;

spl_autoload_register(function($class){
    if (file_exists('../../' . str_replace('\\', '/', $class) . '.php')) {
        require_once('../../' . str_replace('\\', '/', $class) . '.php');
    } 
});

require_once('../../Models/validators/login_validation.php');

validateLogin();
$user = $_SESSION['user'];

if (isset($_GET['id_cliente'])) {
    $id = $_GET['id_cliente'];

    $customer_request = new CustomerController();
    $vehicle_request = new VehicleController();
    $service_request = new ServiceController();
    $locker_request = new LockerController();

    $showCustomer = $customer_request->show_customer($id);
    
    $countedCars = $vehicle_request->countAll_vehicles_customer($id);
    $countedServices = $service_request->showAll_customer_services($id);
    $showAll_vehicles = $vehicle_request->showAll_vehicles_customer($id);

    $showAll_available_lockers = $locker_request->getAll_available_lockers();
    $show_customer_locker = $locker_request->get_customer_locker($id);

    if (isset($_POST['assign'])) {
        $locker = [
            'id_customer' => $id,
            'id_locker' => $_POST['locker']
        ];

        $assignLocker = $locker_request->assignLocker($locker);
        if (str_contains($assignLocker, 'exitosamente')) header('location: cliente_info.php?id_cliente='.$id);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
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
    
    <div id="content" class="ml-64 p-6">
        <?php include '../reutils/navbar-user.php'?>

        <main class="mt-10 px-5">
            <h2 class="text-3xl font-semibold mb-4 pl-4 changer">Información del Cliente</h2>
            <div class="customer-container">
                <img src="../../images/blank-avatar.webp" alt="customer" class="customer-logo">
                <h2 class="text-xl font-semibold mb-4"><?= htmlspecialchars($showCustomer['nombre']) ?></h2>
                <div class="customer-info-container mx-6 px-6">
                    <div class="info-card">
                        <span class="info-title font-semibold">Documento</span>
                        <span class="info-data"><?= htmlspecialchars($showCustomer['documento']) ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Ciudad de Residencia</span>
                        <span class="info-data"><?= htmlspecialchars($showCustomer['ciudad']) ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Dirección</span>
                        <span class="info-data"><?= htmlspecialchars($showCustomer['direccion']) ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Télefono</span>
                        <span class="info-data"><?= htmlspecialchars($showCustomer['telefono']) ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Email</span>
                        <span class="info-data"><?= htmlspecialchars($showCustomer['email']) ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Vehículos Registrados</span>
                        <span class="info-data"><?= $countedCars > 0 ? $countedCars : 'Ninguno' ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Servicios Activos</span>
                        <span class="info-data"><?= $countedServices ?></span>
                    </div>
                    <div class="info-card">
                        <span class="info-title font-semibold">Casillero Asignado</span>
                        <span class="info-data"><?= $show_customer_locker ?></span>
                    </div>
                </div>
            </div>
            <div class="to-register px-4">
                <h2 class="text-2xl font-semibold my-4 changer">Vehículos registrados</h2>
                <div class="btns-create">
                    <a href="crear_vehiculo.php?id_customer=<?= $showCustomer['id_cliente'] ?>"><span class="add">+</span></a>
                    <?php
                        if ($countedServices == 2) { ?>
                            <button class="activate_modal"><span class="add">+</span></button>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <section class="all-vehicles px-4">
                <?php
                    if ($countedCars == 0) echo '<span class="empty">No hay Vehículos Registrados</span>';

                    while ($vehicles = mysqli_fetch_assoc($showAll_vehicles)) { ?>                    
                        <div class="vehicle-card">
                            <header class="car-card-header">
                                <div class="separator">
                                    <img src="../../images/<?= $vehicles['tipo_vehiculo'] == 'carro' ? 'car-solid.svg' : 'motorcycle-solid.svg' ?>" alt="car">
                                    <h3 class="car-card-title"><?= htmlspecialchars($vehicles['modelo']) ?></h3>
                                </div>
                                <a href="editar_vehiculo.php?placa=<?= urlencode($vehicles['placa']) ?>"><img src="../../images/pencil-solid.svg" class="edit"/></a>
                            </header>
                            <div class="car-card-info">
                                <div class="card-info-group">
                                    <span class="title">Placa</span>
                                    <span class="data"><?= htmlspecialchars($vehicles['placa']) ?></span>
                                </div>
                                <div class="card-info-group">
                                    <span class="title">Marca</span>
                                    <span class="data"><?= htmlspecialchars($vehicles['marca']) ?></span>
                                </div>
                                <div class="card-info-group">
                                    <span class="title">Año</span>
                                    <span class="data"><?= htmlspecialchars($vehicles['ano']) ?></span>
                                </div>
                                <div class="card-info-group">
                                    <span class="title">Modelo</span>
                                    <span class="data"><?= htmlspecialchars($vehicles['modelo']) ?></span>
                                </div>
                            </div>
                            <div class="btns-group">
                                <a href="info_vehiculo.php?placa=<?= urlencode($vehicles['placa']) ?>">Ver Vehículo</a>
                                <a href="#">Eliminar</a>
                            </div>
                        </div>
                    <?php
                    }
                ?>
            </section>
        </main>
        <?php
            if ($countedServices == 2) { ?>
                <section class="modal">
                    <span class="quit">X</span>
                    <form method="post" class="locker-form">
                        <h2 class="form-title">Agregar nuevo casillero</h2>
                        <?php
                            if (isset($assignLocker)) { ?>
                                <span class="form-error"><?= $assignLocker ?></span>
                            <?php
                            }
                        ?>
                        <div class="input-group">
                            <label for="locker">Casillero</label>
                            <select name="locker" id="locker">
                                <option value="">-- Seleccione Casillero --</option>
                                <?php
                                    while ($available_lockers = mysqli_fetch_assoc($showAll_available_lockers)) { ?>
                                        <option value="<?= $available_lockers['id_locker'] ?>"><?= $available_lockers['codigo_locker'] ?></option>
                                    <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <input type="submit" name="assign" value="Asignar">
                    </form>
                </section>
            <?php
            }

        ?>
    </div>

    <script>
        const bgImage = localStorage.getItem('background')
        if (bgImage) {
            document.body.style.backgroundImage = `url(../../images/background/${bgImage})`
            document.querySelectorAll('.changer').forEach(title => bgImage.includes("8") ? title.style.color = "#f6f6f6" : title.style.color = "#222222")
        }
    </script>
    <script src="../../JS/displayEdit.js"></script>
    <script src="../../JS/displayLockerForm.js"></script>
</body>
</html>
