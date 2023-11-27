<?php
require 'vendor/autoload.php'; // Asegúrate de incluir el archivo de autoloading de Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

$archivoExcel = 'Public/excel/cosoCosito.xlsx'; // Reemplaza con la ruta a tu archivo Excel
$registroID = 97370; // Reemplaza con el ID específico que estás buscando

try {
    $spreadsheet = IOFactory::load($archivoExcel);
    $sheet = $spreadsheet->getActiveSheet();

    // Buscar la fila que contiene el ID específico
    $filaEncontrada = null;
    foreach ($sheet->getRowIterator() as $row) {
        $cellValue = $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue(); // Suponiendo que el ID está en la primera columna
        if ($cellValue == $registroID) {
            $filaEncontrada = $row->getRowIndex();
            break;
        }
    }

    // Verificar si se encontró la fila
    if ($filaEncontrada !== null) {
        // Obtener los datos de la fila encontrada
        $datosRegistro = [];
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        for ($col = 1; $col <= $highestColumnIndex; ++$col) {
            $valorCelda = $sheet->getCellByColumnAndRow($col, $filaEncontrada)->getValue();
            // Asignar los valores a un array asociativo usando los encabezados de columna como claves
            $datosRegistro[$sheet->getCellByColumnAndRow($col, 1)->getValue()] = $valorCelda;
        }

        // Hacer algo con los datos del registro encontrado
        print_r($datosRegistro);
    } else {
        echo "Registro con ID $registroID no encontrado.";
    }
} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    // Manejar cualquier excepción que pueda ocurrir durante la carga del archivo
    echo 'Error al cargar el archivo Excel: ', $e->getMessage();
}
?>