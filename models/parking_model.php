<?php

class ParkingModel {
    private $connection;

    public function __construct() {
        $this->connection = mysqli_connect('localhost', 'root', '', 'dbpenta');
    }

    // Get all customers
    public function getAll_customers() {
        return mysqli_execute_query($this->connection, 'SELECT * FROM clientes');
    }

    // Get one customer
    public function get_customer($id) : array | bool {
        $get_customer = mysqli_execute_query($this->connection, 'SELECT * FROM clientes WHERE id_cliente = ?', [$id]);
        if (!$get_customer) return false;

        return mysqli_fetch_assoc($get_customer);
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