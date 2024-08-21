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

    // Create an Admin/user - Employee/user
    public function create_employee($employee) : bool | int {
        $employeeExists = mysqli_execute_query($this->connection, 'SELECT * FROM admin a INNER JOIN empleados e ON a.documento = e.documento WHERE a.documento = ?', 
            [$employee['document']]
        );
        
        if (mysqli_num_rows($employeeExists) >= 1) return false;

        if ($employee['role'] == 'Admin') {
            $createEmployee = mysqli_execute_query($this->connection, 'INSERT INTO admin (documento, nombre, email, telefono) VALUES (?, ?, ?, ?)', 
                [$employee['document'], $employee['name'], $employee['email'], $employee['phone']]
            );
        } else if ($employee['role'] == 'Empleado') {
            $createEmployee = mysqli_execute_query($this->connection, 'INSERT INTO empleados (documento, nombre, email, telefono) VALUES (?, ?, ?, ?)', 
                [$employee['document'], $employee['name'], $employee['email'], $employee['phone']]
            );
        }

        if ($createEmployee) {
            $password = password_hash('parking_' + $employee['document'], PASSWORD_BCRYPT);
            $trigger_createUser = mysqli_execute_query($this->connection, 'INSERT INTO usuarios (email, password, tipo_usuario) VALUES (?, ?, ?)',
                [$employee['email'], $password, $employee['role']]
            );

            if (!$trigger_createUser) return 500;
            return true;
        } else {
            return 500;
        }
    }
}

?>