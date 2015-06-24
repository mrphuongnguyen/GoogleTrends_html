<?php

include_once('class.db.php');

class Agenda{

	var $_tipos_agenda 	= array(

								"Televisa" => 0,
								"Telecom" => 1,
								"Politica" => 2
								);

	var $_agenda_id = false;


	function __contruct(){

		$this->setAgenda( "Televisa" );

	}	



	public function setAgenda( $agenda ){

		if (isset( $this->_tipos_agenda[ $agenda ] ) ){

			$this->_agenda_id = $this->_tipos_agenda[ $agenda ];

		}else{

			$this->_agenda_id = false;


		}

	}



}




?>