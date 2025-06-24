<?php
// src/index.php

echo "<h1>¡Hola desde PHP en Docker con PDO y .env!</h1>";
echo "<h3>Información de PHP:</h3>";
phpinfo();

echo "<h3>Conexión a MySQL:</h3>";

// Obtener variables de entorno
$host = 'mysql'; // nombre del servicio MySQL en docker-compose
$db   = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<p>¡Conexión exitosa a la base de datos MySQL con PDO!</p>";

    // Ejemplo: Crear una tabla si no existe
    $sql_create_table = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql_create_table);
    echo "<p>Tabla 'users' creada o ya existe.</p>";

    // Ejemplo: Insertar datos
    $name = "Juan Perez";
    $email = "juan.perez@example.com";
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    try {
        $stmt->execute([$name, $email]);
        echo "<p>Usuario '{$name}' insertado (o ya existía si email es único).</p>";
    } catch (PDOException $e) {
        // Manejar error de duplicado si email es UNIQUE
        if ($e->getCode() == 23000) {
            echo "<p>El usuario '{$name}' (con email '{$email}') ya existe.</p>";
        } else {
            throw $e; // Re-lanzar otros errores
        }
    }


    // Ejemplo: Seleccionar datos
    echo "<h4>Usuarios en la base de datos:</h4>";
    $stmt = $pdo->query("SELECT id, name, email, created_at FROM users ORDER BY id DESC LIMIT 5");
    $users = $stmt->fetchAll();

    if (count($users) > 0) {
        echo "<ul>";
        foreach ($users as $user) {
            echo "<li>ID: " . htmlspecialchars($user['id']) . " - Nombre: " . htmlspecialchars($user['name']) . " - Email: " . htmlspecialchars($user['email']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay usuarios en la tabla.</p>";
    }


} catch (PDOException $e) {
    die("Error de conexión o base de datos: " . $e->getMessage());
}
?>
