<?php
namespace Controllers;
use Models\PaymentModel;

spl_autoload_register(function($class){
    if (file_exists(str_replace('\\', '/', $class) . '.php')) {
        require_once str_replace('\\', '/', $class) . '.php';
    }
});

class PaymentController{
    private $model;

    public function __construct() {
       $this->model = new PaymentModel(); 
    }

    // Fetch all payments of a single vehicle
    public function show_vehicle_payment($id_vehicle) {
        $payments = $this->model->get_vehicle_payments($id_vehicle);

        if (!$payments) return 'No hay pagos registrados';
        return $payments;
    }

    // Fetch a payment
    public function show_payment($id) {
        $payment = $this->model->get_payment($id);

        if (!$payment) return 'No existe dicho pago';
        return $payment;
    }

    // Create a payment
    public function create_payment($payment) {
        $insertPayment = $this->model->create_payment($payment);
        return $insertPayment;
    }

    // Modify a payment
    public function edit_payment($id, $payment) {
        $editPayment = $this->model->edit_payment($id, $payment);

        if (!$editPayment) return 'No existe dicho pago';
        if ($editPayment == 500) return 'Hubo un error al modificar los datos del pago';
        if ($editPayment == 200) return 'Pago modificado exitosamente';
    }

    // Disable a payment
    public function disable_payment($id) {
        $disablePayment = $this->model->disable_payment($id);

        if (!$disablePayment) return 'No existe dicho pago';
        if ($disablePayment == 500) return 'Hubo un error al eliminar el pago';
        if ($disablePayment == 200) return 'Pago eliminado exitosamente';
    }
}
?>