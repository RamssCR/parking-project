<?php
session_start();

require_once('../../controllers/customer_controller.php');
require_once('../../models/validators/login_validation.php');
require_once('../../controllers/vehicle_controller.php');
require_once('../../connection.php');
validateLogin();

$vehicleInfo = null;

if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];
    $vehicle_request = new VehicleController();

    // Obtener información del vehículo
    $vehicleInfo = $vehicle_request->get_vehicle($placa); 
} else {
    die("Placa no especificada.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-semibold mb-4">Información del Vehículo</h2>

        <div class="vehicle-card bg-white p-4 rounded-lg shadow-md mb-6">
            <?php if ($vehicleInfo): ?>
                <table class="min-w-full bg-white border border-gray-300">
                    <tr>
                        <th class="py-2 border-b">Modelo</th>
                        <td class="py-2 border-b"><?= htmlspecialchars($vehicleInfo['modelo']) ?></td>
                    </tr>
                    <tr>
                        <th class="py-2 border-b">Placa</th>
                        <td class="py-2 border-b"><?= htmlspecialchars($vehicleInfo['placa']) ?></td>
                    </tr>
                    <tr>
                        <th class="py-2 border-b">Marca</th>
                        <td class="py-2 border-b"><?= htmlspecialchars($vehicleInfo['marca']) ?></td>
                    </tr>
                    <tr>
                        <th class="py-2 border-b">Año</th>
                        <td class="py-2 border-b"><?= htmlspecialchars($vehicleInfo['ano']) ?></td>
                    </tr>
                    <tr>
                        <th class="py-2 border-b">Tipo</th>
                        <td class="py-2 border-b"><?= htmlspecialchars($vehicleInfo['tipo_vehiculo']) ?></td>
                    </tr>
                </table>
                <div class="mt-4">
                    <a href="editar_vehiculo.php?placa=<?= urlencode($vehicleInfo['placa']) ?>" class="text-blue-500">Editar Vehículo</a>
                </div>
            <?php else: ?>
                <p>No se encontró información del vehículo.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="../../JS/displayEdit.js"></script>
</body>
</html>
