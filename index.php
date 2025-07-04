<?php
$host = 'localhost';
$db   = 'sitios_alumnos';
$user = 'alumnos';
$pass = 'alumnopass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    $stmt = $pdo->query("SELECT * FROM alumnos ORDER BY comision, apellido");

    echo "<h1>Listado de Alumnos</h1>";
    echo "<table border='1' cellpadding='6'>";
    echo "<thead><tr><th>ID</th><th>Comisión</th><th>Apellido</th><th>Nombre</th><th>Email</th></tr></thead>";
    echo "<tbody>";
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['comision']}</td>";
        echo "<td>{$row['apellido']}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td><a href='mailto:{$row['email']}'>{$row['email']}</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";

} catch (PDOException $e) {
    echo "<h2>Error de conexión a la base de datos:</h2>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
?>
