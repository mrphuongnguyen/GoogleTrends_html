<?php
// Clase encargada de  leer el feed y retornalo en un array

class GoogleTrendsApi{

	var $url 					= "http://www.google.com/trends/hottrends/atom/feed?pn=p21";
	// Contiene el cuerpo del documento XML
	var $_xml_buffer;
	// Array con todos los items por parte de Google Trends
	var $_items_by_trends;
	// Items seleccionado para su tratamiento y entrega de datos
	var $_selected_item;
	var $_selected_souce;	


	
	// Obtenemos en un una variable el objeto XML
	public function getXMLBuffer(){

		$referrer 	= 'http://www.google.com';
		$agent 		= 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);

		$this->_xml_buffer = curl_exec($ch);
		//print_r($this->_xml_buffer);
		//echo "Listo";
		
	}

	// Funcion cambia atributos en el feeds
	public function convertXMLAttributes(){

		$this->_xml_buffer = str_replace("ht:", "ht_", $this->_xml_buffer);

	}


	public function getAllItems(){

		// Obtenemos el XML dentro de un buffer
		$this->getXMLBuffer();
		$this->convertXMLAttributes();

		$trends = new SimpleXmlElement($this->_xml_buffer);
		// Incluimos en un arreglo todos los items
		foreach ($trends->channel->item as $key => $value) {
			
			$this->_items_by_trends[] = $value;

		}
	
		//print_r($this->_items_by_trends);

	}

	public function totalItemsInFeed(){

		return count($this->_items_by_trends);
	}


	// Metodo encargado de seleccionar un Item en especeficico
	// Con el extremos los datos
	public function selectItem($item){

		$this->_selected_item = $this->_items_by_trends[$item];

	}


	public function getTitle(){

		return $this->_selected_item->title;
	}

	public function getDescription(){

		return $this->_selected_item->description;
	}

	public function getLink(){

		return $this->_selected_item->link;
	}

	public function getpubDate($format = false){

		if($format){
			#Tue, 02 Jun 2015 13:00:00 -0500
			$fecha = $this->_selected_item->pubDate;
			$fecha_explode 	= explode(",", $fecha);
			$fecha_d_m_s	= $fecha_explode[1];
			$miFecha		= explode(" ", $fecha_d_m_s);

			$dia			= $miFecha[1];
			$mes			= $miFecha[2];
			$annio			= $miFecha[3];
			 

			return $dia."/".$mes."/".$annio;
		}else{

			return $this->_selected_item->pubDate;
		}
	}

	public function gethtPicture(){

		return $this->_selected_item->ht_picture;
	}

	public function gethtPictureSource(){

		return $this->_selected_item->ht_picture_source;
	}

	public function gethtApproxTraffic(){

		return $this->_selected_item->ht_approx_traffic;
	}


	public function totalItemsInBySource(){

		print_r($this->_selected_item->ht_news_item);
		return count($this->_selected_item->ht_news_item);
	}

	// Seleccionamos la fuente que queremos mostrar
	public function selectNewsItem( $souce = 0 ){

		$this->_selected_souce = $this->_selected_item->ht_news_item[$souce];

	}


	public function gethtNewsItemTitle(){

		return $this->_selected_souce->ht_news_item_title;

	}

	public function gethtNewsItemSnippet(){

		return $this->_selected_souce->ht_news_item_snippet;
	}

	public function gethtNewsItemURL(){

		return $this->_selected_souce->ht_news_item_url;
	}

	public function gethtNewsItemSource(){

		return $this->_selected_souce->ht_news_item_source;
	}


}


?>