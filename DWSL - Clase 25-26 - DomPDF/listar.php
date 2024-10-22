<?php
require 'vendor/autoload.php';
include 'conf.php';

$connection = new Connection();
$conn = $connection->getConnection();

$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : null;

$producto = isset($_POST['producto']) ? $_POST['producto'] : null;
$proveedor = isset($_POST['proveedor']) ? $_POST['proveedor'] : null;
$fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : null;
$fechaFinal = isset($_POST['fechaFinal']) ? $_POST['fechaFinal'] : null;

$reports = [];

if ($opcion == 1) {
    $query = "CALL sp_ReportType1(:producto, :proveedor);";
    $result = $conn->prepare($query);
    $result->bindParam("producto", $producto);
    $result->bindParam("proveedor", $proveedor);
    $result->execute();
    $reports = $result->fetchAll(PDO::FETCH_ASSOC);
} elseif ($opcion == 2) {
    $query = "CALL sp_ReportType2(:fechaInicio, :fechaFinal);";
    $result = $conn->prepare($query);
    $result->bindParam("fechaInicio", $fechaInicio);
    $result->bindParam("fechaFinal", $fechaFinal);
    $result->execute();
    $reports = $result->fetchAll(PDO::FETCH_ASSOC);
}

include 'index.php';
?>