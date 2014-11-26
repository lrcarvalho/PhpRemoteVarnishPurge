<?php
	
	/*
	 * Remote URL Vanish purge
	 * This script was created to enable a easy way to purge remote varnish application. This is usable only in case of remote purge is enabled.
	 * This script was made to run in terminal
	 * Arguments 
	 * $argv[1]	URL to purge.
	 * Usage: php php_varnish_purge.php http://url_to_purge
	 */


	
	define("DEFAULT_LOG_DIRECTORY",	'logs');
	
	if (!empty($argv[1])) {

		//Avoid any return to terminal
		ob_start();

		$curl = curl_init($argv[1]);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PURGE");
		$result = curl_exec($curl);
		$contents = ob_get_contents();

		ob_end_clean();

		if (!empty($contents)) {
		
			$sanitizedUrl = str_ireplace(array('http://', 'https://'), '', $argv[1]);
			$sanitizedUrl = str_ireplace(array("/"), '-', $sanitizedUrl);
			$file = escapeshellcmd(
						getcwd() . 
						DIRECTORY_SEPARATOR . 
						DEFAULT_LOG_DIRECTORY . 
						DIRECTORY_SEPARATOR . 
						date("Y-m-d_H-i-s") . 
						"_" . 
						$sanitizedUrl . 
						".log"
					); 
			file_put_contents($file,$contents);
		}
		


		if ($result == true) {
			echo "\nRemote Varnish purge for " . $argv[1] . "executed with success!\n";
		} else {
			echo "\nWas not possible to purge remote url (" . $argv[1] . ")\n";
		}

		echo "\nPlease verify the output log in " . $file . "\n;

	} else {
		echo "\nMissing URL parameter! (Enter URL as http://url_to_purge or https://url_to_purge)\n";
	}
?>
