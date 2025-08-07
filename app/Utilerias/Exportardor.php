<?php

namespace App\Utilerias;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

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

        $fila = 2;

        foreach ($this->datos as $dato) {
            // Valores planos (no anidados)
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

            $fila++;
        }

        $path = storage_path("app/public/{$nombreArchivo}");
        (new Xlsx($this->spreadsheet))->save($path);

        return $path;
    }
}