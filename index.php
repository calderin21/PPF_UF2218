<?php
//Iniciamos la sesión y comprobamos que el usuario se ha identificado
session_start();
session_regenerate_id(true);

//Comprobamos si hay que cerrar la sesión
if (isset($_REQUEST["sesion"]) && $_REQUEST["sesion"] == "cerrar")
{
    session_destroy();
    header("Location: login.php");
}

//Si no hay sesión de manda al login
if (isset($_SESSION["id"]) == false) {
    header("Location: login.php");
}

$ROL = $_SESSION["tipo"];

$PUEDE = [
    "administrador" => [
        "consultar" => true,
        "buscar" => true,
        "insertar" => true,
        "modificar" => true,
        "eliminar" => true,
    ],
    "consultor" => [
        "consultar" => true,
        "buscar" => true,
        "insertar" => false,
        "modificar" => false,
        "eliminar" => false,
    ],
];

$xmlPath = 'files/coches.xml';
$cars = simplexml_load_file($xmlPath);
if ($editarCocheMatricula = $_GET['matricula'] ?? '') {
    $editarCoche = $cars->xpath("//coche[@matricula='$editarCocheMatricula']")[0];
}

function opcionVenta($valor, $contenido, $coche) {
    return "<option value='$valor' "
        . ($coche->precio["venta"] == $valor ? "selected" : "")
        ." >$contenido</option>";
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Gestión de Coches</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="mt-3 me-5 d-flex justify-content-end">
            <p class="m-2"><?= $_SESSION["tipo"]?></p>
            <p class="m-2">-</p>
            <p class="m-2"><?= $_SESSION["nombre"]?></p>
            <a class="btn btn-danger" title="Cerrar sesión" href="index.php?sesion=cerrar">
                Salir
            </a>
        </div>
        <div class="container py-5">
            <?php if (!$editarCocheMatricula && $PUEDE[$ROL]["modificar"]): ?>

            <h2 class="mb-4">Insertar Nuevo Coche</h2>
            <form action="insertar_coche.php" method="post" class="bg-white p-4 shadow rounded mb-5">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Matrícula</label>
                        <input type="text" name="matricula" class="form-control" required pattern="\d{4}[A-Z]{3}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="modelo" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Puertas</label>
                        <input type="number" name="puertas" class="form-control" required min="2" max="5">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Color</label>
                        <input type="text" name="color" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo de venta</label>
                        <select name="venta" class="form-select" required>
                            <option value="">Selecciona</option>
                            <option value="nuevo">Nuevo</option>
                            <option value="ocasión">Ocasión</option>
                            <option value="segunda mano">Segunda Mano</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Insertar</button>
            </form>

            <?php elseif ($PUEDE[$ROL]["insertar"]): ?>

            <h2 class="mb-4">Editar Coche</h2>
            <form action="editar_coche.php" method="post" class="bg-white p-4 shadow rounded mb-5">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Matrícula</label>
                        <input type="text" name="matricula"
                            class="form-control" readonly
                            value="<?= $editarCoche['matricula'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca"
                            class="form-control" required
                            value="<?= $editarCoche->marca ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="modelo"
                            class="form-control" required
                            value="<?= $editarCoche->modelo ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Puertas</label>
                        <input type="number" name="puertas"
                            class="form-control" required min="2" max="5"
                            value="<?= $editarCoche->puertas ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Color</label>
                        <input type="text" name="color"
                            class="form-control" required
                            value="<?= $editarCoche->color ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio"
                            class="form-control" required
                            value="<?= $editarCoche->precio ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo de venta</label>
                        <select name="venta" class="form-select" required>
                            <?= opcionVenta("", "Selecciona", $editarCoche) ?>
                            <?= opcionVenta("nuevo", "Nuevo", $editarCoche) ?>
                            <?= opcionVenta("ocasión", "Ocasión", $editarCoche) ?>
                            <?= opcionVenta("segunda mano", "Segunda Mano", $editarCoche) ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Guardar cambios</button>
                <a href="index.php" type="button" class="btn btn-secondary mt-4">Cancelar</a>
            </form>

            <?php endif; ?>

            <h2 class="mb-3">Listado de Coches</h2>
            <table id="tabla-coches" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Puertas</th>
                        <th>Color</th>
                        <th>Precio</th>
                        <th>Tipo de Venta</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cars->coche as $coche): ?>

                    <tr>
                        <td><?= $coche['matricula'] ?></td>
                        <td><?= $coche->marca ?></td>
                        <td><?= $coche->modelo ?></td>
                        <td><?= $coche->puertas ?></td>
                        <td><?= $coche->color ?></td>
                        <td><?= $coche->precio ?></td>
                        <td><?= $coche->precio['venta'] ?></td>
                        <td>
                            <?php if ($PUEDE[$ROL]["modificar"]): ?>

                            <form action="" method="get">
                                <input type="hidden" name="matricula" value="<?= $coche['matricula'] ?>">
                                <button type="submit" class="btn btn-secondary btn-sm">Modificar</button>
                            </form>

                            <?php endif; ?>

                            <?php if ($PUEDE[$ROL]["eliminar"]): ?>

                            <form action="eliminar_coche.php" method="post" onsubmit="return confirm('¿Estás seguro de eliminar este coche?');">
                                <input type="hidden" name="matricula" value="<?= $coche['matricula'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>

                            <?php endif; ?>
                        </td>
                    </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- JS de Bootstrap y DataTables -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>

        new DataTable('#tabla-coches', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            },
        });

        </script>
    </body>
</html>
