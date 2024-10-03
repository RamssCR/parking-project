<?php
function validatePFP($picture) : array | string {
    $directory = '../../uploads/';
    $file = $directory . basename($picture['name']);
    $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    // File must be of type image
    $check_fileType = getimagesize($picture['tmp_name']);
    if (!$check_fileType) return 'Ingrese un archivo de tipo imágen válido';

    // File must not exist on the uploads folder before inserting it into the file
    if (file_exists($file)) return 'Ya existe una imagen con el mismo nombre. Renombre el archivo antes de subirlo';

    // File must not be very heavy
    if ($picture['size'] > 500000) return 'La imagen subida es muy pesada. Comprima el archivo antes de subirlo';

    // File must contain one of the following extensions: .png, .jpg, .jpeg, .webp
    // if ($file_extension != 'png' || $file_extension != 'jpg' || $file_extension != 'jpeg' || $file_extension != 'webp') return 'Extensión de imagen invalida, el archivo debe ser .png, .jpg, .jpeg o .webp';

    if (!move_uploaded_file($picture['tmp_name'], $file)) return 'Hubo un error al cargar el archivo. Inténtelo más tarde';
    return ['validated' => $picture['name']];
}
?>