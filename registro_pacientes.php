<?php
// registro_pacientes.php - Formulario y lógica para el registro de pacientes.
require_once 'db.php'; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellido = htmlspecialchars(trim($_POST['apellido']));
    $identificacion = htmlspecialchars(trim($_POST['identificacion']));
    $sexo = htmlspecialchars($_POST['sexo']);
    $direccion = htmlspecialchars(trim($_POST['direccion']));
    $telefono = htmlspecialchars(trim($_POST['telefono']));
    $correo = htmlspecialchars(trim($_POST['correo']));
    $motivo = htmlspecialchars(trim($_POST['motivo']));

    if (empty($nombre) || empty($apellido) || empty($identificacion) || empty($sexo) || empty($direccion) || empty($telefono) || empty($correo) || empty($motivo)) {
        $message = "<div class='message error'>Todos los campos son obligatorios.</div>";
    } else {
        try {
            $database = new Database();
            $conn = $database->conn;
            
            $sql = "INSERT INTO pacientes (nombre, apellido, identificacion, sexo, direccion, telefono, correo, motivo) VALUES (:nombre, :apellido, :identificacion, :sexo, :direccion, :telefono, :correo, :motivo)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':identificacion', $identificacion);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':motivo', $motivo);

            if ($stmt->execute()) {
                $message = "<div class='message success'>¡Registro exitoso! 🎉</div>";
            } else {
                $message = "<div class='message error'>Error al registrar el paciente.</div>";
            }
        } catch(PDOException $e) {
            $message = "<div class='message error'>Error de base de datos: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Pacientes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="form-container">
    <h2>Formulario de Registro de Pacientes</h2>
    <?php echo $message; ?>
    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
        <label for="identificacion">Identificación:</label>
        <input type="text" id="identificacion" name="identificacion" required>
        <label>Sexo:</label>
        <div class="radio-group">
            <input type="radio" id="sexo_m" name="sexo" value="masculino" required>
            <label for="sexo_m">Masculino</label>
            <input type="radio" id="sexo_f" name="sexo" value="femenino">
            <label for="sexo_f">Femenino</label>
        </div>
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required>
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <label for="motivo">Motivo de la consulta:</label>
        <textarea id="motivo" name="motivo" rows="4" required></textarea>
        <button type="submit">Registrar Paciente</button>
    </form>
</div>

</body>
</html>