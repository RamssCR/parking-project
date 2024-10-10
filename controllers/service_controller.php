<?php
require_once('../../models/service_model.php');

class ServiceController {
    private $model;

    public function __construct() {
        $this->model = new ServiceModel();
    }

    // Fetch all customer services
    public function showAll_customer_services($id_customer) {
        $services = $this->model->getAll_customer_services($id_customer);
        if ($services == 0) return 'Ninguno';

        return $services;
    }

    // Insert and/or Enable customer services
    public function add_services($id_customer) {
        $request = $this->model->add_services($id_customer);

        if ($request == 500) return 'Hubo un error al agregar los servicios al cliente referenciado';
        if ($request == 200) return 'Servicios habilitados nuevamente';
        if ($request == 201) return 'Servicios agregados exitosamente';
    }

    // Disable customer services
    public function disable_services($id_customer) {
        $disable = $this->model->disable_services($id_customer);

        if (!$disable) return 'Hubo un error al dehabilitar los servicio del cliente';
        if ($disable == 200) return 'Servicios del cliente cancelados por bajo promedio de pago';
    }
}
?>