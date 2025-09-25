<?php
// insert_admin.php - Securely inserts a new admin user.
require_once 'db.php'; // Ensures the database connection is available.

// Define the username and plaintext password you want to create.
$username = "ADMIN123";
$password_plain = "contraseña1";

// Create a secure hash of the password.
// PASSWORD_DEFAULT is the best option as it uses the strongest available algorithm.
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

try {
    // Create a new database connection object.
    $database = new Database();
    $conn = $database->conn;
    
    // Prepare a SQL statement to prevent SQL injection attacks.
    $sql = "INSERT INTO administradores (usuario, clave_hash) VALUES (:usuario, :clave_hash)";
    $stmt = $conn->prepare($sql);
    
    // Bind the parameters to the statement.
    $stmt->bindParam(':usuario', $username);
    $stmt->bindParam(':clave_hash', $password_hash);
    
    // Execute the statement.
    if ($stmt->execute()) {
        echo "Admin user **'$username'** has been created successfully. ✅";
    } else {
        echo "Error creating the admin user.";
    }
} catch(PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>