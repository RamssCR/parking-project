<?php
function isVehicle($plate) {
    $splittedPlate = explode("", $plate);
    return is_string($splittedPlate[6]) ? 'moto' : 'carro';
}
?>