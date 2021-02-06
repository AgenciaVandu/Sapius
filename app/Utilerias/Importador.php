<?php

namespace App\Utilerias;

// use stdClass;

use PHPExcel_Shared_Date;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

class Importador
{
    var $tmpfname  = null;
    var $cabeceras = [];
    var $estructura = [];
    var $planteles = [];
    var $estados = [];
    var $bancos = [];
    var $localidades = [];
    var $excelObj = null;

    public function __construct($tmpfname, $cabeceras = null, $estructura = null)
    {
        $this->tmpfname = $tmpfname;
        $this->cabeceras = $cabeceras;
        $this->estructura = $estructura;

        //$excelReader = PHPExcel_IOFactory::createReaderForFile($this->tmpfname);

        $XLFileType = PHPExcel_IOFactory::identify($this->tmpfname);
        $excelReader = PHPExcel_IOFactory::createReader($XLFileType);
        //\Log::debug(dd($excelReader));
        $excelReader->setReadDataOnly(TRUE);

        //\Log::debug(dd($excelReader));
        $this->excelObj = $excelReader->load($this->tmpfname);

        if($cabeceras != null && $estructura != null)
            $this->map($this->cabeceraHojaCalculo());
        //\Log::debug(dd($this->cabeceras));
        //\Log::debug(print_r($this->cabeceras,true));
    }

    public function make() {
        $hoja_de_calculo = $this->excelObj->getSheet(0);

        $objetos = [];
        for($fila = 2; $fila <= $hoja_de_calculo->getHighestRow(); $fila++) {
            $objetos[] = $this->getDatos($fila,$this->estructura);
        }
        return $objetos;
    }

    //Devuelve la cabecera configurada con las letras de las columnas correpondientes, tomadas de la cabecera del archivo.
    public function map($cabecera_original){
        $this->cabeceras = $this->cabeceras->map(function ($item, $key) use($cabecera_original) {
            $val = $cabecera_original->firstWhere('cabecera', trim(strtolower($item['nombre'])));
            $item['columna'] = $val['columna'];
            return $item;
        });
    }

    //Devuelve un collection de la forma NombreCabecera => Letra, que corresponde a toda la cabecera del archivo
    public function cabeceraHojaCalculo(){
        $hoja_de_calculo = $this->excelObj->getSheet(0);
        $cabecera_original =[];
        $column = 'A';//Letra incial del excel
        $maximaColumna = PHPExcel_Cell::columnIndexFromString($this->excelObj->getActiveSheet()->getHighestDataColumn());
        //dump($maximaColumna);
        for($i = 0; $i < $maximaColumna; $i++) {
            $valorcelda = trim(strtolower($hoja_de_calculo->getCell($column.'1')->getValue()));
            $cabecera_original[] = ["columna" => $column, "cabecera" => $valorcelda];
            $column++;
        }
        //\Log::debug(dd($cabecera_original));
        return collect($cabecera_original);
    }

    public function validaCabeceras(){
        $hoja_de_calculo = $this->excelObj->getSheet(0);
        $column = 'A';//Letra incial del excel
        //$cabeceras = array_keys($this->cabeceras);
        $pasos = $this->cabeceras->count(); //Numero de campos de la cabecera
        for($i = 0; $i < $pasos; $i++) {
            $valorcelda = trim(strtolower($hoja_de_calculo->getCell($column.'1')->getValue()));
            $cabecera = $this->cabeceras->where('nombre', $valorcelda);
            //$cabecera = trim(strtolower($this->cabeceras[$i]->nombre));
            if($cabecera->isNotEmpty()){
                dump("[".$i."] La cabecera ★★".$valorcelda."★★ no existe en la configuración");
            }else{

            }
            $column++;
        }

        return true;
    }

    public function getDatos($fila, $objeto,$buscar_cabecera = true){
        //$cuentas =['cuenta' => 'CH', 'clabe' => 'CI', 'banco_id' => 'CJ'];
        foreach ($objeto as $campo => $celda){
            //verificar si es string (letra)
            if((is_numeric($celda) && $celda >= 0) || !$buscar_cabecera){
                $col = ($buscar_cabecera)? $this->cabeceras[$celda]['columna']:$celda;
                $valor = $this->excelObj->getActiveSheet()->getCell($col.$fila)->getValue();

                if( $buscar_cabecera && $this->cabeceras[$celda]['tipo'] == 'date')
                {
                    //\Log::debug(dd($this->cabeceras[$celda]['columna']));
                    if($valor != '' && $valor != '//' && $valor != null){
                        if(is_string($valor))
                            $objeto [$campo] = date('Y-m-d',strtotime(str_replace('/', '-',$valor)));
                        elseif(PHPExcel_Shared_Date::isDateTime( $this->excelObj->getActiveSheet()->getCell($col.$fila)))
                            $objeto [$campo] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($valor));
                        else
                            $objeto [$campo] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($valor));
                    }else
                        $objeto[$campo] = NULL;
                }
                elseif($buscar_cabecera && (($this->cabeceras[$celda]['tipo'] == 'int' || $this->cabeceras[$celda]['tipo'] == 'float') && $valor == ''))
                    $objeto [$campo] = 0;
                elseif($buscar_cabecera && $this->cabeceras[$celda]['tipo'] == 'string')
                    $objeto [$campo] = (string)trim($valor);
                else
                    $objeto [$campo] = trim($valor);
            }
            //verificar si es arreglo
            if(is_array($celda)){
                //Verifica si tiene el campo rango
                if(isset($celda['elementos'])){
                    $objeto[$campo] =[];
                    //\Log::debug(dd( $this->cabeceras[$celda['secuencia_antes']]['columna']));
                    $inicio = PHPExcel_Cell::columnIndexFromString($this->cabeceras[$celda['secuencia_despues']]['columna']) + 1;
                    $fin = PHPExcel_Cell::columnIndexFromString($this->cabeceras[$celda['secuencia_antes']]['columna']);
                    $celda_inicio = $this->cabeceras[$celda['secuencia_despues']]['columna'];
                    for($i = $inicio; $i < $fin; $i +=  $celda['rango']){
                        foreach($celda['elementos'] as $cam => $valor){
                            $celda['elementos'][$cam] = ++$celda_inicio;
                        }
                        //\Log::debug(dd( $celda['elementos']));

                        $d = $this->getDatos($fila,$celda['elementos'],false);

                        //\Log::debug(dd( $d));

                        if(isset($celda['validar']) && $celda['validar'] != '')
                        {
                            if($this->validar($d,$celda['validar'],$celda['operador'])) $objeto[$campo][] = $d;
                        }
                        else
                            $objeto[$campo][] = $d;
                    }
                    //\Log::debug(dd($objeto));
                }else{
                    //si no se llama getdatos()
                    $objeto[$campo] = $this->getDatos($fila,$celda);
                }
            }
          }

        return $objeto;
    }

    public function validar($datos, $validaciones, $operador){
        $arr = json_decode($validaciones,true);
        $band =false;
        //\Log::debug(dd($datos));
        foreach($arr as $e => $v){
            switch($v){
                case '>0':
                    if($datos[$e] !='' && $datos[$e] > 0)
                        $band = true;
                    break;
                case '<0':
                    if($datos[$e] !='' && $datos[$e] < 0)
                        $band = true;
                    break;
            }
            if($operador == "OR" && $band) break;
        }
        //\Log::debug(dd($datos));
        return $band;
    }

}
