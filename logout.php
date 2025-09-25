<?php
// logout.php - Script para cerrar la sesión del usuario.
session_start();
session_unset();
session_destroy();
header("Location: acceso_administrativo.php"); // Redirige al formulario de login.
exit();
?>