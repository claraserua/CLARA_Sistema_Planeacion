<?php

require_once 'vendor/autoload.php';
require_once "random_string.php";

//require 'Microsoft\WindowsAzure\Storage\Blob.php'; 

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;


class phpQS {	
	
	var $connectionString;
	var $blobClient;
	var $fileToUpload;
	var $containerName;	
		
	
	function phpQS($containerName_ = CONTAINER_NAME, $connectionString_ = CONNECTION_STRING) {
		
	try {	
			$this->containerName = $containerName_;			
			$this->connectionString=$connectionString_;
			//$this->connectionString="DefaultEndpointsProtocol=https;AccountName=seruabackup;AccountKey=mno/n6tZ+eP5FCzgwip1r44+gxDmuA13UfebKn23/qQBJ5PQ34M5KMyjSc5kzwwwGGJ72KfxjP4nN38047eNAg==;";
			$this->blobClient = BlobRestProxy::createBlobService($this->connectionString);
		
		
		}
		catch(ServiceException $e){
				// Handle exception based on error codes and messages.
				// Error codes and messages are here:
				// http://msdn.microsoft.com/library/azure/dd179439.aspx
				$code = $e->getCode();
				$error_message = $e->getMessage();
				echo $code.": ".$error_message."<br />";
		}
			
		
	}	
	
	
	
	function cargandoBlob($fileToUpload_, $ruta_origen, $ruta_destino){
		
		
		 try {
			 
			$this->fileToUpload = $fileToUpload_;
			
			 $createContainerOptions = new CreateContainerOptions();
			 $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

			 // Set container metadata.
			// $createContainerOptions->addMetaData("key1", "value1");		
			// $createContainerOptions->addMetaData("key2", "value2");			 
		
			
			# Upload file as a block blob
			//echo "Uploading BlockBlob: ".PHP_EOL;
			//echo $ruta_origen;
			//echo "<br />";			
		
			
		  // $content = fopen( "D:\\home\\site\\wwwroot\\app\\planeacion\\core\\storage-blobs-php-quickstart\\".$this->fileToUpload, "r");	
            $content = fopen( $ruta_origen.$this->fileToUpload, "r");		  
			

			//Upload blob
			$this->blobClient->createBlockBlob($this->containerName.$ruta_destino, $this->fileToUpload, $content);
			//fclose($content);
			
			}
		catch(ServiceException $e){
			// Handle exception based on error codes and messages.
			// Error codes and messages are here:
			// http://msdn.microsoft.com/library/azure/dd179439.aspx
			$code = $e->getCode();
			$error_message = $e->getMessage();
			echo $code.": ".$error_message."<br />";
		}
		catch(InvalidArgumentTypeException $e){
			// Handle exception based on error codes and messages.
			// Error codes and messages are here:
			// http://msdn.microsoft.com/library/azure/dd179439.aspx
			$code = $e->getCode();
			$error_message = $e->getMessage();
			echo $code.": ".$error_message."<br />";
		}		
		
		
	}
	
	
	
	function obtenerBlob($fileToUpload_,$ruta=""){
		
	try {	
		$this->fileToUpload = $fileToUpload_;
		
	   // echo "This is the content of the blob uploaded: ";
		 $blob = $this->blobClient->getBlob($this->containerName.$ruta, $this->fileToUpload);		
        
		header("Content-type: application/image/jpeg");
        header("Content-Disposition: attachment; filename=\"".$this->fileToUpload."\"\n");
        // $fp=fopen("$f", "r");
		 
		 
        return fpassthru($blob->getContentStream());
       // echo "<br />";
	   
	  // return  $blob;
		
		
		//$blobUrl = 'azure://'.$_GET['container'].'/'.$_GET['blobname']; 
		
		/*$blobUrl = 'azure://'.$this->containerName.'/'.$this->fileToUpload; 
		
		$this->blobClient->registerStreamWrapper(); 
		$fileHandle = fopen($blobUrl, 'r'); 
		fpassthru($fileHandle);*/
				
		}
		catch(ServiceException $e){
			// Handle exception based on error codes and messages.
			// Error codes and messages are here:
			// http://msdn.microsoft.com/library/azure/dd179439.aspx
			$code = $e->getCode();
			$error_message = $e->getMessage();
			echo $code.": ".$error_message."<br />";
		}
				
	}
	
	
	
	function obtenerlistadoBlobs(){
		
		
		
	try {
		//$this->fileToUpload = $fileToUpload_;
		
		  // List blobs.
        $listBlobsOptions = new ListBlobsOptions();
        //$listBlobsOptions->setPrefix("HelloWorld");

        echo "These are the blobs present in the container: ";

        do{
            $result = $this->blobClient->listBlobs($this->containerName, $listBlobsOptions);
            foreach ($result->getBlobs() as $blob)
            {
                echo "<br />".$blob->getName().": ".$blob->getUrl()."<br />";
            }
        
            $listBlobsOptions->setContinuationToken($result->getContinuationToken());
        } while($result->getContinuationToken());
        echo "<br />";

       
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
    catch(InvalidArgumentTypeException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
		
		
	 
		
		
	}
	
	
	
	function deleteBlob($fileToUpload_,$ruta=""){
		
		try{
				$this->fileToUpload = $fileToUpload_;
				
				//echo "<br />Deleting Blob".PHP_EOL;
				//echo $this->fileToUpload;
				//echo "<br />";
				$this->blobClient->deleteBlob($this->containerName.$ruta, $this->fileToUpload);
			} catch(ServiceException $e){
	        // Handle exception based on error codes and messages.
	        // Error codes and messages are here:
	        // http://msdn.microsoft.com/library/azure/dd179439.aspx
	        $code = $e->getCode();
	        $error_message = $e->getMessage();
	        echo $code.": ".$error_message."<br />";
	    }
						
		
				
	}
	
	
	//descargar
	
	//eliminar
	
	//listar
	
	
	
	
	
	
	
	
}








?>


