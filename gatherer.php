<?php 

	/* this is a faux resource pretending to use cURL to access some database
	*/
	
	class Gatherer {

	

		static function RetrieveJson($url){

			//ignore the $url, this is fake, afterall!
			//we're just actually grabbing some json
			return file_get_contents("data.json");
			
		}

	}