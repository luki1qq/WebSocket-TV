<?php
include("conect.php");
$mensaje = $_POST['mensaje'];
$tipo = $_POST['tipo'];
$timestamp = date("Y-m-d H:i:s");

$q = "INSERT INTO mensajes(mensaje,tipo,status,timestamp) values('$mensaje','$tipo','1','$timestamp');";
$res = mysqli_query($conex,$q);
$arrayjson = array();
$arrayjson[] = array(
    'mensaje' => $mensaje,
    'tipo' => $tipo,
    'fecha' => $timestamp
);

echo json_encode($arrayjson);
?>