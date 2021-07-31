<?php
/*
Made 7/19/21
-Requires a Google Geocoding API key
Call class like: $geo = new Geocode(apiKey);
*/
class Geocode{
	protected $callurl = "https://maps.googleapis.com/maps/api/geocode/json";
	protected $key;
	protected $debug;

	//constructor for object
	function __construct($key, $debug = 0){
		$this->key = $key;
		$this->debug = $debug;
	}

	//curl request for Geocoding call
	function geoRequest($url, $parameters){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url . "?" . http_build_query($parameters));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		return $result;
	}

	//returns a string of the address of the given coords
	function getAddress($latitude, $longitude){
		$data = [
			'latlng' => "$latitude,$longitude",
			'key' => $this->key
		];		
		$address = $this->geoRequest($this->callurl, $data);
		return (json_decode($address)->results[0]->formatted_address);
	}

}

?>
