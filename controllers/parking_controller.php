<?php
require_once('../../models/parking_model.php');

class EmployeeController {
    // Properties
    protected $model;

    public function __construct() {
        $this->model = new EmployeeModel();
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