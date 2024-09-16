<?php

class EmployeeModel {
    private $connection;

    public function __construct() {
        $this->connection = mysqli_connect('localhost', 'root', '', 'dbpenta');
    }

    // Get all employees
    public function getAll_employees() {
        return mysqli_execute_query($this->connection, 
            'SELECT admin.documento, admin.nombre, admin.email, admin.telefono, usuarios.tipo_usuario FROM admin INNER JOIN usuarios ON admin.email = usuarios.email UNION
             SELECT empleados.documento, empleados.nombre, empleados.email, empleados.telefono, usuarios.tipo_usuario FROM empleados INNER JOIN usuarios ON empleados.email = usuarios.email');
    }

    // Get an employee
    public function get_employee($id) : array | bool {
        $employee = mysqli_execute_query($this->connection, 
            'SELECT admin.documento, admin.nombre, admin.email, admin.telefono, usuarios.tipo_usuario, usuarios.pic_user 
             FROM admin INNER JOIN usuarios ON admin.email = usuarios.email WHERE documento = ? UNION 
             SELECT empleados.documento, empleados.nombre, empleados.email, empleados.telefono, usuarios.tipo_usuario, usuarios.pic_user
             FROM empleados INNER JOIN usuarios ON empleados.email = usuarios.email WHERE documento = ?',
            [$id, $id]
        );

        if (!$employee) return false;
        return mysqli_fetch_assoc($employee);
    }

    // Create an Admin/user - Employee/user
    public function create_employee($employee) : bool | int {
        $employeeExists = mysqli_execute_query($this->connection, 'SELECT * FROM admin WHERE documento = ? OR email = ? UNION SELECT * FROM empleados WHERE documento = ? OR email = ?', 
            [$employee['document'], $employee['email'], $employee['document'], $employee['email']]
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
            $passwordToHash = 'parking_' . $employee['document'];
            $password = password_hash($passwordToHash, PASSWORD_BCRYPT);
            $trigger_createUser = mysqli_execute_query($this->connection, 'INSERT INTO usuarios (nombre_usuario, email, password, tipo_usuario) VALUES (?, ?, ?, ?)',
                [$employee['name'], $employee['email'], $password, $employee['role']]
            );

            if (!$trigger_createUser) return 500;
            return 201;
        } else {
            return 500;
        }
    }

    // Edit an Admin/Employee
    public function patch_employee($document, $employee) {
        $foundEmployee = mysqli_execute_query($this->connection, 'SELECT * FROM admin WHERE documento = ? UNION SELECT * FROM empleados WHERE documento = ?', 
            [$document, $document]
        );
        if (mysqli_num_rows($foundEmployee) != 1) return 404;
        
        if ($employee['role'] == 'Admin') {
            $updatedEmployee = mysqli_execute_query($this->connection, 'UPDATE admin SET documento = ?, nombre = ?, telefono = ? WHERE documento = ?', 
                [$document, $employee['name'], $employee['phone'], $document]
            );
            if (!$updatedEmployee) return 500;
            return 200;
        } else if ($employee['role'] == 'Empleado') {
            $updatedEmployee = mysqli_execute_query($this->connection, 'UPDATE empleados SET documento = ?, nombre = ?, telefono = ? WHERE documento = ?', 
                [$document, $employee['name'], $employee['phone'], $document]
            );
            if (!$updatedEmployee) return 500;
            return 200;
        }
    }

    // Delete an employee
    public function delete_employee($document, $email) {
        $foundEmployee = mysqli_execute_query($this->connection, 'SELECT * FROM admin WHERE documento = ?', [$document]);

        if ($foundEmployee) {
            $remove_employee = mysqli_execute_query($this->connection, 'DELETE FROM admin WHERE documento = ?', [$document]);
        }

        $foundEmployee2 = mysqli_execute_query($this->connection, 'SELECT * FROM empleados WHERE documento = ?', [$document]);

        if ($foundEmployee2) {
            $remove_employee = mysqli_execute_query($this->connection, 'DELETE FROM empleados WHERE documento = ?', [$document]);
        }

        if ($remove_employee) {
            $trigger_removeUser = mysqli_execute_query($this->connection, 'DELETE FROM usuarios WHERE email = ?', [$email]);
            if (!$trigger_removeUser) return 500;
            return 200;
        } else {
            return 500;
        }
    }
}

?>