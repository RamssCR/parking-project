<?php
namespace Models;
use Abstracts\Connection;

spl_autoload_register(function($class){
    if (file_exists('../../models/' . str_replace('\\', '/', $class) . '.php')) {
        require_once '../../models/' . str_replace('\\', '/', $class) . '.php';
    } 
});

class ServiceModel extends Connection {
    private $connection;

    public function __construct() {
        $this->connection = $this->make_connection();
    }

    // Fetch all customer services
    public function getAll_customer_services($id_customer) {
        $services = mysqli_execute_query($this->connection, 'SELECT COUNT(*) FROM servicios WHERE id_cliente_fk = ? AND habilitado = ?', [$id_customer, 1]);
        return $services->fetch_row()[0];
    }

    // Create and/or Enable services
    public function add_services($id_customer) {
        $services = mysqli_execute_query($this->connection, 'SELECT * FROM servicios WHERE id_cliente_fk = ?', [$id_customer]);

        // In case the services are created but disabled
        if (mysqli_num_rows($services) >= 1) {
            $updateServices = mysqli_execute_query($this->connection, 'UPDATE servicios SET habilitado = ? WHERE id_cliente_fk = ?', [1, $id_customer]);
            return !$updateServices ? 500 : 200;
        }

        $insertServices = mysqli_execute_query($this->connection, 
            'INSERT INTO servicios (nombre_servicio, id_cliente_fk, habilitado) VALUES(?, ?, ?), (?, ?, ?)', 
            ['Locker', $id_customer, 1, 
            'Autolavado', $id_customer, 1]
        );

        return !$insertServices ? 500 : 201;
    }

    // Disable services
    public function disable_services($id_customer) {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM servicios WHERE id_cliente_fk = ?', [$id_customer]);
        if (mysqli_num_rows($isExisting) == 0) return 100;

        $services = mysqli_execute_query($this->connection, 'UPDATE servicios SET habilitado = ? WHERE id_cliente_fk = ?', [0, $id_customer]);
        return !$services ? false : 200;
    }
}
?>