<?php
// Este archivo procesa la información enviada desde el formulario de registro de pacientes.

// Se verifica que los datos se hayan enviado a través del método POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Se sanitizan y se capturan las variables del formulario.
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido = htmlspecialchars($_POST['apellido']);
    $identificacion = htmlspecialchars($_POST['identificacion']);
    $sexo = htmlspecialchars($_POST['sexo']);
    $direccion = htmlspecialchars($_POST['direccion']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $correo = htmlspecialchars($_POST['correo']);
    $motivo_consulta = htmlspecialchars($_POST['motivo_consulta']);

    // En un entorno real, aquí se realizaría la conexión a una base de datos y se insertarían los datos.
    // Por ejemplo:
    // $conexion = new mysqli("localhost", "usuario", "contraseña", "basedatos");
    // $stmt = $conexion->prepare("INSERT INTO pacientes (nombre, apellido, ...) VALUES (?, ?, ...)");
    // $stmt->bind_param("sss...", $nombre, $apellido, ...);
    // $stmt->execute();
    // $stmt->close();
    // $conexion->close();

    // Mensaje de confirmación para el usuario.
    echo "<!DOCTYPE html>
          <html lang='es'>
          <head>
              <meta charset='UTF-8'>
              <title>Registro Exitoso</title>
              <style>
                  body { font-family: Arial, sans-serif; background-color: #e6f7ff; text-align: center; padding-top: 50px; }
                  .message-box { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 20px; border-radius: 5px; max-width: 500px; margin: auto; }
              </style>
          </head>
          <body>
              <div class='message-box'>
                  <h2>¡Registro Exitoso! ✅</h2>
                  <p>El paciente " . $nombre . " " . $apellido . " ha sido registrado correctamente.</p>
                  <p>Su identificación es: " . $identificacion . "</p>
                  <a href='registro_paciente.html'>Volver al formulario de registro</a>
              </div>
          </body>
          </html>";
} else {
    // Si se accede directamente al archivo sin un POST, se redirige al formulario.
    header("Location: registro_paciente.html");
    exit();
}
?>