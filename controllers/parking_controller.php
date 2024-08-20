<?php
require_once('models/parking_model.php');

/*

    $employee = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    ]

    $trigger = [
        'email' => $email,
        'password' => $document_ID,
        'role' => $role
    ]
*/

class ParkingController {
    // Properties
    protected $model;

    public function __construct() {
        $this->model = new ParkingModel();
    }

    // Show all customers
    public function showAll_customers() {
        return $this->model->getAll_customers();
    }

    // Show a customer
    public function show_customer($id) {
        $customer = $this->model->get_customer($id);
        if (!$customer) return 'El cliente no existe';

        return $customer;
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