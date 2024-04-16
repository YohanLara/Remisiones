<?php
include "modelo/conexion.php";
// Función para obtener el último id_formulario desde la base de datos
function obtenerUltimoIdFormulario($conexion) {
    $query = "SELECT ultimo_id FROM ultimo_id_formulario WHERE id = 0";
    $resultado = $conexion->query($query);

    if ($resultado) {
        $fila = $resultado->fetch_assoc();
        return $fila['ultimo_id'];
    } else {
        // En caso de error, se devuelve un valor predeterminado (1 en este caso)
        return 1;
    }
}
// Función para actualizar el último id_formulario en la base de datos
function actualizarUltimoIdFormulario($conexion, $nuevo_id_formulario) {
    $query = "UPDATE ultimo_id_formulario SET ultimo_id = $nuevo_id_formulario WHERE id = 0";
    $conexion->query($query);
}

// Obtiene el último id_formulario desde la base de datos
$ultimo_id_formulario = obtenerUltimoIdFormulario($conexion);

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertar'])) {

    // Recupera los datos del formulario
    $empresa = $_POST["empresa"];
    $municipio = $_POST["municipio"];
    $pozo = $_POST["pozo"];
    $fecha = $_POST["fecha"];
    $solicitado_por = $_POST["solicitado_por"];
    $rig = $_POST["rig"];
    $transporte_empresa = $_POST["transporte_empresa"];
    $conductor = $_POST["conductor"];
    $cedula_conductor = $_POST["cedula_conductor"];
    $celular_conductor = $_POST["celular_conductor"];
    $vehiculo_placa = $_POST["vehiculo_placa"];
    $vehiculo_tipo = $_POST["vehiculo_tipo"];
    $observaciones = $_POST["observaciones"];

    // Crear un array para almacenar los datos de los ítems
    $items = array();

    // Verifica si se enviaron datos en los campos dinámicos (ítems)
    if (isset($_POST['item']) && is_array($_POST['item'])) {
        $item_count = count($_POST['item']);

        // Iterar sobre los ítems y almacenar en el array
        for ($i = 0; $i < $item_count; $i++) {
            $item = $_POST['item'][$i];
            $cantidad = $_POST['cantidad'][$i];
            $referencia = $_POST['referencia'][$i];
            $descripcion = $_POST['descripcion'][$i];

            $items[] = array(
                'item' => $item,
                'cantidad' => $cantidad,
                'referencia' => $referencia,
                'descripcion' => $descripcion
            );
        }
    }

    // Convertir el array de ítems a formato JSON
    $items_json = json_encode($items);

    // Conectar a la base de datos 
    $conexion = new mysqli('localhost', 'pointeri_kevin', 'Klara2023', 'pointeri_formulario');

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener el último ID insertado automáticamente en remision_data
    $id_formulario = $ultimo_id_formulario + 1;

    // Insertar datos en la tabla principal
    $query = "INSERT INTO remision_data ( id_formulario, empresa, municipio, pozo, fecha, solicitado_por, rig, transporte_empresa, conductor, cedula_conductor, celular_conductor, vehiculo_placa, vehiculo_tipo, observaciones, items_json) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    // Preparar la sentencia
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

        // Actualizar el último id_formulario en la base de datos
        $nuevo_id_formulario = $ultimo_id_formulario + 1;
        actualizarUltimoIdFormulario($conexion, $nuevo_id_formulario);

    // Vincular parámetros
    $stmt->bind_param("issssssssssssss",  $nuevo_id_formulario, $empresa, $municipio, $pozo, $fecha, $solicitado_por, $rig, $transporte_empresa, $conductor, $cedula_conductor, $celular_conductor, $vehiculo_placa, $vehiculo_tipo, $observaciones, $items_json );

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        
        // Cerrar la conexión a la base de datos
        $stmt->close();
        $conexion->close();
       
            // Redireccionar a la página de PDF en una nueva ventana
        echo '<script>window.open("./fpdf/PruebaV.php?id_formulario=' . $nuevo_id_formulario . '", "_self");</script>';

        // echo '<script>
        // window.open("./fpdf/logo.png", "_self");
        // </script>';

        // Redireccionar a remision.php (formulario principal)
        echo '<script>window.location.href = "index.php";</script>';
            exit();
   
    } else {
        echo "Error al insertar datos: " . $stmt->error;
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conexion->close();
}

?>
