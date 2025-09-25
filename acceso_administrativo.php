<?php
// acceso_administrativo.php - Módulo de acceso administrativo con autenticación segura.
session_start();
require_once 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    try {
        $database = new Database();
        $conn = $database->conn;

        $sql = "SELECT clave_hash FROM administradores WHERE usuario = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($clave, $resultado['clave_hash'])) {
            $_SESSION['usuario'] = $usuario;
            // Se puede agregar un rol en el futuro, pero por ahora todos los admins tienen el mismo rol.
            $_SESSION['rol'] = 'admin'; 
            header("Location: panel_admin.php"); // Redirige al panel de administración.
            exit();
        } else {
            $message = "<div class='message error'>Usuario o clave incorrectos. 😞</div>";
        }
    } catch(PDOException $e) {
        $message = "<div class='message error'>Error de base de datos: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Administrativo</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="form-container">
    <h2>Acceso Administrativo</h2>
    <?php echo $message; ?>
    <form action="" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" maxlength="10" required>
        <small>Máximo 10 caracteres, en mayúscula.</small>
        
        <label for="clave">Clave:</label>
        <input type="password" id="clave" name="clave" minlength="8" required>
        <small>Mínimo 8 caracteres, en minúscula.</small>
        
        <button type="submit">Acceder</button>
    </form>
</div>

</body>
</html>