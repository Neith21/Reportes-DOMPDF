<?php
require 'vendor/autoload.php';
include 'conf.php';

use Dompdf\Dompdf;

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

$html = '<div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Existencias</th>
                        <th scope="col">Bodegas</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Vencimiento</th>
                        <th scope="col">Introducción</th>
                    </tr>
                </thead>
                <tbody>';
foreach ($reports as $report) {
    $html .= '<tr>
                <td>' . htmlspecialchars($report['id']) . '</td>
                <td>' . htmlspecialchars($report['producto']) . '</td>
                <td>' . htmlspecialchars($report['proveedor']) . '</td>
                <td>' . htmlspecialchars($report['existencias']) . '</td>
                <td>' . htmlspecialchars($report['bodegas']) . '</td>
                <td>' . htmlspecialchars($report['precio']) . '</td>
                <td>' . htmlspecialchars($report['vencimiento']) . '</td>
                <td>' . htmlspecialchars($report['introduccion']) . '</td>
              </tr>';
}
$html .= '        </tbody>
            </table>
        </div>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$archivo = 'Reporte_' . date('Ymd_His') . '.pdf';
$dompdf->stream($archivo);

?>