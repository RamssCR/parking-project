<?php
require_once('../../models/locker_model.php');

class LockerController {
    private $model;

    public function __construct() {
        $this->model = new LockerModel();
    }

    // Fetching all available lockers
    public function getAll_available_lockers() {
        return $this->model->showAll_available_lockers();
    }

    // Fetching a customer's locker
    public function get_customer_locker($id_customer) {
        $locker = $this->model->show_customer_locker($id_customer);

        if ($locker == 400) return 'Ninguno';
        if ($locker == 500) return 'Error';

        return $locker;
    }

    // Assigning a locker
    public function assignLocker($locker) {
        if (!$locker['id_locker']) return 'Seleccione un locker antes de asignarlo';

        $assign = $this->model->assignLocker($locker);

        if ($assign == 500) return 'Hubo un error al reasignar el casillero';
        if ($assign == 400) return 'Hubo un error al asignar el casillero';
        if ($assign == 201) return 'Casillero asignado exitosamente';
        if ($assign == 200) return 'Casillero reasignado exitosamente';
    }

    // Removing a locker
    public function removeLocker($id_customer) {
        $remove = $this->model->removeLocker($id_customer);

        if (!$remove) return 'Ocurrió un error al remover el casillero del cliente';
        if ($remove == 200) return 'Casillero removido exitosamente';
    }
}
?>