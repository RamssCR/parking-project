<?php
require_once('../../models/customer_model.php');

class CustomerController {
    private $model;

    public function __construct() {
        $this->model = new CustomerModel();
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

    // Create a customer
    public function create_customer($customer) {
        $insertCustomer = $this->model->create_customer($customer);

        if (!$insertCustomer) return 'Ya existe un cliente con el mismo documento de identidad';
        if ($insertCustomer == 500) return 'Hubo un error al registrar al cliente';
        if ($insertCustomer == 201) return 'Cliente registrado exitosamente';
    }

    // Edit a customer's information
    public function edit_customer($document, $customer) {
        $updateCustomer = $this->model->edit_customer($document, $customer);

        if (!$updateCustomer) return 'Este cliente no existe en la base de datos';
        if ($updateCustomer == 500) return 'Hubo un error al actualizar los datos del cliente';
        if ($updateCustomer == 200) return 'Cliente modificado exitosamente';
    }

    // Disable a customer's information
    public function disable_customer($document) {
        $disableCustomer = $this->model->disable_customer($document);

        if (!$disableCustomer) return 'El cliente a eliminar no existe';
        if ($disableCustomer == 500) return 'Hubo un error al eliminar el cliente';
        if ($disableCustomer == 200) return 'Cliente eliminado exitosamente';
    }
}

?>