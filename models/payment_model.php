<?php
class PaymentModel{
    private $connection;

    public function __construct() {
        $this->connection = mysqli_connect('localhost', 'root', '', 'dbpenta');
    }

    // Fetch all payments of a single vehicle
    public function get_vehicle_payments($id_vehicle) {
        $payments = mysqli_execute_query($this->connection, 'SELECT * FROM pago WHERE id_vehiculo = ? AND deshabilitado = ?', [$id_vehicle, 0]);
        return mysqli_num_rows($payments) >= 1 ? $payments : false;
    }

    // Fetch a payment
    public function get_payment($id) {
        $payment = mysqli_execute_query($this->connection, 'SELECT * FROM pago WHERE id_pago = ? AND deshabilitado = ?', [$id, 0]);
        return mysqli_num_rows($payment) >= 1 ? $payment : false;
    }

    // Create a payment
    public function create_payment($payment) {
        $insertPayment = mysqli_execute_query($this->connection, 'INSERT INTO pago (total, tiempo, tarifa, id_vehiculo) VALUES (?, ?, ?, ?)',
            [$payment['total'], $payment['time'], $payment['base_price'], $payment['id_vehicle']]
        );

        if (!$insertPayment) return false;
        return true;
    }

    // Modify a payment
    public function edit_payment($id, $payment) : int | bool {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM pago WHERE id_pago = ? AND deshabilitado = ?', [$id, 0]);
        if (mysqli_num_rows($isExisting) == 0) return false;

        $editPayment = mysqli_execute_query($this->connection, 'UPDATE pago SET tiempo = ?, total = ? WHERE id_pago = ?', [$payment['time'], $payment['total'], $id]);
        if (!$editPayment) return 500;
        return 200;
    }

    // Disable a payment
    public function disable_payment($id) {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM pago WHERE id_pago = ? AND deshabilitado = ?', [$id, 0]);
        if (mysqli_num_rows($isExisting) == 0) return false;

        $disablePayment = mysqli_execute_query($this->connection, 'UPDATE pago SET deshabilitado = ? WHERE id_pago = ?', [1, $id]);
        if (!$disablePayment) return 500;
        return 200;
    }
}
?>