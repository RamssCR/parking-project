<?php
namespace Models;
use Abstracts\Connection;

spl_autoload_register(function($class){
    if (file_exists('../../models/' . str_replace('\\', '/', $class) . '.php')) {
        require_once '../../models/' . str_replace('\\', '/', $class) . '.php';
    } 
});

class LockerModel extends Connection {
    private $connection;

    public function __construct() {
        $this->connection = $this->makeConnection();
    }

    // Show all available lockers
    public function showAll_available_lockers() {
        return mysqli_execute_query($this->connection, 'SELECT * FROM lockers WHERE asignado = ?', [0]);
    }

    // Show a customer's locker
    public function show_customer_locker($id_customer) {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM locker_cliente WHERE id_cliente = ?', [$id_customer]);
        if (mysqli_num_rows($isExisting) == 0) return 400;

        $locker_id = $isExisting->fetch_assoc()['id_locker'];
        $locker = mysqli_execute_query($this->connection, 'SELECT * FROM lockers WHERE id_locker = ? AND asignado = ?', [$locker_id, 1]);
        if (mysqli_num_rows($locker) == 0) return 500;

        return $locker->fetch_assoc()['codigo_locker'];
    }

    // Assign a locker
    public function assignLocker($locker) {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM locker_cliente WHERE id_cliente = ?', [$locker['id_customer']]);

        // if locker is assigned to the same person we're changing the locker to
        if (mysqli_num_rows($isExisting) == 1) {
            $locker_id = $isExisting->fetch_assoc()['id_locker'];

            // Set the locker in use to zero
            $setDisabled = mysqli_execute_query($this->connection, 'UPDATE lockers SET asignado = ? WHERE id_locker = ?', [0, $locker_id]);
            if (!$setDisabled) return 500;

            // Update the relationship with the new locker ID
            $updateLockerCustomer = mysqli_execute_query($this->connection, 'UPDATE locker_cliente SET id_locker = ? WHERE id_cliente = ?', 
                [$locker['id_locker'], $locker['id_customer']]
            );
            if (!$updateLockerCustomer) return 500;

            // Update the reassigned locker
            $updateLockers = mysqli_execute_query($this->connection, 'UPDATE lockers SET asignado = ? WHERE id_locker = ?',
                [1, $locker['id_locker']]
            );
            if (!$updateLockers) return 500;
            return 200;
        }

        $assignLocker = mysqli_execute_query($this->connection, 'INSERT INTO locker_cliente (id_cliente, id_locker) VALUES (?, ?)', 
            [$locker['id_customer'], $locker['id_locker']]
        );
        if (!$assignLocker) return 400;

        $updateLockers = mysqli_execute_query($this->connection, 'UPDATE lockers SET asignado = ? WHERE id_locker = ?',
        [1, $locker['id_locker']]
    );
        if (!$updateLockers) return 400;
        return 201;
    }

    // Removing locker from customer
    public function removeLocker($id_customer) {
        $isExisting = mysqli_execute_query($this->connection, 'SELECT * FROM locker_cliente WHERE id_cliente = ?', [$id_customer]);
        if (mysqli_num_rows($isExisting) == 0) return 100;

        $locker_id = $isExisting->fetch_assoc()['id_locker'];

        $updateLockers = mysqli_execute_query($this->connection, 'UPDATE lockers SET asignado = ? WHERE id_locker = ?', [0, $locker_id]);
        if (!$updateLockers) return false;

        $deleteAssignedLocker = mysqli_execute_query($this->connection, 'DELETE FROM locker_cliente WHERE id_cliente = ? AND id_locker = ?', 
            [$id_customer, $locker_id]
        );
        if (!$deleteAssignedLocker) return false;
        return 200;
    }
}
?>