<?php

include "phpQS_Class.php";

define('STORAGE_ACCOUNT_CONTAINER', 'https://seruabackup.blob.core.windows.net');
define('CONTAINER_NAME', 'docs-planeacion');
define('CONNECTION_STRING', 'DefaultEndpointsProtocol=https;AccountName=seruabackup;AccountKey=mno/n6tZ+eP5FCzgwip1r44+gxDmuA13UfebKn23/qQBJ5PQ34M5KMyjSc5kzwwwGGJ72KfxjP4nN38047eNAg==;');
define('KEY_ACCESS_BLOBS','?sv=2018-03-28&si=docs-planeacion-1697E9B3AB3&sr=c&sig=6mRMpNQ2SOvpwscWt7MljXyNaaPwLPS2cdMN3ARK6mQ%3D');



 //$containerName = "docs-planeacion";
 //$fileToUpload = "HelloWorld.txt";
 
   //$fileToUpload = "file5a00f0f04530b.pdf";
 //  $fileToUpload = "img_iurd2.jpg";
   //$ruta = "/carpeta2";
   
    $ruta_destino="/media/evidencias";
   $ruta_destino2="media/evidencias/";
       $fileToUpload ="img5c926eb7c6f92.png";
	    //$fileToUpload ="img5c929c1323d7a.jpg";
	 
	  
	   
	   
	   echo "destino2: ".substr(  $ruta_destino2, 0, -1);
   
 
 //$connectionString="DefaultEndpointsProtocol=https;AccountName=seruabackup;AccountKey=mno/n6tZ+eP5FCzgwip1r44+gxDmuA13UfebKn23/qQBJ5PQ34M5KMyjSc5kzwwwGGJ72KfxjP4nN38047eNAg==;";

   $object_Blob = new phpQS();
   
   $object_Blob->cargandoBlob($fileToUpload,getcwd()."\\",$ruta_destino);//comuenza con  /  la ruta
 
   $object_Blob->obtenerlistadoBlobs();
  
 //$object_Blob->obtenerBlob($fileToUpload);   
  
  //$object_Blob->deleteBlob($fileToUpload,"/carpeta2/");////comuenza con /
  
  
  $storage = STORAGE_ACCOUNT_CONTAINER."/".CONTAINER_NAME."/".$ruta_destino2.$fileToUpload.KEY_ACCESS_BLOBS;



?>




<img src="<?php echo $storage; ?>" id="thumb_42-35185762" class="search-results-image">


<!--<img src="https://seruabackup.blob.core.windows.net/docs-planeacion/acta.jpg?sv=2018-03-28&si=docs-planeacion-1697E9B3AB3&sr=c&sig=6mRMpNQ2SOvpwscWt7MljXyNaaPwLPS2cdMN3ARK6mQ%3D" id="thumb_42-35185762" class="search-results-image">

</br>

<a href="https://seruabackup.blob.core.windows.net/docs-planeacion/acta.jpg?sv=2018-03-28&si=docs-planeacion-1697E9B3AB3&sr=c&sig=6mRMpNQ2SOvpwscWt7MljXyNaaPwLPS2cdMN3ARK6mQ%3D">Link</a>-->








