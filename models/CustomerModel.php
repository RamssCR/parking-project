<?php
namespace Models;
use Abstracts\Connection;

spl_autoload_register(function($class){
    if (file_exists('../../models/' . str_replace('\\', '/', $class) . '.php')) {
        require_once '../../models/' . str_replace('\\', '/', $class) . '.php';
    } 
});

class CustomerModel extends Connection {
    private $connection;

    public function __construct() {
        $this->connection = $this->make_connection();
    }

    // Get all customers
    public function getAll_customers() {
        return mysqli_execute_query($this->connection, 'SELECT * FROM clientes WHERE deshabilitado = ?', [0]);
    }

    // Get one customer
    public function get_customer($id) : array | bool {
        $get_customer = mysqli_execute_query($this->connection, 'SELECT * FROM clientes WHERE id_cliente = ? AND deshabilitado = ?', [$id, 0]);
        if (!$get_customer) return false;

        return mysqli_fetch_assoc($get_customer);
    }

    // Create a customer
    public function create_customer($customer) : int | bool {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM clientes WHERE documento = ?', [$customer['document']]);
        if (!$isExisting) return false;

        $insertCustomer = mysqli_execute_query($this->connection, 'INSERT INTO clientes (documento, nombre, ciudad, direccion, telefono, email) VALUES (?, ?, ?, ?, ?, ?)',
            [$customer['document'], $customer['name'], $customer['city'], $customer['address'], $customer['phone'], $customer['email']]
        );

        if (!$insertCustomer) return 500;
        return 201;
    }

    // Edit customer information
    public function edit_customer($document, $customer) : int | bool {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM clientes WHERE documento = ?', [$document]);
        if (!$isExisting) return false;

        $updateCustomer = mysqli_execute_query($this->connection, 'UPDATE clientes SET nombre = ?, ciudad = ?, direccion = ?, telefono = ?, email = ? WHERE documento = ?',
            [$customer['name'], $customer['city'], $customer['address'], $customer['phone'], $customer['email'], $document]
        );

        if (!$updateCustomer) return 500;
        return 200;
    }

    // Disable customer information
    public function disable_customer($document) : int | bool {
        $isEnabled = mysqli_execute_query($this->connection, 'SELECT * FROM clientes WHERE documento = ? AND deshabilitado = ?', [$document, 0]);
        if (!$isEnabled) return false;

        $disableCustomer = mysqli_execute_query($this->connection, 'UPDATE clientes SET deshabilitado = ? WHERE documento = ?', [1, $document]);
        if (!$disableCustomer) return 500;
        return 200;
    }
}

?>