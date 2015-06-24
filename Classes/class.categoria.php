<?php

include_once( 'class.agenda.php' );

Class Categoria extends Agenda{


	var $_tipos_categoria		= array(
										"0" => array(

												"Marca / Productos" => 0,
												"Empresa" => 1,
												"Anchors" => 2,
												"Directivos" =>4
												)	
										);

	
	var $_categoria 			= array();




	public function getCategoria(){
		
		return $this->_categoria = $this->_tipos_categoria[ $this->_agenda_id ];

	}


	public function getKeyCategoriaByID( $id ){

		foreach ($this->_categoria as $key => $value) {

			if( $id ==  $value){

				return $key;
				break;
			}

			# code...
		}


	}



}



?>