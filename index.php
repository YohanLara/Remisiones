<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    
<?php
$conexion=new mysqli("localhost","pointeri_kevin","Klara2023","pointeri_formulario");
$conexion->set_charset("utf8");    
?>
 
<style>
    h1, h2, h3, h4 {
        font-size: 30px;
        text-align: center;
     
    }
</style>

 <?php
include "controlador/insertcode.php";    
?>

<!--  obtiene el ID del formulario desde la URL -->
<?php $id = isset($_GET['id_formulario']) ? $_GET['id_formulario'] : ''; ?>

   

    <style>
    /* Estilos para la imagen */
    .imagen-superior-izquierda {
        object-fit: cover;
        top: 0;
        left: 100;
        width:100%; /* ajusta el ancho según necesites */
        height: 120px; /* altura automática para mantener la proporción */
    }
</style>



<!-- HTML del formulario con la imagen -->
<form id="formulario" action="" class="row g-3" style="max-width: 1000px; margin: 0 auto; position: relative;" method="post" autocomplete="off">
    <img src="fpdf/Pi.jpg" alt="imagen-superior-izquierda" class="imagen-superior-izquierda">
    <h4> FORMULARIO DE REMISION</h4>

    <h1> DATOS DEL CLIENTE</h1>

    <div class="col-md-5 campo-delgado">
        <label for="empresa" class="form-label">Empresa</label>
        <input type="text" class="form-control" name="empresa" id="empresa">
    </div>

    <div class="col-md-3 campo-delgado">
        <label for="municipio" class="form-label">Municipio</label>
        <input type="text" class="form-control" name="municipio" id="municipio">
    </div>

    <div class="col-md-4 campo-delgado">
        <label for="pozo" class="form-label">Pozo</label>
        <input type="text" class="form-control" name="pozo" id="pozo">
    </div>

    <div class="col-4 campo-delgado">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" class="form-control" name="fecha" id="fecha">
    </div>

    <div class="col-4 campo-delgado">
        <label for="solicitado_por" class="form-label">Solicitado Por:</label>
        <input type="text" class="form-control" name="solicitado_por" id="solicitado_por">
    </div>

    <div class="col-md-4 campo-delgado">
        <label for="rig" class="form-label">RIG</label>
        <input type="text" class="form-control" name="rig" id="rig">
    </div>
   
    <!-- Datos del ítem -->
    <div class="col-md-1 campo-delgado">
        <label for="item" class="form-label"><span>Item</span></label>
        <input type="text" class="form-control" name="item[]">
    </div>
    <div class="col-md-1 campo-delgado">
        <label for="cantidad" class="form-label"><span>Cantidad</span></label>
        <input type="text" class="form-control" name="cantidad[]">
    </div>
    <div class="col-md-3 campo-delgado">
        <label for="referencia" class="form-label"><span>Referencia</span></label>
        <input type="text" class="form-control" name="referencia[]">
    </div>
    <div class="col-md-7 campo-delgado">
        <label for="descripcion" class="form-label"><span>Descripcion</span></label>
        <input type="text" class="form-control" name="descripcion[]">
    </div>
   
    <button id="adicional" name="adicional" type="button" class="btn" style="background-color: rgb(42, 47, 134); color: white;" onclick="agregarCampos()"> Más Campos + </button>
    <button type="button" class="btn" style="background-color: rgb(134, 197, 237); color: white;" onclick="eliminarFila(this)">Menos Campos -</button>
    




    <!-- Datos del transporte -->
    <h2>DATOS DEL TRANSPORTE</h2>
    <div class="col-md-6 campo-delgado">
        <label for="transporte_empresa" class="form-label">Empresa </label>
        <input type="text" class="form-control" name="transporte_empresa" id="transporte_empresa">
    </div>
    <div class="col-md-6 campo-delgado">
        <label for="conductor" class="form-label">Conductor</label>
        <input type="text" class="form-control" name="conductor" id="conductor">
    </div>
    <div class="col-md-6 campo-delgado">
        <label for="cedula_conductor" class="form-label">Cedula</label>
        <input type="text" class="form-control" name="cedula_conductor" id="cedula_conductor">
    </div>
    <div class="col-md-6 campo-delgado">
        <label for="celular_conductor" class="form-label">Celular</label>
        <input type="text" class="form-control" name="celular_conductor" id="celular_conductor">
    </div>

    <!-- Datos del vehículo -->
    <h3>DATOS DEL VEHICULO</h3>
    <div class="col-md-6 campo-delgado">
        <label for="vehiculo_placa" class="form-label">Placa</label>
        <input type="text" class="form-control" name="vehiculo_placa" id="vehiculo_placa">
    </div>

    <div class="col-md-6 campo-delgado">
        <label for="vehiculo_tipo" class="form-label">Tipo</label>
        <input  type="text" class="form-control" name="vehiculo_tipo" id="vehiculo_tipo">
    </div>

    <div class="col-md-12 ">
  <label for="observaciones">Observaciones</label>
  <textarea class="form-control" name="observaciones" id="observaciones" rows="3" style="border: 1px solid black;"></textarea>
</div>

    <!-- <input type="text" name="id_formulario" value="<?php echo $id_formulario; ?>"> -->
    <div class="col-8">
    <button type="submit" name="insertar" id="insertar" style = "background-color: rgb(72, 109, 178); color: white;"  " class="btn btn-success">Insertar Datos</button>
    </div>
</form>

<!-- ******************************************************************************************** -->
<script>
    function agregarCampos() {
        var container = $("form");
        // Construir la nueva fila dinámicamente
        var nuevaFila = $('<div class="row g-3"></div>').append(
            '<div class="col-md-1 campo-delgado">' +
            '  <label for="item" class="form-label"><span>Item</span></label>' +
            '  <input type="text" class="form-control" name="item[]">' +
            '</div>' +
            '<div class="col-md-1 campo-delgado">' +
            '  <label for="cantidad" class="form-label"><span>Cantidad</span></label>' +
            '  <input type="text" class="form-control" name="cantidad[]">' +
            '</div>' +
            '<div class="col-md-3 campo-delgado">' +
            '  <label for="referencia" class="form-label"><span>Referencia</span></label>' +
            '  <input type="text" class="form-control" name="referencia[]">' +
            '</div>' +
            '<div class="col-md-7 campo-delgado">' +
            '  <label for="descripcion" class="form-label"><span>Descripcion</span></label>' +
            '  <input type="text" class="form-control" name="descripcion[]">' +
            '</div>'
        );

        // Limpiar los valores clonados
        nuevaFila.find('input[type="text"]').val('');

        // Agregar la nueva fila antes del botón "Más +"
        container.find('#adicional').before(nuevaFila);
    }

    function eliminarFila() {
        var container = $("form");

        // Obtener todas las filas clonadas
        var filas = container.find('.row.g-3');

        // Verifica que haya más de una fila antes de eliminar
        if (filas.length > 0) {
            // Eliminar la última fila
            filas.last().remove();
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

