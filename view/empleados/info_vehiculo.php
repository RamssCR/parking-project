<?php
session_start();

require_once('../../controllers/customer_controller.php');
require_once('../../models/validators/login_validation.php');
require_once('../../controllers/vehicle_controller.php');
require_once('../../controllers/payment_controller.php');
validateLogin();

$user = $_SESSION['user'];

if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];

    $vehicle_request = new VehicleController();
    $payment_request = new PaymentController();

    // Obtener información del vehículo
    $vehicleInfo = $vehicle_request->show_vehicle($placa);
    $paymentInfo = $payment_request->show_vehicle_payment($vehicleInfo['id_vehiculo']);

    // Realizamos la inserción del nuevo pago
    if (isset($_POST['calculate'])) {
        $base_price = $vehicleInfo['tipo_vehiculo'] == 'carro' ? 20000 : 15000;
        $time = $_POST['time'] < 1 ? 1 : $_POST['time'];
        $total = $base_price * $time;
        
        if ($time < 1) $total = $base_price;

        $request_payment = [
            'base_price' => $base_price,
            'time' => $time,
            'total' => $total,
            'id_vehicle' => $vehicleInfo['id_vehiculo']
        ];


        $insert_payment = $payment_request->create_payment($request_payment);
        if ($insert_payment) header('location: info_vehiculo.php?placa='.$placa);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Penta | Información del Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/vehicle_info.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php include '../reutils/navbar.php' ?>

    <div class="ml-64 p-6 w-screen">
        <?php include '../reutils/navbar-user.php'?>
        <h2 class="text-3xl font-semibold my-6 mx-4 changer">Información del Vehículo</h2>

        <div class="vehicle-card bg-white rounded-lg shadow-md">
            <article class="vehicle-info">
                <img src="../../images/<?= $vehicleInfo['tipo_vehiculo'] == 'carro' ? 'car-solid.svg' : 'motorcycle-solid.svg' ?>" alt="car">
                <div class="info-group">
                    <span class="title">Placa</span>
                    <span class="desc id"><?= $vehicleInfo['placa'] ?></span>
                </div>
                <div class="info-group">
                    <span class="title">Marca</span>
                    <span class="desc"><?= $vehicleInfo['marca'] ?></span>
                </div>
                <div class="info-group">
                    <span class="title">Modelo</span>
                    <span class="desc"><?= $vehicleInfo['modelo'] ?></span>
                </div>
                <div class="info-group">
                    <span class="title">Año</span>
                    <span class="desc"><?= $vehicleInfo['ano'] ?></span>
                </div>
                <div class="mt-4">
                    <a href="editar_vehiculo.php?placa=<?= urlencode($vehicleInfo['placa']) ?>" class="edit">Editar Vehículo</a>
                </div>
            </article>
            <article class="payment-actions-container">
                <form method="post" class="btns-payment-actions">
                    <button class="play">Iniciar Contador</button>
                    <button class="stop" name="calculate">Calcular Pago</button>
                    <input class="time" type="text" value="00:00:00" disabled>
                    <input class="time2" type="hidden" name="time">
                </form>
                <h3 class="text-xl font-semibold mx-6">Pagos Recientes</h3>
                <table class="payments-table">
                    <thead>
                        <tr>
                            <th>ID pago</th>
                            <th>Tarifa</th>
                            <th>Tiempo <span class="mini">(en horas)</span></th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (is_string($paymentInfo)) echo '<tr><td class="no-payment" colspan="4">No hay pagos registrados</td></tr>';
                            if (!is_string($paymentInfo)) {
                                while ($payment = mysqli_fetch_assoc($paymentInfo)) {?>
                                    <tr>
                                        <td><?= $payment['id_pago'] ?></td>
                                        <td>$<span class="tarifa"><?= $payment['tarifa'] ?></span></td>
                                        <td><?= $payment['tiempo'] ?></td>
                                        <td><strong>$<span class="total"><?= $payment['total'] ?></strong></span></td>
                                    </tr>
                                <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </article>
        </div>
    </div>
    <script>
        const bgImage = localStorage.getItem('background')
        if (bgImage) {
            document.body.style.backgroundImage = `url(../../images/background/${bgImage})`
            document.querySelectorAll('.changer').forEach(title => bgImage.includes("8") ? title.style.color = "#f6f6f6" : title.style.color = "#222222")
        }
    </script>
    <script src="../../JS/currencyFormat.js"></script>
    <script src="../../JS/timeCounter.js"></script>
</body>
</html>
