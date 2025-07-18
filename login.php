<?php
//Iniciamos la sesión y comprobamos que el usuario se ha identificado
session_start();
$xmlPath = 'files/usuarios.xml';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $email = $_GET['email'];
    $usuarios = simplexml_load_file($xmlPath);

    $index = 0;
    foreach ($usuarios->usuario as $usuario) {
        if ((string)$usuario['email'] === $email) {
            if ((string)$usuario->password === $_GET['password']) {
                $_SESSION["id"] = (string)$usuario["id"];
                $_SESSION["email"] = (string)$usuario["email"];
                $_SESSION["nombre"] = (string)$usuario->nombre;
                $_SESSION["tipo"] = (string)$usuario->tipo;
                header("Location: index.php");
            }
        }
        $index++;
    }
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
        <div class="container py-5">

            <h2 class="mb-4">Iniciar Sesión</h2>
            <form action="" method="get" class="bg-white p-4 shadow rounded mb-5">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Entrar</button>
            </form>

            <!-- JS de Bootstrap y DataTables -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
