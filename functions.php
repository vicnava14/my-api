<?php

// Función para establecer la conexión a la base de datos
function get_db_connection() {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($connection->connect_error) {
        die("Error de conexión a la base de datos: " . $connection->connect_error);
    }
    return $connection;
}

class Cliente {
    private $id;
    private $nombre;
    private $email;
    private $telefono;
    private $direccion;

    public function __construct($id = null) {
        if ($id !== null) {
            $this->cargarClientePorId($id);
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    private function cargarClientePorId($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'clients';

        $cliente = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id),
            ARRAY_A
        );

        if ($cliente) {
            $this->id = $cliente['id'];
            $this->nombre = $cliente['nombre'];
            $this->email = $cliente['email'];
            $this->telefono = $cliente['telefono'];
            $this->direccion = $cliente['direccion'];
        }
    }

    public static function buscarClientePorNombre($nombre) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'clients';

        $cliente = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE nombre = %s", $nombre),
            ARRAY_A
        );

        if ($cliente) {
            return new self($cliente['id']);
        }

        return null;
    }
}

// Ejemplo de uso:
$cliente = Cliente::buscarClientePorNombre('Juan Perez');

if ($cliente) {
    echo 'Cliente encontrado:<br>';
    echo 'ID: ' . $cliente->getId() . '<br>';
    echo 'Nombre: ' . $cliente->getNombre() . '<br>';
    echo 'Email: ' . $cliente->getEmail() . '<br>';
    echo 'Teléfono: ' . $cliente->getTelefono() . '<br>';
    echo 'Dirección: ' . $cliente->getDireccion() . '<br>';
} else {
    echo 'Cliente no encontrado.';
}

class Producto {
    private $id;
    private $nombre;
    private $precio;
    private $cantidad;
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'productos';
    }

    public function buscar_por_id($id) {
        global $wpdb;
        $producto = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $id),
            ARRAY_A
        );
        if ($producto) {
            $this->id = $producto['id'];
            $this->nombre = $producto['nombre'];
            $this->precio = $producto['precio'];
            $this->cantidad = $producto['cantidad'];
        }
        return $producto;
    }
    public function buscar_por_nombre($nombre) {
        global $wpdb;
        $productos = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM $this->table_name WHERE nombre LIKE %s", '%' . $wpdb->esc_like($nombre) . '%'),
            ARRAY_A
        );
        
        return $productos;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    // Otros métodos de la clase Producto...
}
class Pedido {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'pedidos';
    }

    public function buscar_por_id($id) {
        global $wpdb;
        $pedido = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $id),
            ARRAY_A
        );
        return $pedido;
    }

    public function buscar_por_cliente($cliente_id) {
        global $wpdb;
        $pedidos = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM $this->table_name WHERE cliente_id = %d", $cliente_id),
            ARRAY_A
        );
        return $pedidos;
    }

    public function crear_pedido($cliente_id, $productos) {
        global $wpdb;
        $data = array(
            'cliente_id' => $cliente_id,
            'productos' => serialize($productos) // Guardar los productos como un array serializado
        );
        $wpdb->insert($this->table_name, $data);
        return $wpdb->insert_id; // Devolver el ID del pedido recién creado
    }
}
// Otras funciones útiles...

?>