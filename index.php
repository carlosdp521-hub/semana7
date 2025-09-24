<?php
// Se incluye la clase Formulario. Esto "conecta" el constructor (la clase) con el script principal.
require_once 'Formulario.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formularios con Constructor</title>
</head>
<body>
    <h2>Formulario de Registro de Pacientes (con Constructor)</h2>
    <?php
    // Se crea una nueva instancia de la clase Formulario, llamando implícitamente al constructor __construct().
    $formularioPaciente = new Formulario('procesar_registro.php', 'POST');
    // Se agregan los campos al formulario utilizando los métodos de la clase.
    $formularioPaciente->agregarCampo('Nombre', 'text', 'nombre', true);
    $formularioPaciente->agregarCampo('Apellido', 'text', 'apellido', true);
    $formularioPaciente->agregarCampo('Identificación', 'text', 'identificacion', true);
    $formularioPaciente->agregarSelect('Sexo', 'sexo', ['' => 'Seleccione...', 'masculino' => 'Masculino', 'femenino' => 'Femenino', 'otro' => 'Otro'], true);
    $formularioPaciente->agregarTextarea('Dirección', 'direccion', 3, true);
    $formularioPaciente->agregarCampo('Teléfono', 'tel', 'telefono', true);
    $formularioPaciente->agregarCampo('Correo Electrónico', 'email', 'correo', true);
    $formularioPaciente->agregarTextarea('Motivo de la Consulta', 'motivo_consulta', 4, true);

    // Se genera y se imprime el formulario HTML.
    echo $formularioPaciente->generarFormulario();
    ?>
    
    <h2>Formulario de Acceso para Administrativos (con Constructor)</h2>
    <?php
    // Se crea otra instancia para el formulario de acceso.
    $formularioLogin = new Formulario('procesar_login.php', 'POST');
    // Se agregan los campos de usuario y contraseña.
    $formularioLogin->agregarCampo('Usuario', 'text', 'usuario', true);
    $formularioLogin->agregarCampo('Contraseña', 'password', 'clave', true);

    // Se genera y se imprime el formulario HTML.
    echo $formularioLogin->generarFormulario();
    ?>
</body>
</html>