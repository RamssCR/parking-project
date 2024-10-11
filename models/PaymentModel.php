<?php
namespace Models;
use Controllers\ServiceController;
use Controllers\LockerController;
use Abstracts\Connection;

spl_autoload_register(function($class){
    if (file_exists('../../models/' . str_replace('\\', '/', $class) . '.php')) {
        require_once '../../models/' . str_replace('\\', '/', $class) . '.php';
    } 

    if (file_exists(str_replace('\\', '/', $class) . '.php')) {
        require_once str_replace('\\', '/', $class) . '.php';
    }
});

class PaymentModel extends Connection{
    private $connection;
    private $trigger;
    private $lockerTrigger;

    public function __construct() {
        $this->connection = $this->make_connection();
        $this->trigger = new ServiceController();
        $this->lockerTrigger = new LockerController();
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

        // Expansion

        // Validating if the customer matches the required average to acquire services
        $fetchedAVG = mysqli_execute_query($this->connection, 'SELECT AVG(total) FROM pago WHERE id_vehiculo = ?', [$payment['id_vehicle']]);
        $calculatedAVG = $fetchedAVG->fetch_row()[0];

        // Fetching customer ID
        $fetchedCustomer = mysqli_execute_query($this->connection, 'SELECT * FROM vehiculos WHERE id_vehiculo = ?', [$payment['id_vehicle']]);
        $id_customer = $fetchedCustomer->fetch_assoc()['id_cliente'];

        if ($calculatedAVG < 30000) {
            $this->lockerTrigger->removeLocker($id_customer);
            return $this->trigger->disable_services($id_customer);
        }

        return $this->trigger->add_services($id_customer);
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