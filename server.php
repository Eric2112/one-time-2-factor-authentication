<?php
	// prevent CORS conflicts
	header("Access-Control-Allow-Origin: *");

	/**	
	* Get parameter from URL using $_GET. Checks if it is set.
	*
	* @param  string  parameterName    name of parameter to get
	*
	* @return string  parameter
	*/
	function getUrlParameter($parameterName) {

		$parameter = null;

		if (isset($_GET[$parameterName]))
			$parameter = $_GET[$parameterName];

		return $parameter;
	}
	/**
	* Gets the POST headers that were sent (at the moment it only gets the ID and the title)
	*
	* @return string   data  the POST headers
	*/
	function loadHeaders() {

		$id    = "original_id";
		$title = "title";
		
		return $id . $_POST[$id] . "&" . $title . $_POST[$title];
	}

	/**
	* Retrieves the response from a forwarded HTTP get request
	*
	* @param  string  url   URL under which the response to retrieve is available
	*
	* @return string  response
	*/
	function forwardGetRequest($url) {

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
			CURLOPT_SSL_VERIFYPEER => false
		));

		$response = curl_exec($curl);
		if ($response === false) echo "Bad response";

		curl_close($curl);
		return $response;
	}

	/**
	* Retrieves the response from a forwarded HTTP post request
	*
	* @param  string   url    URL under which the response to retrieve is available
	* @param  string   data   the POST data to send
	*
	* @return string   response
	*/
	function forwardPostRequest($url, $data) {
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
			CURLOPT_SSL_VERIFYPEER => false
		));

		$response = curl_exec($curl);
		if ($response === false) echo "Bad response";

		curl_close($curl);
		return $response;
	}

	// retrieve parameters
	$url  = getUrlParameter("u");
	$type = getUrlParameter("t");

	if ($type == "g") $response = forwardGetRequest($url);
	else {
		$data     = loadHeaders();
		$response = forwardPostRequest($url, $data);
	}

?>
<?=$response?>
