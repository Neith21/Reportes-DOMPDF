<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body class="container py-4">
    <h1 class="mb-4">Generar Reportes</h1>

    <div class="mb-3">
        <label for="filterSelector" class="form-label">Seleccione un filtro:</label>
        <select id="filterSelector" class="form-select">
            <option value="" selected>Seleccione un filtro...</option>
            <option value="form-product-provider">Filtrar por Producto o Proveedor</option>
            <option value="form-price-range">Filtrar por Rango de Precios</option>
        </select>
    </div>

    <!-- Formulario 1: Filtrar por Producto o Proveedor -->
    <div id="form-product-provider" class="form-section hidden">
        <h3>Filtrar por Producto o Proveedor</h3>
        <hr>
        <form action="listar.php" method="POST" class="mb-4">
            <input name="opcion" value="1" hidden>
            <div class="mb-3">
                <label for="producto" class="form-label">Producto</label>
                <input type="text" class="form-control" id="producto" name="producto" placeholder="Ingrese producto">
            </div>
            <div class="mb-3">
                <label for="proveedor" class="form-label">Proveedor</label>
                <input type="text" class="form-control" id="proveedor" name="proveedor" placeholder="Ingrese proveedor">
            </div>
            <input type="submit" value="Buscar" class="btn btn-primary">
        </form>
    </div>

    <!-- Formulario 2: Filtrar por Rango de Precios -->
    <div id="form-price-range" class="form-section hidden">
        <h3>Filtrar por Rango de Fechas de Vencimientos</h3>
        <hr>
        <form action="listar.php" method="POST" class="mb-4">
            <input name="opcion" value="2" hidden>
            <div class="mb-3">
                <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" placeholder="Ingrese fecha de inicio">
            </div>
            <div class="mb-3">
                <label for="fechaFinal" class="form-label">Fecha Final</label>
                <input type="date" class="form-control" id="fechaFinal" name="fechaFinal" placeholder="Ingrese fecha final">
            </div>
            <input type="submit" value="Buscar" class="btn btn-primary">
        </form>
    </div>

    <?php if (isset($reports) && !empty($reports)): ?>
        <div class="card mt-5 p-4">
            <h2 class="mb-4">Lista de reportes</h2>
            <div class="d-flex justify-content-between mb-3">
                <form action="generar.php" method="POST" class="d-inline">
                    <input type="hidden" name="opcion" value="<?= htmlspecialchars($opcion); ?>">
                    <input type="hidden" name="producto" value="<?= htmlspecialchars($producto); ?>">
                    <input type="hidden" name="proveedor" value="<?= htmlspecialchars($proveedor); ?>">
                    <input type="hidden" name="fechaInicio" value="<?= htmlspecialchars($fechaInicio); ?>">
                    <input type="hidden" name="fechaFinal" value="<?= htmlspecialchars($fechaFinal); ?>">
                    <button type="submit" class="btn btn-success">Crear Reporte</button>
                </form>
            </div>
            <div class="table-responsive">
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
                    <tbody>
                        <?php foreach ($reports as $report): ?>
                            <tr>
                                <td><?= htmlspecialchars($report['id']); ?></td>
                                <td><?= htmlspecialchars($report['producto']); ?></td>
                                <td><?= htmlspecialchars($report['proveedor']); ?></td>
                                <td><?= htmlspecialchars($report['existencias']); ?></td>
                                <td><?= htmlspecialchars($report['bodegas']); ?></td>
                                <td><?= htmlspecialchars($report['precio']); ?></td>
                                <td><?= htmlspecialchars($report['vencimiento']); ?></td>
                                <td><?= htmlspecialchars($report['introduccion']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <script>
        $(document).ready(function() {
            $('#filterSelector').change(function() {
                var selectedForm = $(this).val();
                $('.form-section').addClass('hidden'); // Ocultar todos los formularios
                $('#' + selectedForm).removeClass('hidden'); // Mostrar el formulario seleccionado
            });
        });
    </script>
</body>

</html>