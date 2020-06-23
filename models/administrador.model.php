<?php

class administradorModel {
	
	var $articulos;
	var $tutoriales;
	var $lineamientos;
	var $links;
	var $recursos;
	var $noticias;
	var $totalnum;
	var $totalPag;

	
	
	function __construct() {
		
	}

    function getArticulos(){
		
		$this->articulos = array();
        $sql = "SELECT * FROM ARTICULOS";
       
		$objdb = new database();
		$result = $objdb->executeQuery($sql);
	
	    while ($row = mysql_fetch_array($result)) {
		
	   $this->articulos[] = $row;
		
        }

     	}
		
		
		
		
		function getArticulo($id){
		
		$sql = "SELECT * FROM ARTICULOS WHERE PK1='$id'";   
		$objdb = new database();
	    $row = $objdb->getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		
		
		
		 function getTutoriales(){
		
		$this->tutoriales = array();
        $sql = "SELECT * FROM TUTORIALES";
       
		$objdb = new database();
		$result = $objdb->executeQuery($sql);
	
	    while ($row = mysql_fetch_array($result)) {
		
	   $this->tutoriales[] = $row;
		
        }

     	}
		
		
	
		
		function getTutorial($id){
		
		$sql = "SELECT * FROM TUTORIALES WHERE PK1='$id'";   
		$objdb = new database();
	    $row = $objdb->getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		
	
	 function getLinks(){
		
		$this->links = array();
        $sql = "SELECT * FROM LINKS";
       
		$objdb = new database();
		$result = $objdb->executeQuery($sql);
	
	    while ($row = mysql_fetch_array($result)) {
		
	   $this->links[] = $row;
		
        }

     	}
		
		
		
		 function searchRecursos(){
		
		$this->recursos = array();
       // maximo por pagina
        $limit = $_GET["s"];
		// pagina pedida
        $pag = (int) $_GET["p"];
        if ($pag < 1)
        {
        $pag = 1;
        }
        
		$offset = ($pag-1) * $limit;
		
	
        $sql = "SELECT SQL_CALC_FOUND_ROWS PK1,PK1,TITULO,DESCRIPCION,PK1_RECURSO,PK1_CLASIFICACION,PK1_DISCIPLINA,ESTADO,FECHA_C,FECHA_M,IMAGEN,ADJUNTO,URL,AUTOR,ATRIBUTOS,ORDEN,METAKEY FROM CONTENIDOS ";
		
		
		$AND = "";
		$WHERE = "";
		
		if(isset($_GET['q']) && $_GET['q']!= ""){
		    
			$sql .= "WHERE (TITULO LIKE '%".$_GET['q']."%') ";	
		    $AND = "AND";
		     $WHERE = "";
		}else{
			
		$AND = "";
		$WHERE = "WHERE";
		}
		
		if(isset($_GET['filter'])){
			
			$filter = "'".str_replace(";","','",$_GET['filter'])."'";

		    
			$sql .= "$WHERE $AND PK1_CLASIFICACION IN($filter) ";	
		}
		
		
		if(isset($_GET['sort'])){
		    
			switch($_GET['sort']){
				case 1:
				$sql .= "ORDER BY FECHA_C DESC ";	
				break;
			}
			
		}
	
		$sql .= "LIMIT $offset, $limit";
	
 
	
		$sqlTotal = "SELECT FOUND_ROWS() as total";
       
		$objdb = new database();
		$result = $objdb->executeQuery($sql);
		
		$rsTotal = $objdb->executeQuery($sqlTotal);
		$rowTotal = mysql_fetch_assoc($rsTotal);
        // Total de registros sin limit
        $total = $rowTotal["total"];
		$this->totalnum = $total;
	
	
	    while ($row = mysql_fetch_array($result)) {
		
	   $this->recursos[] = $row;
		
        }
		
		//CALCULAMOS EL TOTAL DE PAGINAS
		$this->totalPag = ceil($total/$limit);

     	}
		

          function searchNoticias(){
		
	$this->noticias = array();
       // maximo por pagina
        $limit = $_GET["s"];
		// pagina pedida
        $pag = (int) $_GET["p"];
        if ($pag < 1)
        {
        $pag = 1;
        }
        
		$offset = ($pag-1) * $limit;
		
	
        $sql = "SELECT SQL_CALC_FOUND_ROWS PK1,PK1,TITULO,DESCRIPCION,IMAGEN,ACTIVO,PRIVADO,FECHA_D,FECHA_H,PK1_CATEGORIA,FECHA_R FROM ARTICULOS ";
		
		
		$AND = "";
		$WHERE = "";
		
		if(isset($_GET['q']) && $_GET['q']!= ""){
		    
			$sql .= "WHERE (TITULO LIKE '%".$_GET['q']."%') ";	
		    $AND = "AND";
		     $WHERE = "";
		}else{
			
		$AND = "";
		$WHERE = "WHERE";
		}
		
		if(isset($_GET['filter'])){
			
			$filter = "'".str_replace(";","','",$_GET['filter'])."'";

		    
			$sql .= "$WHERE $AND PK1_CATEGORIA IN($filter) ";	
		}
		
		
		if(isset($_GET['sort'])){
		    
			switch($_GET['sort']){
				case 1:
				$sql .= "ORDER BY FECHA_R DESC ";	
				break;
			}
			
		}
	
		$sql .= "LIMIT $offset, $limit";
	
 
	
		$sqlTotal = "SELECT FOUND_ROWS() as total";
       
		$objdb = new database();
		$result = $objdb->executeQuery($sql);
		
		$rsTotal = $objdb->executeQuery($sqlTotal);
		$rowTotal = mysql_fetch_assoc($rsTotal);
        // Total de registros sin limit
        $total = $rowTotal["total"];
		$this->totalnum = $total;
	
	
	    while ($row = mysql_fetch_array($result)) {
		
	   $this->noticias[] = $row;
		
        }
		
		//CALCULAMOS EL TOTAL DE PAGINAS
		$this->totalPag = ceil($total/$limit);

     	}
		
		
		 function getNoticias(){
		
		$this->noticias = array();
		
	
	
        $sql = "SELECT * FROM NOTICIAS ORDER BY FECHA_R DESC";
		
		       
	    $objdb = new database();
		$result = $objdb->executeQuery($sql);
	
	    while ($row = mysql_fetch_array($result)) {
		
	       $this->noticias[] = $row;
		
        }
        


     	}

		
		
		function searchTutoriales(){
		
		$this->tutoriales = array();
       // maximo por pagina
        $limit = $_GET["s"];
		// pagina pedida
        $pag = (int) $_GET["p"];
        if ($pag < 1)
        {
        $pag = 1;
        }
        
		$offset = ($pag-1) * $limit;
		
	
        $sql = "SELECT SQL_CALC_FOUND_ROWS PK1,PK1,TITULO,DESCRIPCION,IMAGEN,ACTIVO,PRIVADO,FECHA_D,FECHA_H,PK1_CATEGORIA,FECHA_R,ADJUNTO FROM TUTORIALES ";
		
		
		$AND = "";
		$WHERE = "";
		
		if(isset($_GET['q']) && $_GET['q']!= ""){
		    
			$sql .= "WHERE (TITULO LIKE '%".$_GET['q']."%') ";	
		    $AND = "AND";
		     $WHERE = "";
		}else{
			
		$AND = "";
		$WHERE = "WHERE";
		}
		
		if(isset($_GET['filter'])){
			
			$filter = "'".str_replace(";","','",$_GET['filter'])."'";

		    
			$sql .= "$WHERE $AND PK1_CATEGORIA IN($filter) ";	
		}
		
		
		if(isset($_GET['sort'])){
		    
			switch($_GET['sort']){
				case 1:
				$sql .= "ORDER BY FECHA_R DESC ";	
				break;
			}
			
		}
	
		$sql .= "LIMIT $offset, $limit";
	
 
	
		$sqlTotal = "SELECT FOUND_ROWS() as total";
       
		$objdb = new database();
		$result = $objdb->executeQuery($sql);
		
		$rsTotal = $objdb->executeQuery($sqlTotal);
		$rowTotal = mysql_fetch_assoc($rsTotal);
        // Total de registros sin limit
        $total = $rowTotal["total"];
		$this->totalnum = $total;
	
	
	    while ($row = mysql_fetch_array($result)) {
		
	   $this->tutoriales[] = $row;
		
        }
		
		//CALCULAMOS EL TOTAL DE PAGINAS
		$this->totalPag = ceil($total/$limit);


     	}
		
		
	   function searchLineamientos(){
	   	
	$this->lineamientos = array();
       // maximo por pagina
        $limit = $_GET["s"];
		// pagina pedida
        $pag = (int) $_GET["p"];
        if ($pag < 1)
        {
        $pag = 1;
        }
        
		$offset = ($pag-1) * $limit;
		
	
        $sql = "SELECT SQL_CALC_FOUND_ROWS PK1,PK1,TITULO,DESCRIPCION,ADJUNTO,ACTIVO,FECHA_D,FECHA_H,PK1_CATEGORIA,FECHA_R FROM LINEAMIENTOS ";
		
		
		$AND = "";
		$WHERE = "";
		
		if(isset($_GET['q']) && $_GET['q']!= ""){
		    
			$sql .= "WHERE (TITULO LIKE '%".$_GET['q']."%') ";	
		    $AND = "AND";
		     $WHERE = "";
		}else{
			
		$AND = "";
		$WHERE = "WHERE";
		}
		
		if(isset($_GET['filter'])){
			
			$filter = "'".str_replace(";","','",$_GET['filter'])."'";

		    
			$sql .= "$WHERE $AND PK1_CATEGORIA IN($filter) ";	
		}
		
		
		if(isset($_GET['sort'])){
		    
			switch($_GET['sort']){
				case 1:
				$sql .= "ORDER BY FECHA_R DESC ";	
				break;
			}
			
		}
	
		$sql .= "LIMIT $offset, $limit";
	
 
	
		$sqlTotal = "SELECT FOUND_ROWS() as total";
       
		$objdb = new database();
		$result = $objdb->executeQuery($sql);
		
		$rsTotal = $objdb->executeQuery($sqlTotal);
		$rowTotal = mysql_fetch_assoc($rsTotal);
        // Total de registros sin limit
        $total = $rowTotal["total"];
		$this->totalnum = $total;
	
	
	    while ($row = mysql_fetch_array($result)) {
		
	   $this->lineamientos[] = $row;
		
        }
		
		//CALCULAMOS EL TOTAL DE PAGINAS
		$this->totalPag = ceil($total/$limit);


	   }	
	   
	   
	   
		
		function getRecurso($id){
		
		$sql = "SELECT * FROM CONTENIDOS WHERE PK1='$id'";   
		$objdb = new database();
	    $row = $objdb->getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		


        function getNoticia($id){
	
        $sql = "SELECT * FROM NOTICIAS WHERE PK1='$id'";   
		$objdb = new database();
	    $row = $objdb->getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}
		
		function getLineamiento($id){
	
        $sql = "SELECT * FROM LINEAMIENTOS WHERE PK1='$id'";   
		$objdb = new database();
	    $row = $objdb->getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}
	
}

?>