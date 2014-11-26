<?php
# I'm "/var/www/html/remote_varnish_purge.php" on host "1.2.3.4".'
# AGIX: Script to flush Varnish cache on remote system.
####
$curl = curl_init("http://url/");
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PURGE");
curl_exec($curl);
?>