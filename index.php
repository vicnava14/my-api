<?php

// Incluir los archivos necesarios
require_once 'config.php'; // Configuración de la base de datos y otras variables
require_once 'functions.php'; // Funciones útiles para la API

// Obtener la solicitud entrante y dividirla en partes
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

// Obtener el tipo de solicitud (ventas, clientes, inventario, etc.)
$type = array_shift($request);

// Enrutamiento de solicitudes
switch ($type) {
    case 'ventas':
        // Manejar las solicitudes relacionadas con ventas
        require_once 'ventas.php';
        break;
    case 'clientes':
        // Manejar las solicitudes relacionadas con clientes
        require_once 'clientes.php';
        break;
    case 'inventario':
        // Manejar las solicitudes relacionadas con inventario
        require_once 'inventario.php';
        break;
    default:
        // Respuesta para solicitudes desconocidas
        http_response_code(404);
        echo json_encode(['error' => 'Solicitud no válida']);
}

?>