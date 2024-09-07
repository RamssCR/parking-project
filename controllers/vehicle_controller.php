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

    // Show a vehicle
    public function show_vehicle($id) {
        $vehicle = $this->model->get_vehicle($id);
        if (!$vehicle) return 'Este vehículo no está registrado con este cliente';

        return $vehicle;
    }
}


?>