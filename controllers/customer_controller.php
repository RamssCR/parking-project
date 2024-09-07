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
}

?>