<?php

include_once( 'class.categoria.php' );


Class Concepto extends Categoria{


	var $_tipos_concepto	= array(
									"Base" => 0,
									"Coyontura" => 1
									);

	var $_concepto_id 		= false;


	function __contruct(){

		$this->setConcepto( "Base" );

	}

	
	public function setConcepto( $concepto ){

		if ( isset ( $this->_tipos_concepto[ $concepto ] ) ){
			
			
			$this->_concepto_id = $this->_tipos_concepto[ $concepto ];

		}else{

			$this->_concepto_id = false;


		}

	}

}

?>