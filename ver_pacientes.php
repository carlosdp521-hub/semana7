<?php
// ver_pacientes.php - Página para ver todos los pacientes registrados.
session_start();
require_once 'db.php';

// Comentario: Verifica si el usuario ha iniciado sesión como administrador.
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: acceso_administrativo.php");
    exit();
}

$pacientes = []; // Array para almacenar los datos de los pacientes.
$mensaje = "";

try {
    $database = new Database();
    $conn = $database->conn;

    // Comentario: Prepara y ejecuta la consulta SQL para obtener todos los pacientes.
    $sql = "SELECT * FROM pacientes ORDER BY fecha_registro DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Comentario: Obtiene todos los resultados como un array asociativo.
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($pacientes) === 0) {
        $mensaje = "<div class='message info'>No hay pacientes registrados en este momento.</div>";
    }

} catch(PDOException $e) {
    $mensaje = "<div class='message error'>Error al cargar los pacientes: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Pacientes</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        /* Estilos específicos para esta página */
        .table-container {
            width: 100%;
            overflow-x: auto; /* Permite desplazamiento horizontal en pantallas pequeñas */
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
            font-weight: bold;
            color: #495057;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e2e6ea;
        }
        .message.info {
            background-color: #cce5ff;
            color: #004085;
            border-color: #b8daff;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Pacientes Registrados</h2>
    <?php echo $mensaje; ?>

    <?php if (count($pacientes) > 0): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Identificación</th>
                    <th>Sexo</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Motivo de Consulta</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacientes as $paciente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($paciente['id']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['identificacion']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['sexo']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['correo']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['motivo']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['fecha_registro']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <a href="panel_admin.php" class="btn back-link">Volver al Panel</a>
</div>

</body>
</html>