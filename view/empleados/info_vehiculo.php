<?php
session_start();
require_once('../../controllers/customer_controller.php');
require_once('../../models/validators/login_validation.php');
require_once('../../controllers/vehicle_controller.php');
require_once('../../connection.php');

if (!isset($_GET['placa'])) {
    die("Placa no especificada.");
}

$placa = mysqli_real_escape_string($conn, $_GET['placa']);
$vehicleController = new VehicleController();
$vehicleInfo = $vehicleController->show_vehicle($placa); 

if (!$vehicleInfo) {
    die("Vehículo no encontrado.");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Vehículo</title>
    <link href="../../styles/admin.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            color: #333;
        }

        #content {
            margin-left: 64px;
            padding: 20px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            max-width: 800px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .details, .history {
            flex: 1;
            margin-right: 20px;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #2563eb;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .btns-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }

        a, button {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            transition: background 0.3s, transform 0.3s;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 16px;
            border: 1px solid transparent;
        }

        .bg-blue-600 {
            background-color: #2563eb;
        }

        .bg-blue-600:hover {
            background-color: #1d4ed8;
            transform: scale(1.05);
        }

        .bg-red-600 {
            background-color: #dc2626;
        }

        .bg-red-600:hover {
            background-color: #b91c1c;
            transform: scale(1.05);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 5px;
            overflow: hidden;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #f9fafb;
            color: #333;
            font-weight: bold;
        }

        .table tr:hover {
            background-color: #f1f5f9;
        }

        .section {
            margin: 20px 0;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .icon {
            margin-right: 5px;
        }

        button:hover, a:hover {
            border: 1px solid #ddd;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #333;
        }

    </style>
</head>
<body>

    <?php include '../reutils/navbar.php'; ?>

    <div id="content">
        <main class="container">
            <div class="details">
                <h2>Detalles del Vehículo</h2>
                <div class="grid">
                    <p><strong>Placa:</strong> <?php echo htmlspecialchars($vehicleInfo['placa']); ?></p>
                    <p><strong>Marca:</strong> <?php echo htmlspecialchars($vehicleInfo['marca']); ?></p>
                    <p><strong>Modelo:</strong> <?php echo htmlspecialchars($vehicleInfo['modelo']); ?></p>
                    <p><strong>Año:</strong> <?php echo htmlspecialchars($vehicleInfo['ano']); ?></p>
                    <p><strong>Propietario:</strong> <?php echo htmlspecialchars($vehicleInfo['id_cliente']); ?></p>
                </div>
                <div class="btns-group">
                    <a href="editar_vehiculo.php?placa=<?php echo urlencode($vehicleInfo['placa']); ?>" class="bg-blue-600">Editar Vehículo</a>
                    <button class="bg-red-600" onclick="confirmDelete()"><i class="bi bi-trash icon"></i> Eliminar</button>
                </div>
            </div>

            <div class="history">  
                <h3>Historial de Pagos</h3>
                <div class="section">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Pago</th>
                                <th>Total</th>
                                <th>Tiempo</th>
                                <th>Tarifa</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paymentHistory as $payment): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($payment['id_pago']); ?></td>
                                    <td><?php echo htmlspecialchars($payment['total']); ?></td>
                                    <td><?php echo htmlspecialchars($payment['tiempo']) . "s"; ?></td>
                                    <td><?php echo htmlspecialchars($payment['tarifa']); ?></td>
                                    <td><?php echo htmlspecialchars($payment['deshabilitado'] ? 'Deshabilitado' : 'Activo'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="section">
                    <button class="bg-blue-600" onclick="startPayment()">Iniciar Pago</button>
                    <button class="bg-red-600" onclick="cancelPayment()">Cancelar Pago</button>
                </div>
            </div>
        </main>
    </div>

    <script>
        function confirmDelete() {
            if (confirm("¿Estás seguro de que deseas eliminar este vehículo?")) {
                // Lógica para eliminar el vehículo
            }
        }
    </script>

</body>
</html>
