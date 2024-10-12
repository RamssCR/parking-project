<?php

function validatePassword($password) : string | bool {
    // password is empty
    if (strlen($password) == 0) return 'La contraseña no puede estar vacía';

    // password contains 7 characters or less
    if (strlen($password) <= 7) return 'La contraseña debe ser mayor a 8 dígitos';

    // password must contain alphanumeric characters
    if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $password)) return 'La contraseña debe ser alfánumérica';

    return true;
}

?>