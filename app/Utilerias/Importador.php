<?php

namespace App\Utilerias;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Importador
{
    var $tmpfname = null;
    var $cabeceras = [];
    var $estructura = [];
    var $excelObj = null;

    public function __construct($tmpfname, $cabeceras = null, $estructura = null)
    {
        $this->tmpfname = $tmpfname;
        $this->cabeceras = $cabeceras;
        $this->estructura = $estructura;

        $spreadsheet = IOFactory::load($this->tmpfname);
        $this->excelObj = $spreadsheet;

        if ($cabeceras != null && $estructura != null) {
            $this->map($this->cabeceraHojaCalculo());
        }
    }

    public function make()
    {
        $hoja_de_calculo = $this->excelObj->getSheet(0);
        $objetos = [];

        for ($fila = 2; $fila <= $hoja_de_calculo->getHighestRow(); $fila++) {
            $objetos[] = $this->getDatos($fila, $this->estructura);
        }

        return $objetos;
    }

    public function map($cabecera_original)
    {
        $this->cabeceras = $this->cabeceras->map(function ($item) use ($cabecera_original) {
            $val = $cabecera_original->firstWhere('cabecera', trim(strtolower($item['nombre'])));
            $item['columna'] = $val['columna'] ?? null;
            return $item;
        });
    }

    public function cabeceraHojaCalculo()
    {
        $hoja_de_calculo = $this->excelObj->getSheet(0);
        $cabecera_original = [];
        $highestColumnIndex = Coordinate::columnIndexFromString($hoja_de_calculo->getHighestDataColumn());

        for ($i = 1; $i <= $highestColumnIndex; $i++) {
            $colLetter = Coordinate::stringFromColumnIndex($i);
            $valorcelda = trim(strtolower($hoja_de_calculo->getCell($colLetter . '1')->getValue()));
            $cabecera_original[] = ["columna" => $colLetter, "cabecera" => $valorcelda];
        }

        return collect($cabecera_original);
    }

    public function getDatos($fila, $objeto, $buscar_cabecera = true)
    {
        foreach ($objeto as $campo => $celda) {

            $col = null; // ⚠ Inicializamos col para evitar "undefined variable"

            // Columnas simples
            if (is_numeric($celda) || is_string($celda)) {

                $tipo = 'string';
                if ($buscar_cabecera) {
                    if (is_numeric($celda) && $celda >= 0) {
                        $col = $this->cabeceras[$celda]['columna'] ?? null;
                        $tipo = $this->cabeceras[$celda]['tipo'] ?? 'string';
                    } elseif (is_string($celda)) {
                        $cab = $this->cabeceras->firstWhere('nombre', strtolower($celda));
                        $col = $cab['columna'] ?? null;
                        $tipo = $cab['tipo'] ?? 'string';
                    }
                } else {
                    $col = $celda;
                }

                $valor = ($col) ? $this->excelObj->getActiveSheet()->getCell($col . $fila)->getValue() : null;

                if ($tipo == 'date' && $valor != null && $valor != '') {
                    if (is_string($valor)) {
                        $objeto[$campo] = date('Y-m-d', strtotime(str_replace('/', '-', $valor)));
                    } elseif (Date::isDateTime($this->excelObj->getActiveSheet()->getCell($col . $fila))) {
                        $objeto[$campo] = date('Y-m-d', Date::excelToTimestamp($valor));
                    } else {
                        $objeto[$campo] = date('Y-m-d', Date::excelToTimestamp($valor));
                    }
                } elseif (($tipo == 'int' || $tipo == 'float') && ($valor === null || $valor === '')) {
                    $objeto[$campo] = 0;
                } else {
                    // Para columnas opcionales como 'imagen', si está vacía, poner null
                    $objeto[$campo] = ($valor !== null && $valor !== '') ? trim($valor) : null;
                }
            }

            // Columnas compuestas / array (respuestas dinámicas)
            if (is_array($celda)) {
                if (isset($celda['elementos'])) {
                    $objeto[$campo] = [];
                    $inicio = Coordinate::columnIndexFromString($this->cabeceras[$celda['secuencia_despues']]['columna']) + 1;
                    $fin = Coordinate::columnIndexFromString($this->cabeceras[$celda['secuencia_antes']]['columna']);
                    $celda_inicio = $this->cabeceras[$celda['secuencia_despues']]['columna'];

                    for ($i = $inicio; $i < $fin; $i += $celda['rango']) {
                        foreach ($celda['elementos'] as $cam => $valor) {
                            $celda['elementos'][$cam] = ++$celda_inicio;
                        }

                        $d = $this->getDatos($fila, $celda['elementos'], false);

                        if (isset($celda['validar']) && $celda['validar'] != '') {
                            if ($this->validar($d, $celda['validar'], $celda['operador'])) {
                                $objeto[$campo][] = $d;
                            }
                        } else {
                            $objeto[$campo][] = $d;
                        }
                    }
                } else {
                    $objeto[$campo] = $this->getDatos($fila, $celda);
                }
            }
        }

        return $objeto;
    }

    public function validar($datos, $validaciones, $operador)
    {
        $arr = json_decode($validaciones, true);
        $band = false;

        foreach ($arr as $e => $v) {
            switch ($v) {
                case '>0':
                    if ($datos[$e] != '' && $datos[$e] > 0) $band = true;
                    break;
                case '<0':
                    if ($datos[$e] != '' && $datos[$e] < 0) $band = true;
                    break;
            }
            if ($operador == "OR" && $band) break;
        }

        return $band;
    }
}
