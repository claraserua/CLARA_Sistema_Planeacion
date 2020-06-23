<?php

class uploadapoyoModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	var $idlinea;
	var $idobjetivo;
	var $autor;
	var $tipo;
	var $imagen;
	var $adjunto;
	
	var $lineas;
	var $objetivos;
	
	var $campos;
	


	function __construct() {
		
	}
	
	
		
		
	

    function UploadFile(){
		
		$this->campos = array('PK1'=>uniqid($this->tipo),
	                         'TITULO'=>$this->titulo,
							 'DESCRIPCION'=>$this->descripcion,
							 'AUTOR'=>$this->autor,
							 'TIPO'=>$this->tipo,
							 'IMAGEN'=>$this->imagen,
							 'ADJUNTO'=>$this->adjunto,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>"admin",
							 );
	
		database::insertRecords("PL_APOYOS",$this->campos);
		
	}
	
	
	
}

?>