<?php

namespace App\Utilerias;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Exportador
{
    protected $estructura;
    protected $cabeceras;
    protected $datos;
    protected $spreadsheet;

    public function __construct($estructura, $cabeceras, $datos)
    {
        $this->estructura = $estructura;
        $this->cabeceras = $cabeceras;
        $this->datos = $datos;

        $this->spreadsheet = new Spreadsheet();
    }

    public function exportar($nombreArchivo = 'preguntas_exportadas.xlsx')
    {
        $hoja = $this->spreadsheet->getActiveSheet();

        // Escribir cabeceras
        foreach ($this->cabeceras as $index => $cabecera) {
            $col = Coordinate::stringFromColumnIndex($index + 1);
            $hoja->setCellValue($col . '1', $cabecera['nombre']);
        }

        // Agregar columna "imagen" al final
        $colImagenIndex = count($this->cabeceras) + 1;
        $colImagen = Coordinate::stringFromColumnIndex($colImagenIndex);
        $hoja->setCellValue($colImagen . '1', 'imagen');

        $fila = 2;

        foreach ($this->datos as $dato) {
            // Valores planos
            foreach ($this->estructura as $campo => $indice) {
                if (is_numeric($indice) && $indice >= 0) {
                    $col = Coordinate::stringFromColumnIndex($indice + 1);
                    $hoja->setCellValue($col . $fila, $dato[$campo] ?? '');
                }
            }

            // Respuestas anidadas
            if (isset($this->estructura['respuestas'])) {
                $respuestas = $dato['respuestas'] ?? [];
                $inicio = Coordinate::columnIndexFromString(
                    $this->cabeceras[$this->estructura['respuestas']['secuencia_despues']]['columna']
                ) + 1;

                foreach ($respuestas as $respuesta) {
                    $col = Coordinate::stringFromColumnIndex($inicio);
                    $hoja->setCellValue($col . $fila, $respuesta['respuesta'] ?? '');
                    $inicio += $this->estructura['respuestas']['rango'];
                }
            }

            // Insertar imagen desde ruta relativa
            if (!empty($dato['imagen'])) {
                $rutaImagen = public_path($dato['imagen']);
                if (file_exists($rutaImagen)) {
                    $drawing = new Drawing();
                    $drawing->setPath($rutaImagen);
                    $drawing->setCoordinates($colImagen . $fila);
                    $drawing->setHeight(50);
                    $drawing->setWorksheet($hoja);

                    $hoja->getRowDimension($fila)->setRowHeight(60);
                    $hoja->getColumnDimension($colImagen)->setWidth(20);
                } else {
                    // Si no existe la imagen, mostramos la ruta relativa
                    $hoja->setCellValue($colImagen . $fila, $dato['imagen']);
                }
            } else {
                $hoja->setCellValue($colImagen . $fila, '');
            }

            $fila++;
        }

        $path = storage_path("app/public/{$nombreArchivo}");
        (new Xlsx($this->spreadsheet))->save($path);

        return $path;
    }
}