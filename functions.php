<?php

// Función para establecer la conexión a la base de datos
function get_db_connection() {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($connection->connect_error) {
        die("Error de conexión a la base de datos: " . $connection->connect_error);
    }
    return $connection;
}

// Otras funciones útiles...

?>