<?php

class VehicleModel {
    private $connection;

    public function __construct() {
        $this->connection = mysqli_connect('localhost', 'root', '', 'dbpenta');
    }

    // Get all vehicles info
    public function getAll_vehicles() {
        return mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos WHERE deshabilitado = ?', [0]);
    }

    // Get all customer's vehicles
    public function getAll_vehicles_customer($id_customer) {
        $vehicles = mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos WHERE id_cliente = ? AND deshabilitado = ?', [$id_customer, 0]);
        if (!$vehicles) return false;

        return $vehicles;
    }

    // Count all customer's vehicles
    public function countAll_vehicles_customer($id_customer) : int {
        $counter = mysqli_execute_query($this->connection, 'SELECT COUNT(*) FROM vehiculos WHERE id_cliente = ? AND deshabilitado = ?', [$id_customer, 0]);
        return $counter->fetch_row()[0];
    }

    // Get one vehicle
    public function get_vehicle($id) : array | bool {
        $vehicle = mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos WHERE placa = ? AND deshabilitado = ?', [$id, 0]);
        if (!$vehicle) return false;

        return mysqli_fetch_assoc($vehicle);
    }

    // Register a vehicle
    public function create_vehicle($vehicle, $customer, $employee) : int | bool {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos WHERE placa = ?', [$vehicle['plate']]);
        if (mysqli_num_rows($isExisting) >= 1) return false;

        $insertVehicle = mysqli_execute_query($this->connection, 'INSERT INTO vehiculos (placa, marca, modelo, ano, tipo_vehiculo, id_cliente, id_empleado) VALUES(?, ?, ?, ?, ?, ?, ?)', 
            [$vehicle['plate'], $vehicle['brand'], $vehicle['model'], $vehicle['year'], $vehicle['type'], $customer, $employee]
        );

        if (!$insertVehicle) return 500;
        return 201;
    }

    // Edit a vehicle's information
    public function edit_vehicle($id, $vehicle) : int | bool {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos WHERE placa = ?', [$id]);
        if (mysqli_num_rows($isExisting) == 0) return false;

        $updateVehicle = mysqli_execute_query($this->connection, 'UPDATE vehiculos SET marca = ?, modelo = ?, ano = ? WHERE placa = ?',
            [$vehicle['brand'], $vehicle['model'], $vehicle['year'], $id]
        );

        if (!$updateVehicle) return 500;
        return 200;
    }

    // Disable a vehicle
    public function disable_vehicle($id) : int | bool {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos WHERE placa = ?', [$id]);
        if (mysqli_num_rows($isExisting) == 0) return false;

        $disableVehicle = mysqli_execute_query($this->connection, 'UPDATE vehiculo SET deshabilitado = ? WHERE placa = ?', [1, $id]);

        if (!$disableVehicle) return 500;
        return 200;
    }
}

?>