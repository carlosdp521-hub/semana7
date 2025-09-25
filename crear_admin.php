<?php
// crear_admin.php - Lógica para crear un nuevo usuario administrador.
session_start();
require_once 'db.php';

// Comentario: Se asegura que solo un administrador autenticado pueda ver esta página.
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: acceso_administrativo.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_usuario = htmlspecialchars(trim($_POST['usuario']));
    $nueva_clave = htmlspecialchars($_POST['clave']);

    if (empty($nuevo_usuario) || empty($nueva_clave)) {
        $mensaje = "<div class='message error'>El usuario y la clave son obligatorios.</div>";
    } else if (strlen($nuevo_usuario) > 10 || !ctype_upper($nuevo_usuario)) {
        $mensaje = "<div class='message error'>El usuario debe tener un máximo de 10 caracteres y estar en mayúsculas.</div>";
    } else if (strlen($nueva_clave) < 8 || !ctype_lower($nueva_clave)) {
        $mensaje = "<div class='message error'>La clave debe tener un mínimo de 8 caracteres y estar en minúsculas.</div>";
    } else {
        try {
            $database = new Database();
            $conn = $database->conn;
            $stmt_check = $conn->prepare("SELECT COUNT(*) FROM administradores WHERE usuario = :usuario");
            $stmt_check->bindParam(':usuario', $nuevo_usuario);
            $stmt_check->execute();

            if ($stmt_check->fetchColumn() > 0) {
                $mensaje = "<div class='message error'>El nombre de usuario ya existe.</div>";
            } else {
                $clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);
                $sql = "INSERT INTO administradores (usuario, clave_hash) VALUES (:usuario, :clave_hash)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':usuario', $nuevo_usuario);
                $stmt->bindParam(':clave_hash', $clave_hash);

                if ($stmt->execute()) {
                    $mensaje = "<div class='message success'>Usuario administrador creado con éxito. ✅</div>";
                } else {
                    $mensaje = "<div class='message error'>Error al crear el usuario.</div>";
                }
            }
        } catch(PDOException $e) {
            $mensaje = "<div class='message error'>Error de base de datos: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario Administrador</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="form-container">
    <h2>Crear Usuario Administrador</h2>
    <?php echo $mensaje; ?>
    <form action="" method="post">
        <label for="usuario">Nuevo Usuario:</label>
        <input type="text" id="usuario" name="usuario" maxlength="10" required>
        <small>Máximo 10 caracteres, en mayúscula.</small>
        <label for="clave">Nueva Clave:</label>
        <input type="password" id="clave" name="clave" minlength="8" required>
        <small>Mínimo 8 caracteres, en minúscula.</small>
        <button type="submit">Crear Usuario</button>
    </form>
    <p><a href="panel_admin.php">Volver al Panel de Administración</a></p>
</div>

</body>
</html>