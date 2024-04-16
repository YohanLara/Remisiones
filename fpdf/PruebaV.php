<?php
require('fpdf.php');
class PDF extends FPDF
{
   // Cabecera de página
   function Header()
   {
      $this->Image('logo_pointer.png', 66, 80, 80, 80); //  
      $this->Image('logo2.png', 120, 5, 80);
      $this->Ln(11); 
      
      // conexion a base de datos
      $conexion=new mysqli("localhost","pointeri_kevin","Klara2023","pointeri_formulario");
      $conexion->set_charset("utf8");    
      
      $id = $_GET['id_formulario'];   

      $consulta_info = $conexion->query(" SELECT * FROM remision_data Where id_formulario = $id");//traemos datos de la empresa desde BD
      $dato_info = $consulta_info->fetch_object();
      
      $this->Image('logo.png', 17, 14, 25);
      $this->SetFont('Arial', '', 8); // Puedes ajustar el tipo de fuente y el tamaño según tus preferencias
      $this->Cell(-1);
      $this->Cell(0, 25, utf8_decode('          NIT. 830.080.201-7'), 0, 0, 'L');
      $this->Ln(1); // Puedes ajustar la distancia entre el texto y otros elementos si es necesario                                         //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      
      $this->Addfont('anton.php','',"anton.php");
      $this->SetFont('anton.php', '',  15);
      $this->Cell(3);
      $this->SetTextColor(42, 47, 134);
      $this->Cell(10, 10, utf8_decode('          REMISIÓN Y/O RECIBO DE MATERIALES'), 0, 1, 0, '', 0);
      $this->SetTextColor(255, 0, 0); // Establecer el color del texto a rojo
      $this->Cell(70);
      $this->Cell(0, 0, utf8_decode("            N0.REM : $dato_info->id_formulario"), 0, 0, 'L', 0, '', 0); // Parte en negro

      $this->Ln(11);
      $this->SetTextColor(0, 0, 0);
     
      /* UBICACION */
      $this->Cell(1);  // mover a la derecha
      $this->SetFont('Arial', '', 9);
      $this->Cell(96, 10, utf8_decode("Fecha : $dato_info->fecha"), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(1);  // mover a la derecha
      $this->SetFont('Arial', '', 9);
      $this->Cell(59, 10, utf8_decode("Empresa : $dato_info->empresa "), 0, 0, '', 0);
      $this->Ln(5);

      /* COREEO */
      $this->Cell(1);  // mover a la derecha
      $this->SetFont('Arial', '', 9);
      $this->Cell(85, 10, utf8_decode("Pozo : $dato_info->pozo "), 0, 0, '', 0);
      $this->Ln(15);

      /* TELEFONO */
      $this->SetXY(115, 45); // Establecer la posición para "Fecha:"
      $this->SetFont('Arial', '', 9);
      $this->Cell(15, 6, utf8_decode ("Solicitado Por: $dato_info->solicitado_por"), 0, '', 0);
      $this->SetXY(128, 48); 
      $this->Ln(5);


      $this->SetXY(115, 50); // Establecer la posición para "Fecha:"
      $this->SetFont('Arial', '', 9);
      $this->Cell(15, 6, utf8_decode  ("Municipio : $dato_info->municipio"), 0,'', 0);
      $this->SetXY(128, 48); 
      $this->Ln(5);


      $this->SetXY(115, 55); 
      $this->SetFont('Arial', '', 9);
      $this->Cell(15, 6, utf8_decode ("RIG : $dato_info->rig "), 0, '',  0);
      $this->SetXY(128, 48); 
      $this->Ln(15);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(42, 47, 134); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      
      $this->SetFont('Arial', 'B', 9);
      $this->Cell(12, 8, utf8_decode('ÍTEM'), 1, 0, 'C', 1);
      $this->Cell(25, 8, utf8_decode('CANTIDAD'), 1, 0, 'C', 1);
      $this->Cell(45, 8, utf8_decode('REFERENCIA O P/N'), 1, 0, 'C', 1);
      $this->Cell(110, 8, utf8_decode('DESCRIPCIÓN'), 1, 1, 'C', 1);
   }
   // Pie de página
   function Footer()
   {
$this->SetY(-28); // Posición: a 1,5 cm del final
$this->SetFont('Arial', 'I', 6); // Tipo de fuente, cursiva, tamañoTexto

// Texto personalizado en el pie de página
$textoPersonalizado = "Calle 73 bis No. 27A-10 Tel.:(571) 311 1857 / 69 Bogota D.C Colombia ventasyservicios@pointerinstrument.com\nOriginal y copia blanca facturación / Copia azul cliente";
$this->MultiCell(0, 3, utf8_decode($textoPersonalizado), 0, 'C');
   }
}

// conexion a base de datos
$conexion=new mysqli("localhost","pointeri_kevin","Klara2023","pointeri_formulario");
$conexion->set_charset("utf8");    


$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$id = $_GET['id_formulario'];
$i = 0;
$pdf->SetFont('Arial', '', 9);
$pdf->SetDrawColor(163, 163, 163);


$consulta = $conexion->query("SELECT * FROM remision_data WHERE id_formulario = $id ");
$remisiones = [];

while ($remision_data = $consulta->fetch_object()) {
    $remisiones[] = $remision_data;
}

// numero de celdas
$numberOfCells = 20;

// Definir el ancho de cada celda
$itemWidth = 12;
$cantidadWidth = 25;
$referenciaWidth = 45;
$descripcionWidth = 110;

// Iterar sobre las remisiones y mostrar los datos en las celdas correspondientes
foreach ($remisiones as $remision) {
    $datos_items = json_decode($remision->items_json);

    // Mostrar datos en las celdas correspondientes
    foreach ($datos_items as $datos_item) {
        $item = $datos_item->item;
        $cantidad = $datos_item->cantidad;
        $referencia = $datos_item->referencia;
        $descripcion = $datos_item->descripcion;

        // Verificar si hay celdas disponibles
        if ($i < $numberOfCells) {
            // Utilizar los valores en el PDF
            $pdf->Cell($itemWidth, 5, utf8_decode($item), 1, 0, 'C', 0);
            $pdf->Cell($cantidadWidth, 5, utf8_decode($cantidad), 1, 0, 'C', 0);
            $pdf->Cell($referenciaWidth, 5, utf8_decode($referencia), 1, 0, 'L', 0);
            $pdf->Cell($descripcionWidth, 5, utf8_decode($descripcion), 1, 1, 'C', 0);
            $i++;
        } 
    }
}

// Completar con celdas vacías si es necesario
while ($i < $numberOfCells) {
    $pdf->Cell($itemWidth, 5, utf8_decode(''), 1, 0, 'C', 0);
    $pdf->Cell($cantidadWidth, 5, utf8_decode(''), 1, 0, 'C', 0);
    $pdf->Cell($referenciaWidth, 5, utf8_decode(''), 1, 0, 'L', 0);
    $pdf->Cell($descripcionWidth, 5, utf8_decode(''), 1, 1, 'C', 0);
    $i++;
}

// Definir el ancho del rectángulo de observaciones
$observacionesRectWidth = 192; // Ancho
$observacionesRectX = 10; // Ajusta según la posición X deseada
$observacionesRectHeight = 20; // Ajusta según la altura deseada

// Dibujar el rectángulo de observaciones debajo de las celdas
$observacionesRectY = $pdf->GetY() + 1; // Posición Y debajo de las celdas
$pdf->Rect($observacionesRectX, $observacionesRectY, $observacionesRectWidth, $observacionesRectHeight, 'D');

$pdf->SetFont('Arial', '', 11);
$pdf->SetXY($observacionesRectX + 0, $observacionesRectY + 3); // Ajustar posición del texto dentro del rectángulo
$pdf->Cell(0, 0, utf8_decode("Observaciones:   $remision->observaciones"), 0, 0, 'L'); // Agrega el texto dentro del rectángulo.



$pdf->SetFont('Arial', 'B', 9);
$pdf->SetXY(42, 188);
$pdf->Cell(25, 25, utf8_decode('Datos del transporte'), 0, 0, 'C');


$pdf->SetXY(15, 184);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 45, utf8_decode("Empresa :               $remision->transporte_empresa"), 0, 0, 'L', 0);
$pdf->Line(42, 208, 106 , 208);  // Ajuste de lineas

$pdf->SetXY(15, 191 );
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 45, utf8_decode("Conductor :             $remision->conductor "), 0, 0, 'L', 0);
$pdf->Line(42, 215, 106, 215);

$pdf->SetXY(15, 198);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 45, utf8_decode("N° de cédula :        $remision->cedula_conductor "), 0, 0, 'L', 0);
$pdf->Line(42, 222, 106, 222);

$pdf->SetXY(15, 205);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 45, utf8_decode("Celular :                  $remision->celular_conductor "), 0, 0, 'L', 0);
$pdf->Line(42, 229, 106, 229);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetXY(145, 188);
$pdf->Cell(25, 25, utf8_decode('Datos del vehículo'), 0, 0, 'C');


$pdf->SetXY(108, 184);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 45, utf8_decode("Placa :          $remision->vehiculo_placa "), 0, 0, 'L', 0);
$pdf->Line(125, 208, 188, 208);


$pdf->SetXY(108, 191);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 45, utf8_decode("Tipo   :          $remision->vehiculo_tipo "), 0, 0, 'L', 0);
$pdf->Line(125, 215, 188, 215);

$pdf->Line(125, 222, 188, 222);

$pdf->SetXY(141, 205);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 45, utf8_decode("Firma del conductor "), 0, 0, 'L', 0);

// Definir el ancho del rectángulo de datos del transporte  y datos del vehiculo
$observacionesRectWidth = 192; // Ancho
$observacionesRectX = 10; // Ajusta según la posición X deseada
$observacionesRectHeight = 40; // Ajusta según la altura deseada

// Dibujar el rectángulo de observaciones debajo de las celdas
$observacionesRectY = $pdf->GetY() + -12; // Posición Y debajo de las celdas
$pdf->Rect($observacionesRectX, $observacionesRectY, $observacionesRectWidth, $observacionesRectHeight, 'D');

// CUADRO(DESPACHADO POR)
$observacionesRectWidth = 64; // Ancho
$observacionesRectX = 10; // Ajusta según la posición X deseada
$observacionesRectHeight = 30; // Ajusta según la altura deseada

// Dibujar el rectángulo de observaciones debajo de las celdas
$observacionesRectY = $pdf->GetY() + 30; // Posición Y debajo de las celdas
$pdf->Rect($observacionesRectX, $observacionesRectY, $observacionesRectWidth, $observacionesRectHeight, 'D');
// Agregar texto centrado en la parte superior del cuadro
$pdf->SetXY($observacionesRectX, $observacionesRectY);
$pdf->Cell($observacionesRectWidth, 5, utf8_decode('Despachado por'), 0, 0, 'C', 0);

// Agregar línea para firmar
$pdf->Line($observacionesRectX + 5, $observacionesRectY + $observacionesRectHeight - 16, $observacionesRectX + $observacionesRectWidth - 5, $observacionesRectY + $observacionesRectHeight - 16);


// CUADRO(AUTORIZADO POR)
$observacionesRectWidth = 62; // Ancho
$observacionesRectX = 76; // Ajusta según la posición X deseada
$observacionesRectHeight = 30; // Ajusta según la altura deseada

// Dibujar el rectángulo de observaciones debajo de las celdas
$observacionesRectY = $pdf->GetY() - 0; // Posición Y debajo de las celdas
$pdf->Rect($observacionesRectX, $observacionesRectY, $observacionesRectWidth, $observacionesRectHeight, 'D');
$pdf->SetXY($observacionesRectX, $observacionesRectY);
$pdf->Cell($observacionesRectWidth, 5, utf8_decode('Autorizado por'), 0, 0, 'C', 0);

// Agregar línea para firmar
$pdf->Line($observacionesRectX + 5, $observacionesRectY + $observacionesRectHeight - 16, $observacionesRectX + $observacionesRectWidth - 5, $observacionesRectY + $observacionesRectHeight - 16);


// CUADRO(RECIBIDO POR)
$observacionesRectWidth = 62; // Ancho
$observacionesRectX = 140; // Ajusta según la posición X deseada    
$observacionesRectHeight = 30; // Ajusta según la altura deseada

$observacionesRectY = $pdf->GetY() - 0; // Posición Y debajo de las celdas
$pdf->Rect($observacionesRectX, $observacionesRectY, $observacionesRectWidth, $observacionesRectHeight, 'D');
$pdf->SetXY($observacionesRectX, $observacionesRectY);
$pdf->Cell($observacionesRectWidth, 5, utf8_decode('Recibido por'), 0, 0, 'C', 0);
// Agregar texto debajo de la línea [CORRESPONDE A RECIBIDO POR]
// Agregar línea para firmar
$pdf->Line($observacionesRectX + 5, $observacionesRectY + $observacionesRectHeight - 16, $observacionesRectX + $observacionesRectWidth - 5, $observacionesRectY + $observacionesRectHeight - 16);

//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
// Agregar texto debajo de la línea [CORRESPONDE A DESPACHADO POR]
$pdf->SetY($observacionesRectY + $observacionesRectHeight - 14); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX - 126); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 0, utf8_decode('Firma'), 0, 0, 'L', 0);

$pdf->SetY($observacionesRectY + $observacionesRectHeight - 10); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX - 126); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 0, utf8_decode('Nombre'), 0, 0, 'L', 0);

$pdf->SetY($observacionesRectY + $observacionesRectHeight - 10); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX - 126); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 8, utf8_decode('C.C.'), 0, 0, 'L', 0);
//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
// Agregar texto debajo de la línea [CORRESPONDE A AUTORIZADO POR]
$pdf->SetY($observacionesRectY + $observacionesRectHeight - 14); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX - 60); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 0, utf8_decode('Firma'), 0, 0, 'L', 0);

$pdf->SetY($observacionesRectY + $observacionesRectHeight - 10); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX - 60); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 0, utf8_decode('Nombre'), 0, 0, 'L', 0);

$pdf->SetY($observacionesRectY + $observacionesRectHeight - 10); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX - 60); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 8, utf8_decode('C.C.'), 0, 0, 'L', 0);
//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

//CORRESPONDE A (RECIBIDO POR)
// Agregar texto debajo de la línea
$pdf->SetY($observacionesRectY + $observacionesRectHeight - 14); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX + 5); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 0, utf8_decode('Firma'), 0, 0, 'L', 0);

$pdf->SetY($observacionesRectY + $observacionesRectHeight - 10); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX + 5); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 0, utf8_decode('Nombre'), 0, 0, 'L', 0);

$pdf->SetY($observacionesRectY + $observacionesRectHeight - 10); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX + 5); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 8, utf8_decode('C.C.'), 0, 0, 'L', 0);

$pdf->SetY($observacionesRectY + $observacionesRectHeight - 6); // Ajustar la posición Y debajo de la línea
$pdf->SetX($observacionesRectX + 5); // Ajustar la posición X al lado izquierdo del cuadro
$pdf->SetFontSize(7); // Establecer el tamaño de la letra a 7 puntos
$pdf->Cell(0, 8, utf8_decode('Fecha'), 0, 0, 'L', 0);

$pdf->Output('Remision.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
