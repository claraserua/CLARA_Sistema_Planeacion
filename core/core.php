<?php


class Core {
 
    /**
     * Colecci�n de objetos
     * @access private
     */
    private static $objects = array();
 
    /**
     * Colecci�n de ajustes
     * @access private
     */
    private static $settings = array();
 
    /**
     * El nombre de nuestro framework y versi�n
     * @access private
     */
    private static $frameworkName = 'Framework ver. 0.1';
 
    /**
     * La instancia del registro
     * @access private
     */
    private static $instance;
 
    /**
     * Constructor privado para evitar que se creen directamente
     * @access private
     */
    private function __construct()
    {
 
    }
 
    /**
     * Utilizamos el m�todo singleton para acceder a los objetos
     * @access public
     * @return
     */
    public static function singleton()
    {
        if( !isset( self::$instance ) )
        {
            $obj = __CLASS__;
            self::$instance = new $obj;
        }
 
        return self::$instance;
    }
 
    /**
     * Impedir la clonaci�n de los objetos: issues an E_USER_ERROR if this is attempted
     */
    public function __clone()
    {
        trigger_error( 'La clonaci�n del registro no est� permitida.', E_USER_ERROR );
    }
 
    /**
     * Almacena un objeto en el registro
     * @param String $object el nombre del objeto
     * @param String $key el �ndice del array
     * @return void
     */
    public function storeObject( $object, $key )
    {
        require_once('objects/' . $object . '.class.php');
        self::$objects[ $key ] = new $object( self::$instance );
    }
 
    /**
     * Obtiene un objeto del registro
     * @param String $key el �ndice del array
     * @return object
     */
    public function getObject( $key )
    {
        if( is_object ( self::$objects[ $key ] ) )
        {
            return self::$objects[ $key ];
        }
    }
 
    /**
     * Almacena los ajustes en el registro
     * @param String $data
     * @param String $key el �ndice del array
     * @return void
     */
    public function storeSetting( $data, $key )
    {
        self::$settings[ $key ] = $data;
 
    }
 
    /**
     * Obtiene un ajuste del registro
     * @param String $key el �ndice del array
     * @return void
     */
    public function getSetting( $key )
    {
        return self::$settings[ $key ];
    }
 
    /**
     * Obtiene el nombre del framework
     * @return String
     */
    public function getFrameworkName()
    {
        return self::$frameworkName;
    }
 
}
 
?>