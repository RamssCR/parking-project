<?php
function isVehicle($plate) {
    $splittedPlate = str_split($plate);
    return is_numeric($splittedPlate[6]) ? 'carro' : 'moto';
}
?>