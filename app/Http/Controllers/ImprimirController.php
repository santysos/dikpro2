<?php

namespace App\Http\Controllers;

use DB;
use Fpdf;

class ImprimirController extends Controller
{
    public function reportec($id)
    {
        header('Content-Type: text/html; charset=utf-8');
        //Obtengo los datos

        $orden = DB::table('tb_ordenes as ord')
            ->join('tb_cliente as cli', 'ord.id_tb_cliente', '=', 'cli.id_tb_cliente')
            ->join('users as us', 'us.id', '=', 'ord.agente')
            ->select('ord.entrega_domicilio', 'ord.id_tb_ordenes', 'ord.Fecha_de_Inicio', 'ord.Fecha_de_Entrega', 'ord.Revision_de_Diseno', 'ord.Total_Venta', 'ord.IVA', 'ord.Abono', 'ord.Observaciones', 'cli.id_tb_cliente', 'cli.Cliente_Nombre_Comercial', 'cli.Contacto_Razon_Social', 'cli.Cedula_Ruc', 'cli.Email', 'us.name', 'cli.Telefono')
            ->where('ord.id_tb_ordenes', '=', $id)
            ->first();

        $detalles = DB::table('tb_detalle_orden as do')
            ->join('tb_descripcion_servicios as ds', 'ds.id_tb_descripcion_servicios', '=', 'do.id_tb_descripcion_servicios')
            ->join('tb_servicios as ser', 'ser.id_tb_Servicios', '=', 'ds.id_tb_Servicios')
            ->select('ds.Productos', 'ser.Servicio', 'do.cantidad', 'do.Valor_Unitario', 'do.Descripcion')
            ->where('do.id_tb_ordenes', '=', $id)
            ->orderby('do.id_do', 'desc')
            ->get();

        Fpdf::AddPage('P', 'A4');
        Fpdf::SetAutoPageBreak('0', '0.1');
        Fpdf::SetFont('Arial', 'B', 14);





        //Datos IMAGENES
        Fpdf::Image('http://dikpro.dikapsa.com/public/img/barra.jpg', 0, 0, 590);
        Fpdf::Image('http://dikpro.dikapsa.com/public/img/logo-dikapsa.jpg', 5, 1);
        Fpdf::Image('http://dikpro.dikapsa.com/public/img/direc.jpg', 68, 5, 100);
        Fpdf::Image('http://dikpro.dikapsa.com/public/img/fon1.jpg', 70, 70, 70);

        //****Datos COMPRADOR
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::SetXY(5, 20);
        Fpdf::Cell(0, 0, utf8_decode('Cliente:  ' . $orden->Cliente_Nombre_Comercial));
        Fpdf::SetXY(5, 25);
        Fpdf::Cell(0, 0, utf8_decode('Contacto:  ' . $orden->Contacto_Razon_Social));
        Fpdf::SetXY(5, 30);
        Fpdf::Cell(0, 0, utf8_decode('Cédula:  ' . $orden->Cedula_Ruc));

        //***Seccion CENTRAL
        Fpdf::SetXY(105, 30);
        Fpdf::Cell(0, 0, utf8_decode('E-mail:  ' . $orden->Email));
        Fpdf::SetXY(60, 30);
        Fpdf::Cell(0, 0, utf8_decode('Teléfono:  ' . $orden->Telefono));
        Fpdf::SetXY(180, 30);
        Fpdf::Cell(0, 0, utf8_decode('Código:  ' . $orden->id_tb_cliente));

        //**********Seccion Izquierda

        Fpdf::SetFont('Arial', 'B', 15);
        Fpdf::SetXY(180, 5);
        Fpdf::Cell(0, 0, utf8_decode('Nº:  ' . $orden->id_tb_ordenes));
        Fpdf::SetFont('Arial', '', 9);
        Fpdf::SetXY(180, 10);
        Fpdf::Cell(0, 0, utf8_decode($orden->name));
        Fpdf::SetXY(183, 14);
        Fpdf::Cell(0, 0, utf8_decode('ORIGINAL'));

        //*******INICIO CABECERA DETALLES
        Fpdf::SetFont('Arial', 'B', 7);
        Fpdf::SetXY(1, 33);
        Fpdf::Cell(10, 4, 'CANT.', 1, 0, 'C');
        Fpdf::Ln();
        //SERVICIO
        Fpdf::SetXY(11, 33);
        Fpdf::Cell(26, 4, 'SERVICIO', 1, 0, 'C');
        Fpdf::Ln();
        //PRODUCTO
        Fpdf::SetXY(37, 33);
        Fpdf::Cell(28, 4, 'PRODUCTO', 1, 0, 'C');
        Fpdf::Ln();
        //DESCRIPCION
        Fpdf::SetXY(65, 33);
        Fpdf::Cell(112, 4, 'DESCRIPCION', 1, 0, 'C');
        Fpdf::Ln();
        //Valor UNITARIO
        Fpdf::SetXY(177, 33);
        Fpdf::Cell(16, 4, 'VALOR U.', 1, 0, 'C');
        Fpdf::Ln();
        //TOTAL
        Fpdf::SetXY(193, 33);
        Fpdf::Cell(16, 4, 'TOTAL', 1, 0, 'C');
        Fpdf::Ln();

        $total = 0;

        //****Mostramos los detalles
        $y = 39;

        foreach ($detalles as $det) {
            Fpdf::SetFont('Arial', '', 8);



            Fpdf::SetXY(1, $y);

            Fpdf::MultiCell(10, 3, $det->cantidad);

            Fpdf::SetXY(12, $y);
            Fpdf::MultiCell(28, 3, utf8_decode($det->Servicio));

            Fpdf::SetXY(39, $y);
            Fpdf::MultiCell(29, 3, utf8_decode($det->Productos));

            Fpdf::SetXY(66, $y);
            Fpdf::MultiCell(110, 3, utf8_decode($det->Descripcion));

            Fpdf::SetFont('Arial', '', 9);
            Fpdf::SetXY(179, $y);
            Fpdf::MultiCell(25, 3, number_format($det->Valor_Unitario, 2, '.', ','));

            Fpdf::SetXY(195, $y);
            Fpdf::MultiCell(25, 3, number_format(($det->Valor_Unitario * $det->cantidad), 2, '.', ','));

            $total = $total + (($det->Valor_Unitario) * $det->cantidad);
            $y     = $y + 9;
        }

        //Fpdf::SetFont('Arial', 'B', 14);

        /////ENTREGA A DOMICILIO
        if ($orden->entrega_domicilio == 1) {
            Fpdf::SetFont('Arial', 'B', 18);
            Fpdf::SetXY(2, 110);
            Fpdf::Cell(203, 7, utf8_decode('ENTREGA A DOMICILIO'), 0, 0, 'C');
            Fpdf::Ln();
        }
        //OBSERVACIONES
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::SetXY(2, 117);
        Fpdf::MultiCell(156, 4, 'OBSERVACIONES: ' . utf8_decode($orden->Observaciones), 1, 'C');

        setlocale(LC_TIME, "es_ES");

        //FECHAS DE LA ORDEN


        /////CONDICIONES
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(2, 143);
        Fpdf::Cell(156, 5, utf8_decode('En caso de no retirar su ORDEN en un máximo de 20 días se dará de baja sin devolución alguna.'), 1, 0, 'C');
        Fpdf::Ln();

        ///CUADRO FECHA INICIO
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::SetXY(2, 135);
        Fpdf::Cell(50, 4, 'Inicio', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 8);
        Fpdf::SetXY(2, 139);
        Fpdf::Cell(50, 4, strftime("%A, %e de %b de %G - %R", strtotime($orden->Fecha_de_Inicio)), 1, 0, 'C');
        //TERMINA CUADRO FECHA INICIO

        //INICIA CUADRO FECHA DISENO

        if ($orden->Revision_de_Diseno != null) {
            Fpdf::SetFont('Arial', 'B', 8);
            Fpdf::SetXY(55, 135);
            Fpdf::Cell(50, 4, utf8_decode('Diseño'), 1, 0, 'C');
            Fpdf::Ln();
            Fpdf::SetFont('Arial', '', 8);
            Fpdf::SetXY(55, 139);
            Fpdf::Cell(50, 4, strftime("%A, %e de %b de %G - %R", strtotime($orden->Revision_de_Diseno)), 1, 0, 'C');
        }
        //TERMINA CUADRO FECHA DISENO

        ///CUADRO FECHA ENTREGA
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::SetXY(108, 135);
        Fpdf::Cell(50, 4, 'Entrega', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 8);
        Fpdf::SetXY(108, 139);
        Fpdf::Cell(50, 4, strftime("%A, %e de %b de %G - %R", strtotime($orden->Fecha_de_Entrega)), 1, 0, 'C');
        //TERMINA CUADRO FECHA ENTREGA

        //INICIO ABONO
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(165, 135);
        Fpdf::Cell(20, 4, 'Abono', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 9);
        Fpdf::SetXY(185, 135);
        Fpdf::MultiCell(20, 4, "$ " . number_format($orden->Abono, 2, '.', ','), 1, 'C');
        //FIN ABONO
        //INICIO SALDO
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(165, 139);
        Fpdf::Cell(20, 4, 'Saldo', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetXY(185, 139);
        Fpdf::MultiCell(20, 4, "$ " . number_format((($orden->Total_Venta + ($orden->Total_Venta * 0.12)) - $orden->Abono), 2, '.', ','), 1, 'C');
        //FIN SALDO

        //------------------TOTALES
        /////INCIO SUBTOTAL
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(165, 117);
        Fpdf::Cell(20, 5, 'Subtotal', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 9);
        Fpdf::SetXY(185, 117);
        Fpdf::MultiCell(20, 5, "" . '$ ' . number_format($orden->Total_Venta, 2, '.', ','), 1, 'C');
        /////FIN SUBTOTAL
        /////INICIO  IVA
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(165, 122);
        Fpdf::Cell(20, 5, 'I.V.A', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 9);
        Fpdf::SetXY(185, 122);
        Fpdf::MultiCell(20, 5, "" . '$ ' .  number_format(($orden->Total_Venta * 0.12), 2, '.', ','), 1, 'C');
        /////FIN  IVA

        /////INICIO VALOR TOTAL
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::SetXY(165, 127);
        Fpdf::Cell(20, 5, 'V. TOTAL', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::SetXY(185, 127);
        Fpdf::MultiCell(20, 5, "" . '$ ' . number_format($orden->Total_Venta + ($orden->Total_Venta * 0.12), 2, '.', ','), 1, 'C');
        /////FIN VALOR TOTAL



        /////////////////////////////////////////////////////
        ///////////////////////////COPIA/////////////////////
        ////////////////////////////////////////////////////

        //Datos IMAGENES
        Fpdf::Image('http://dikpro.dikapsa.com/public/img/barra.jpg', 0, 150, 590);
        Fpdf::Image('http://dikpro.dikapsa.com/public/img/logo-dikapsa.jpg', 5, 151);
        Fpdf::Image('http://dikpro.dikapsa.com/public/img/direc.jpg', 68, 155, 100);
        Fpdf::Image('http://dikpro.dikapsa.com/public/img/fon1.jpg', 70, 220, 70);

        //****Datos COMPRADOR
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::SetXY(5, 170);
        Fpdf::Cell(0, 0, utf8_decode('Cliente:  ' . $orden->Cliente_Nombre_Comercial));
        Fpdf::SetXY(5, 175);
        Fpdf::Cell(0, 0, utf8_decode('Contacto:  ' . $orden->Contacto_Razon_Social));
        Fpdf::SetXY(5, 180);
        Fpdf::Cell(0, 0, utf8_decode('Cédula:  ' . $orden->Cedula_Ruc));

        //***Seccion CENTRAL
        Fpdf::SetXY(105, 180);
        Fpdf::Cell(0, 0, utf8_decode('E-mail:  ' . $orden->Email));
        Fpdf::SetXY(60, 180);
        Fpdf::Cell(0, 0, utf8_decode('Teléfono:  ' . $orden->Telefono));
        Fpdf::SetXY(180, 180);
        Fpdf::Cell(0, 0, utf8_decode('Código:  ' . $orden->id_tb_cliente));

        //**********Seccion Izquierda

        Fpdf::SetFont('Arial', 'B', 15);
        Fpdf::SetXY(180, 155);
        Fpdf::Cell(0, 0, utf8_decode('Nº:  ' . $orden->id_tb_ordenes));
        Fpdf::SetFont('Arial', '', 9);
        Fpdf::SetXY(180, 160);
        Fpdf::Cell(0, 0, utf8_decode($orden->name));
        Fpdf::SetXY(183, 164);
        Fpdf::Cell(0, 0, utf8_decode('COPIA'));

        //*******INICIO CABECERA DETALLES
        Fpdf::SetFont('Arial', 'B', 7);
        Fpdf::SetXY(1, 183);
        Fpdf::Cell(10, 4, 'CANT.', 1, 0, 'C');
        Fpdf::Ln();
        //SERVICIO
        Fpdf::SetXY(11, 183);
        Fpdf::Cell(26, 4, 'SERVICIO', 1, 0, 'C');
        Fpdf::Ln();
        //PRODUCTO
        Fpdf::SetXY(37, 183);
        Fpdf::Cell(28, 4, 'PRODUCTO', 1, 0, 'C');
        Fpdf::Ln();
        //DESCRIPCION
        Fpdf::SetXY(65, 183);
        Fpdf::Cell(112, 4, 'DESCRIPCION', 1, 0, 'C');
        Fpdf::Ln();
        //Valor UNITARIO
        Fpdf::SetXY(177, 183);
        Fpdf::Cell(16, 4, 'VALOR U.', 1, 0, 'C');
        Fpdf::Ln();
        //TOTAL
        Fpdf::SetXY(193, 183);
        Fpdf::Cell(16, 4, 'TOTAL', 1, 0, 'C');
        Fpdf::Ln();

        $total = 0;

        //****Mostramos los detalles
        $y = 189;

        foreach ($detalles as $det) {
            Fpdf::SetFont('Arial', '', 8);



            Fpdf::SetXY(1, $y);

            Fpdf::MultiCell(10, 3, $det->cantidad);

            Fpdf::SetXY(12, $y);
            Fpdf::MultiCell(28, 3, utf8_decode($det->Servicio));

            Fpdf::SetXY(39, $y);
            Fpdf::MultiCell(29, 3, utf8_decode($det->Productos));

            Fpdf::SetXY(66, $y);
            Fpdf::MultiCell(110, 3, utf8_decode($det->Descripcion));

            Fpdf::SetFont('Arial', '', 9);
            Fpdf::SetXY(179, $y);
            Fpdf::MultiCell(25, 3, number_format($det->Valor_Unitario, 2, '.', ','));

            Fpdf::SetXY(195, $y);
            Fpdf::MultiCell(25, 3, number_format(($det->Valor_Unitario * $det->cantidad), 2, '.', ','));

            $total = $total + (($det->Valor_Unitario) * $det->cantidad);
            $y     = $y + 9;
        }

        /////ENTREGA A DOMICILIO
        if ($orden->entrega_domicilio == 1) {
            Fpdf::SetFont('Arial', 'B', 18);
            Fpdf::SetXY(2, 260);
            Fpdf::Cell(203, 7, utf8_decode('ENTREGA A DOMICILIO'), 0, 0, 'C');
            Fpdf::Ln();
        }

        //OBSERVACIONES
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::SetXY(2, 267);
        Fpdf::MultiCell(156, 4, 'OBSERVACIONES: ' . utf8_decode($orden->Observaciones), 1, 'C');

        setlocale(LC_TIME, "es_ES");

        /////CONDICIONES
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(2, 293);
        Fpdf::Cell(156, 5, utf8_decode('En caso de no retirar su ORDEN en un máximo de 20 días se dará de baja sin devolución alguna.'), 1, 0, 'C');
        Fpdf::Ln();

        //FECHAS DE LA ORDEN
        Fpdf::SetFont('Arial', 'B', 8);
        ///CUADRO FECHA INICIO
        Fpdf::SetXY(2, 285);
        Fpdf::Cell(50, 4, 'Inicio', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 8);
        Fpdf::SetXY(2, 289);
        Fpdf::Cell(50, 4, strftime("%A, %e de %b de %G - %R", strtotime($orden->Fecha_de_Inicio)), 1, 0, 'C');
        //TERMINA CUADRO FECHA INICIO

        //INICIA CUADRO FECHA DISENO

        if ($orden->Revision_de_Diseno != null) {
            Fpdf::SetFont('Arial', 'B', 8);
            Fpdf::SetXY(55, 285);
            Fpdf::Cell(50, 4, utf8_decode('Diseño'), 1, 0, 'C');
            Fpdf::Ln();
            Fpdf::SetFont('Arial', '', 8);
            Fpdf::SetXY(55, 289);
            Fpdf::Cell(50, 4, strftime("%A, %e de %b de %G - %R", strtotime($orden->Revision_de_Diseno)), 1, 0, 'C');
        }
        //TERMINA CUADRO FECHA DISENO

        ///CUADRO FECHA ENTREGA
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::SetXY(108, 285);
        Fpdf::Cell(50, 4, 'Entrega', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 8);
        Fpdf::SetXY(108, 289);
        Fpdf::Cell(50, 4, strftime("%A, %e de %b de %G - %R", strtotime($orden->Fecha_de_Entrega)), 1, 0, 'C');
        //TERMINA CUADRO FECHA ENTREGA

        //INICIO ABONO
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(165, 285);
        Fpdf::Cell(20, 4, 'Abono', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 9);
        Fpdf::SetXY(185, 285);
        Fpdf::MultiCell(20, 4, "$ " . number_format($orden->Abono, 2, '.', ','), 1, 'C');
        //FIN ABONO
        //INICIO SALDO
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(165, 289);
        Fpdf::Cell(20, 4, 'Saldo', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetXY(185, 289);
        Fpdf::MultiCell(20, 4, "$ " . number_format((($orden->Total_Venta + ($orden->Total_Venta * 0.12)) - $orden->Abono), 2, '.', ','), 1, 'C');
        //FIN SALDO

        //------------------TOTALES
        /////INCIO SUBTOTAL
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(165, 267);
        Fpdf::Cell(20, 5, 'Subtotal', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 9);
        Fpdf::SetXY(185, 267);
        Fpdf::MultiCell(20, 5, "" . '$ ' . number_format($orden->Total_Venta, 2, '.', ','), 1, 'C');
        /////FIN SUBTOTAL
        /////INICIO  IVA
        Fpdf::SetFont('Arial', 'B', 9);
        Fpdf::SetXY(165, 272);
        Fpdf::Cell(20, 5, 'I.V.A', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 9);
        Fpdf::SetXY(185, 272);
        Fpdf::MultiCell(20, 5, "" . '$ ' .  number_format(($orden->Total_Venta * 0.12), 2, '.', ','), 1, 'C');
        /////FIN  IVA

        /////INICIO VALOR TOTAL
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::SetXY(165, 277);
        Fpdf::Cell(20, 5, 'V. TOTAL', 1, 0, 'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::SetXY(185, 277);
        Fpdf::MultiCell(20, 5, "" . '$ ' . number_format($orden->Total_Venta + ($orden->Total_Venta * 0.12), 2, '.', ','), 1, 'C');
        /////FIN VALOR TOTAL


        Fpdf::Output();
        exit;
    }
}
