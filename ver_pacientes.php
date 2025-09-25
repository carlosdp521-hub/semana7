<?php
// ver_pacientes.php - Página para ver pacientes con búsqueda y paginación.
session_start();
require_once 'db.php';

// Comentario: Verifica si el usuario ha iniciado sesión como administrador.
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: acceso_administrativo.php");
    exit();
}

// Variables para paginación
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

$search_query = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';
$where_clause = '';
$params = [];

// Si hay una consulta de búsqueda, construir la cláusula WHERE.
if (!empty($search_query)) {
    $where_clause = " WHERE nombre LIKE :search OR apellido LIKE :search OR identificacion LIKE :search OR correo LIKE :search";
    $params[':search'] = '%' . $search_query . '%';
}

$pacientes = [];
$total_records = 0;
$message = "";

try {
    $database = new Database();
    $conn = $database->conn;

    // Obtener el número total de registros para la paginación.
    $sql_count = "SELECT COUNT(*) FROM pacientes" . $where_clause;
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->execute($params);
    $total_records = $stmt_count->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);

    // Consulta principal para obtener los datos de los pacientes.
    $sql = "SELECT * FROM pacientes" . $where_clause . " ORDER BY fecha_registro DESC LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':limit', $records_per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    // Bind the search parameters if they exist.
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val);
    }
    $stmt->execute();
    
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($total_records === 0) {
        $message = "<div class='message info'>No se encontraron pacientes que coincidan con su búsqueda.</div>";
    }

} catch(PDOException $e) {
    $message = "<div class='message error'>Error al cargar los pacientes: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Pacientes</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
            word-wrap: break-word; /* Evita que el texto largo desborde la celda */
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
        .back-link, .search-form, .pagination {
            margin-top: 20px;
        }
        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 4px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }
        .pagination .current-page {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Pacientes Registrados</h2>
    <a href="panel_admin.php" class="btn">Volver al Panel</a>
    
    <form class="search-form" method="get" action="">
        <input type="text" name="search" placeholder="Buscar por nombre, ID o correo..." value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit" class="btn">Buscar</button>
    </form>

    <?php echo $message; ?>

    <?php if (count($pacientes) > 0): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Identificación</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacientes as $paciente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($paciente['id']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['identificacion']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['correo']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['fecha_registro']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php if ($total_pages > 1): ?>
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?>">Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?>" class="<?php echo ($i === $page) ? 'current-page' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?>">Siguiente</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <?php endif; ?>
    
</div>

</body>
</html>