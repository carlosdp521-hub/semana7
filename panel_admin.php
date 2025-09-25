<?php
// panel_admin.php - Panel de administración mejorado con menú de navegación.
session_start();

// Comentario: Verifica si el usuario ha iniciado sesión. Si no, lo redirige al login.
if (!isset($_SESSION['usuario'])) {
    header("Location: acceso_administrativo.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Clínica El Bienestar</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        /* Estilos específicos para este panel */
        body {
            background-color: #f8f9fa; /* Fondo más claro */
        }
        .container {
            max-width: 900px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            font-size: 2rem;
            margin: 0;
        }
        .header .user-info {
            font-size: 1.1rem;
            color: #6c757d;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            background-color: #f1f5f9;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .card h3 {
            margin-top: 0;
            color: #343a40;
        }
        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .card a:hover {
            background-color: #0056b3;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Panel de Administración</h1>
        <div class="user-info">
            Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong> | <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card">
            <h3>Gestión de Usuarios</h3>
            <p>Crear nuevos usuarios administradores de forma segura.</p>
            <a href="crear_admin.php">Crear Usuario</a>
        </div>
        <div class="card">
            <h3>Gestión de Pacientes</h3>
            <p>Ver y administrar los registros de pacientes.</p>
            <a href="ver_pacientes.php">Ver Pacientes</a>
        </div>
    </div>

    </div>

</body>
</html>