<?php
include 'db.php';

// Asignar a las variables $nombre_usuario y $tipo_usuario los valores de las variables de sesión
$nombre_usuario = $_SESSION['nombre'];
$tipo_usuario = $_SESSION['tipo_us'];
// Crear un objeto JSON con el nombre y el tipo de usuario
$response = array(
    'nombre_usuario' => $nombre_usuario,
    'tipo_usuario' => $tipo_usuario
);

// Devolver el objeto JSON
echo json_encode($response);
?>