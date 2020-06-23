<?php

class addplaneModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	
	
	var $campos;
	

	
	
	function __construct() {
		
	}

    function GuardarPlan(){
		
		$JERARQUIA = $this->jerarquia;
		
		$this->campos = array('PK1'=>$this->idplan,
	                         'TITULO'=>$this->titulo,
							 'DESCRIPCION'=>$this->descripcion,
							 'PK_JERARQUIA'=>$this->jerarquia,
							 'DISPONIBLE'=>$this->disponible,
							 'FECHA_I'=>$this->fechai,
							 'FECHA_T'=>$this->fechat,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
	
		database::insertRecords("PL_PESTRATEGICOS",$this->campos);
		
		
		
		
		//Agregarmos la alerta
		
		$this->campos = array('OBJETIVO'=>"Se ha agregado un nuevo plan estrategico..",
							 'TIPO'=>"ALERT",
							 'VISTO'=>'0',
							 'URL'=>"?execute=principal&method=default&Menu=F1&SubMenu=SF11#&p=1&s=25&sort=1&q=&filter=".$JERARQUIA."",
							 'PK_JERARQUIA'=>$this->jerarquia,
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 );
	
		database::insertRecords("PL_NOTIFICACIONES",$this->campos);
		
		
	}
	
	
	
}

?>