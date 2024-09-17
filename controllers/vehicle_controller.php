<?php
require_once('../../models/vehicle_model.php');

class VehicleController {
    private $model;

    public function __construct() {
        $this->model = new VehicleModel();
    }

    // Show all vehicles
    public function showAll_vehicles() {
        return $this->model->getAll_vehicles();
    }

    // Show all customer's vehicles
    public function showAll_vehicles_customer($id_customer) {
        $vehicles = $this->model->getAll_vehicles_customer($id_customer);
        if (!$vehicles) return 'Este cliente no posee vehículos registrados';

        return $vehicles;
    }

    // Count all customer's vehicles
    public function countAll_vehicles_customer($id_customer) {
        $vehicles = $this->model->countAll_vehicles_customer($id_customer);
        return $vehicles;
    }

    // Show a vehicle
    public function show_vehicle($id) {
        $vehicle = $this->model->get_vehicle($id);
        if (!$vehicle) return 'Este vehículo no está registrado con este cliente';

        return $vehicle;
    }

    // Create a vehicle
    public function create_vehicle($vehicle, $customer, $employee) {
        $insertVehicle = $this->model->create_vehicle($vehicle, $customer, $employee);

        if (!$insertVehicle) return 'Ya existe un vehículo registrado con esa placa';
        if ($insertVehicle == 500) return 'Hubo un error al registrar el vehículo';
        if ($insertVehicle == 201) return 'Vehículo registrado exitosamente';
    }

    // Edit a vehicle's information
    public function edit_vehicle($id, $vehicle) {
        $updateVehicle = $this->model->edit_vehicle($id, $vehicle);

        if (!$updateVehicle) return 'Este vehículo no se encuentra registrado';
        if ($updateVehicle == 500) return 'Hubo un error al actualizar los datos del vehículo';
        if ($updateVehicle == 200) return 'La información del vehículo fue modificada exitosamente';
    }

    // Disable a vehicle
    public function disable_vehicle($id) {
        $disableVehicle = $this->model->disable_vehicle($id);

        if (!$disableVehicle) return 'El vehículo a eliminar no existe';
        if ($disableVehicle == 500) return 'Hubo un error al eliminar el vehículo';
        if ($disableVehicle == 200) return 'Vehículo eliminado exitosamente';
    }
}


?>