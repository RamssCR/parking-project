<?php

class VehicleModel {
    private $connection;

    public function __construct() {
        $this->connection = mysqli_connect('localhost', 'root', '', 'dbpenta');
    }

    // Get all vehicles info
    public function getAll_vehicles() {
        return mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos');
    }

    // Get all customer's vehicles
    public function getAll_vehicles_customer($id_customer) {
        $vehicles = mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos WHERE id_cliente = ?', [$id_customer]);
        if (!$vehicles) return false;

        return $vehicles;
    }

    // Get one vehicle
    public function get_vehicle($id) : array | bool {
        $vehicle = mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos WHERE id_vehiculo = ?', [$id]);
        if (!$vehicle) return false;

        return mysqli_fetch_assoc($vehicle);
    }
}

?>