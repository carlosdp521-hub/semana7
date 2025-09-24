📄 README.md actualizado
# Formulario de Registro en PHP con PDO

Proyecto sencillo en **PHP + MySQL (XAMPP)** que permite registrar usuarios en una base de datos.

## 🚀 Requisitos
- [XAMPP](https://www.apachefriends.org/es/index.html) o un servidor con PHP y MySQL
- PHP 7.4+ (o superior)
- MySQL/MariaDB

## 📂 Estructura del proyecto


/proyecto_php
│── index.php
│── Formulario.php
│── procesar_registro.php
│── config.php
│── README.md


## ⚙️ Configuración
1. Clona este repositorio o copia los archivos a tu carpeta `htdocs` de XAMPP:
   ```bash
   git clone https://github.com/carlosdp521-hub/semana7.git


Crea la base de datos en phpMyAdmin o desde consola:

CREATE DATABASE tu_base_datos;
USE tu_base_datos;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


Edita el archivo config.php si usas credenciales distintas a:

$username = "root";
$password = "";
$dbname   = "tu_base_datos";


Abre en tu navegador:

http://localhost/proyecto_php/

📝 Uso

Ingresa un nombre, correo y contraseña en el formulario.

El sistema guardará los datos en la tabla usuarios usando PDO y password_hash.

🔒 Seguridad

Contraseñas encriptadas con password_hash().

Consultas seguras con PDO::prepare() para evitar SQL Injection.

📌 Autor

Creado por Carlos Di Piazza ✨
Repositorio: https://github.com/carlosdp521-hub/semana7


---

👉 ¿Quieres que actualice el **ZIP final** otra vez con este README ya corregido y el link de tu repo?
