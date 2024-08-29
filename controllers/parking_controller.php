<?php
require_once('../../models/parking_model.php');

class ParkingController {
    // Properties
    protected $model;

    public function __construct() {
        $this->model = new ParkingModel();
    }

    // GET Requests

    // CUSTOMER

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

    // VEHICLES

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

    // EMPLOYEES

    // Show all employees
    public function showAll_employees() {
        return $this->model->getAll_employees();
    }

    // Show one employee
    public function show_employee($id) {
        $employee = $this->model->get_employee($id);

        if (!$employee) return 'El empleado buscado no existe';
        return $employee;
    }

    // POST Requests

    // Create an Admin/user - Employee/user
    public function create_employee($employee) {
        $create_newEmployee = $this->model->create_employee($employee);

        if (!$create_newEmployee) return 'Ya existe un usuario con el mismo número de documento o correo electrónico';
        if ($create_newEmployee == 201) return 'Empleado y Usuario creado exitosamente';
        if ($create_newEmployee == 500) return 'Hubo un error al agregar un nuevo empleado';
    }

    // PATCH employee
    public function patch_employee($document, $employee) {
        $patching_employee = $this->model->patch_employee($document, $employee);

        if ($patching_employee == 404) return 'No existe tal usuario en la aplicación';
        if ($patching_employee == 500) return 'Hubo un error al actualizar los datos del usuario';
        if ($patching_employee) return 'Usuario modificado exitosamente';
    }

    // DELETE employee
    public function delete_employee($document, $email) {
        $remove_employee = $this->model->delete_employee($document, $email);

        if ($remove_employee == 500) return 'Hubo un error al eliminar el empleado selecionado';
        if ($remove_employee) return 'Empleado y usuario eliminados exitosamente';
    }
}

?>